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
    $sql = "SELECT * FROM tbl_participants p LEFT JOIN tbl_event_participants ep ON p.participant_id=ep.participant_id WHERE event_id='$event_id'";
    $fetch = $mysqli->query($sql);

    $response = array();

    while ($row = $fetch->fetch_assoc()) {
        $list = array();


        $list['participant_id'] = $row['participant_id'];
        $list['participant_name'] = $row['participant_name'];
        $list['participant_affiliation'] = $row['participant_affiliation'];

        $response_criteria = array();
        $fetch_criteria = $mysqli->query("SELECT * from tbl_event_criterias WHERE event_id='$event_id'");
        while ($criteria_row = $fetch_criteria->fetch_assoc()) {
            $list_criteria = array();
            $list_criteria['criteria_id'] = $criteria_row['criteria_id'];
            $list_criteria['criteria'] = $criteria_row['criteria'];
            $list_criteria['total_points'] = floor($criteria_row['points']);

            $fetch_score = $mysqli->query("SELECT points from tbl_event_scores WHERE event_id='$event_id' and participant_id='$row[participant_id]' and judge_id='$judge_id' and criteria_id='$criteria_row[criteria_id]' ");
            $row_score = $fetch_score->fetch_assoc();
            $list_criteria['score'] = floor($row_score['points']);
            array_push($response_criteria, $list_criteria);
        }

        $list['criteria'] = $response_criteria;


        array_push($response, $list);
    }

    echo json_encode($response);
}
