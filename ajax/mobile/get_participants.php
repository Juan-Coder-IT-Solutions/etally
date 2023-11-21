<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: *");
header('Content-Type: text/html; charset=utf-8');

include '../../core/config.php';

$data = json_decode(file_get_contents("php://input"));
$event_id = $data->event_id;
$judge_id = $data->user_id;

if (isset($event_id) && isset($judge_id)) {
    $sql = "SELECT * FROM tbl_participants p LEFT JOIN tbl_event_participants ep ON p.participant_id=ep.participant_id LEFT JOIN tbl_programs pr ON p.program_id=pr.program_id WHERE event_id='$event_id'";
    $fetch = $mysqli->query($sql);

    $response = array();

    while ($row = $fetch->fetch_assoc()) {
        $list = array();

        $list['participant_id'] = $row['participant_id'];
        $list['participant_name'] = $row['participant_name'];
        $list['participant_affiliation'] = $row['participant_affiliation'];
        $list['participant_img'] = $row['participant_img'];
        $list['program'] = $row['program_name'];

        $response_criteria_header = array();
        $fetch_criteria_header = $mysqli->query("SELECT * from tbl_event_criteria_header WHERE event_id='$event_id'");
        while ($criteria_header_row = $fetch_criteria_header->fetch_assoc()) {
            $fetch_criteria = $mysqli->query("SELECT * from tbl_event_criterias WHERE event_id='$event_id' and ch_id='$criteria_header_row[ch_id]'");
            $list_header = array();
            $list_header = $criteria_header_row;

            $response_criteria = array();
            while ($criteria_row = $fetch_criteria->fetch_assoc()) {
                $list_criteria = array();
                $list_criteria['participant_criteria_id'] = $row['participant_id'] . "-" . $criteria_row['criteria_id'];
                $list_criteria['criteria_id'] = $criteria_row['criteria_id'];
                $list_criteria['criteria'] = $criteria_row['criteria'];
                $list_criteria['total_points'] = floor($criteria_row['points']);

                $fetch_score = $mysqli->query("SELECT points from tbl_event_scores WHERE event_id='$event_id' and participant_id='$row[participant_id]' and judge_id='$judge_id' and criteria_id='$criteria_row[criteria_id]' ");
                $row_score = $fetch_score->fetch_array();
                $list_criteria['score'] = $fetch_score->num_rows > 0 ? floor($row_score['points']) : 0;
                array_push($response_criteria, $list_criteria);
            }

            $list_header['criteria_details'] = $response_criteria;

            array_push($response_criteria_header, $list_header);
        }

        $list['criteria'] = $response_criteria_header;


        array_push($response, $list);
    }

    echo json_encode($response);
}
