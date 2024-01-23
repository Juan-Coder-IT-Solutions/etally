<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: *");
header('Content-Type: text/html; charset=utf-8');

include '../../core/config.php';

$data = json_decode(file_get_contents("php://input"));
$user_id = $data->user_id;

if (isset($user_id)) {
    $sql = "SELECT * FROM tbl_protests WHERE user_id='$user_id' ORDER BY date_added DESC";
    $fetch = $mysqli->query($sql);

    $response = array();

    while ($row = $fetch->fetch_assoc()) {
        $list = array();
        $list = $row;
        $fetch_event = $mysqli->query("SELECT * from tbl_events where event_id='$row[event_id]'");
        $event_row = $fetch_event->fetch_assoc();
        $list['event_name'] = $event_row['event_name'];
        array_push($response, $list);
    }

    echo json_encode($response);
}
