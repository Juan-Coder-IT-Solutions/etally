<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: *");
header('Content-Type: text/html; charset=utf-8');

include '../../core/config.php';

$data = json_decode(file_get_contents("php://input"));
$user_id = $data->user_id;

$sql = "SELECT * FROM tbl_event_judges ej LEFT JOIN tbl_events e ON ej.event_id=e.event_id WHERE judge_id='$user_id' ORDER BY e.event_start DESC";
$fetch = $mysqli->query($sql);

$response = array();

while ($row = $fetch->fetch_assoc()) {
    $list = array();
    $list['event_judge_id'] = $row['event_judge_id'];
    $list['event_name'] = $row['event_name'];
    $list['event_description'] = $row['event_description'];
    $list['event_start'] = date("M d, Y", strtotime(($row['event_start'])));
    $list['status'] = $row['event_status'];
    //S=Open For Registration;P=Ongoing;F=Finish
    array_push($response, $list);
}

echo json_encode($response);