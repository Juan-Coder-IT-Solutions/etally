<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: *");
header('Content-Type: text/html; charset=utf-8');

include '../../core/config.php';


$sql = "SELECT * FROM tbl_event_judges ej LEFT JOIN tbl_events e ON ej.event_id=e.event_id WHERE judge_id=1";
$fetch = $mysqli->query($sql);

$response = array();

while ($row = $fetch->fetch_assoc()) {
    array_push($response, $row);
}

echo json_encode($response);
