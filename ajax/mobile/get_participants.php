<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: *");
header('Content-Type: text/html; charset=utf-8');

include '../../core/config.php';


$sql = "SELECT * FROM tbl_event_participants WHERE event_id='$event_id'";
$fetch = $mysqli->query($sql);

$response = array();

while ($row = $fetch->fetch_assoc()) {
    array_push($response, $row);
}

echo json_encode($response);
