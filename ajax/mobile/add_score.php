<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: *");
header('Content-Type: text/html; charset=utf-8');

include '../../core/config.php';

$data = json_decode(file_get_contents("php://input"));
$judge_id = $data->user_id;
$event_id = $data->event_id;
$criteria_id = $data->criteria_id;
$participant_id = $data->participant_id;
$points = $data->points;

if ($data->user_id > 0) {
    $fetch_count = $mysqli->query("SELECT count(score_id) from tbl_event_scores WHERE event_id='$event_id' and criteria_id='$criteria_id' and participant_id='$participant_id' and judge_id='$judge_id' ");
    $count_row = $fetch_count->fetch_array();

    if ($count_row[0] == 0) {
        $sql = $mysqli->query("INSERT INTO `tbl_event_scores` (`event_id`, `criteria_id`, `judge_id`, `participant_id`, `points`) VALUES ('$event_id', '$criteria_id', '$judge_id', '$participant_id', '$points')");
    } else {
        $sql = $mysqli->query("UPDATE tbl_event_scores SET points='$points' WHERE event_id='$event_id' and criteria_id='$criteria_id' and participant_id='$participant_id' and judge_id='$judge_id' ");
    }

    if ($sql) {
        $response = 1;
    } else {
        $response = 0;
    }
}

echo json_encode($response);
