<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: *");
header('Content-Type: text/html; charset=utf-8');

include '../../core/config.php';

$data = json_decode(file_get_contents("php://input"));
$event_id = $data->event_id;

if (isset($event_id)) {
    $fetch = $mysqli->query("SELECT event_end FROM tbl_events WHERE event_id='$event_id'");
    $row = $fetch->fetch_assoc();
    echo $row['event_end'];
}
