<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: *");
header('Content-Type: text/html; charset=utf-8');

include '../../core/config.php';

$data = json_decode(file_get_contents("php://input"));
$event_id = $data->event_id;
$judge_id = $data->user_id;

if (isset($event_id)) {

    $response = array();
    $response['criteria'] = array();
    $response['data'] = array();

    // fetch criteria
    $criteria = [];
    $fetch_criteria = $mysqli->query("SELECT ch_id, criteria, points FROM tbl_event_criteria_header WHERE event_id='$event_id' ORDER BY ch_id ASC");
    while ($criteria_row = $fetch_criteria->fetch_assoc()) {
        $fetch_count = $mysqli->query("SELECT count(criteria_id) FROM tbl_event_criterias WHERE ch_id='$criteria_row[ch_id]'");
        $count_row = $fetch_count->fetch_array();
        $criteria_row['criteria_details_count'] = $count_row[0];
        $criteria[] = $criteria_row;
        array_push($response['criteria'], $criteria_row);
    }

    $fetch_participants = $mysqli->query("SELECT ep.participant_id, p.participant_name, p.participant_affiliation, ep.rank FROM tbl_participants p LEFT JOIN tbl_event_participants ep ON p.participant_id=ep.participant_id WHERE event_id='$event_id'");

    $response_participants = array();
    $total_rank = 0;
    while ($participants_row = $fetch_participants->fetch_assoc()) {
        // $participants_row['participant_overall_rank'] = $participants_row['rank'];
        $fetch_ranks = $mysqli->query("SELECT * from tbl_event_ranks WHERE event_id='$event_id' and participant_id='$participants_row[participant_id]' and judge_id='$judge_id'");
        $ranks_row = $fetch_ranks->fetch_assoc();
        $participants_row['overall_total'] = $ranks_row['scores'];
        $participants_row['judge_rank'] = $ranks_row['rank'];
        $total_rank += $ranks_row['rank'];


        // fetch scores per criteria
        $response_scores = array();
        $total_crit_key = 10000;
        foreach ($criteria as $key => $value) {
            $fetch_criteria_details = $mysqli->query("SELECT criteria_id, criteria, points, ch_id FROM tbl_event_criterias WHERE ch_id='$value[ch_id]'");
            $total = 0;
            while ($criteria_details_row = $fetch_criteria_details->fetch_assoc()) {
                $fetch_scores = $mysqli->query("SELECT points from tbl_event_scores WHERE criteria_id='$criteria_details_row[criteria_id]' and event_id='$event_id' and participant_id='$participants_row[participant_id]' and judge_id='$judge_id' ");
                $points = $fetch_scores->fetch_array();
                $criteria_details_row['score'] = $points[0] * 1;
                $total += $points[0] * 1;

                array_push($response_scores, $criteria_details_row);
            }

            $total_score['ch_id'] = $total_crit_key++;
            $total_score['criteria_id'] = $total_crit_key++;
            $total_score['criteria'] = "Total";
            $total_score['score'] = $total;
            array_push($response_scores, $total_score);
        }

        $participants_row['score_details'] = $response_scores;


        array_push($response_participants, $participants_row);
    }

    $list['scores'] = $response_participants;
    array_push($response['data'], $list);

    echo json_encode($response);
}
