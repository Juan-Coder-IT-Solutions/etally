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

    $response['judges'] = array();
    $judges = [];
    $fetch_judges = $mysqli->query("SELECT judge_name, j.judge_id, ej.judge_no FROM tbl_event_judges ej LEFT JOIN tbl_judges j ON ej.judge_id=j.judge_id WHERE ej.event_id='$event_id' ORDER BY ej.judge_no ASC");
    while ($judges_row = $fetch_judges->fetch_assoc()) {
        $judges[] = $judges_row;
        array_push($response['judges'], $judges_row);
    }

    $fetch = $mysqli->query("SELECT * FROM tbl_participants p LEFT JOIN tbl_event_participants ep ON p.participant_id=ep.participant_id WHERE event_id='$event_id'");

    $response['data'] = array();
    $response['chart_data'] = array();
    while ($row = $fetch->fetch_assoc()) {
        $row['participant_result'] = $row['rank'];

        // fetch judges
        $response_judges = [];
        $total_rank = 0;
        foreach ($judges as $judges_row) {
            $fetch_ranks = $mysqli->query("SELECT * from tbl_event_ranks WHERE event_id='$event_id' and participant_id='$row[participant_id]' and judge_id='$judges_row[judge_id]'");
            $ranks_row = $fetch_ranks->fetch_assoc();
            $judges_row['scores'] = $ranks_row['scores'];
            $judges_row['rank'] = $ranks_row['rank'];
            $total_rank += $ranks_row['rank'];
            array_push($response_judges, $judges_row);
        }

        $row['total_rank'] = $total_rank;
        $row['ranks'] = $response_judges;

        // chart data
        $response_chart_data = [];
        $response_chart_data['participant_name'] = $row['participant_name'];
        $fetch_criteria = $mysqli->query("SELECT * from tbl_event_criterias WHERE event_id='$event_id'");
        while ($criteria_row = $fetch_criteria->fetch_assoc()) {

            $fetch_score = $mysqli->query("SELECT points from tbl_event_scores WHERE event_id='$event_id' and participant_id='$row[participant_id]' and criteria_id='$criteria_row[criteria_id]' ");
            $row_score = $fetch_score->fetch_array();
            $response_chart_data[$criteria_row['criteria_id']] = $fetch_score->num_rows > 0 ? floor($row_score['points']) : 0;
        }

        array_push($response['chart_data'], $response_chart_data);

        array_push($response['data'], $row);
    }

    echo json_encode($response);
}
