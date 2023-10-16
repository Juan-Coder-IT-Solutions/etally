<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: *");
header('Content-Type: text/html; charset=utf-8');

include '../../core/config.php';

$data = json_decode(file_get_contents("php://input"));
$event_id = $data->event_id;

$response_criteria = array();
$fetch_criteria = $mysqli->query("SELECT * from tbl_event_criterias WHERE event_id='$event_id'");
while ($criteria_row = $fetch_criteria->fetch_assoc()) {
    $list_criteria = array();
    $list_criteria['criteria_id'] = $criteria_row['criteria_id'];
    $list_criteria['criteria'] = $criteria_row['criteria'];
    $list_criteria['points'] = $criteria_row['points'];
    array_push($response_criteria, $list_criteria);
}

$sql = "SELECT * FROM tbl_participants p LEFT JOIN tbl_event_participants ep ON p.participant_id=ep.participant_id WHERE event_id='$event_id'";
$fetch = $mysqli->query($sql);

$response = array();
while ($row = $fetch->fetch_assoc()) {
    $list = array();
    $list['participant_id'] = $row['participant_id'];
    $list['participant_name'] = $row['participant_name'];
    $list['participant_affiliation'] = $row['participant_affiliation'];
    $list['criteria'] = $response_criteria;
    array_push($response, $list);
}

echo json_encode($response);
