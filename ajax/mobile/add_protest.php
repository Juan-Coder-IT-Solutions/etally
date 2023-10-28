<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: *");
header('Content-Type: text/html; charset=utf-8');

include '../../core/config.php';

$data = json_decode(file_get_contents("php://input"));
$event_id = $data->event_id;
$protest = $data->protest;
$user_token = $data->user_token;

$response = array();

if (isset($event_id)) {
    $user_token = ($user_token == "" || $user_token == null || $user_token == "undefined") ? generateRandomString(5) : $user_token;

    $fetch_count = $mysqli->query("SELECT count(protest_id) from tbl_protests WHERE user_token='$user_token' and event_id='$event_id' ");
    $count_row = $fetch_count->fetch_array();

    if ($count_row[0] > 0) {
        $response['response'] = -1;
        $response['user_token'] = $user_token;
    } else {
        $sql = $mysqli->query("INSERT INTO tbl_protests (user_token, event_id, protest) VALUES ('$user_token', '$event_id', '$protest') ");
        if ($sql) {
            $response['response'] = 1;
            $response['user_token'] = $user_token;
        } else {
            $response['response'] = 0;
            $response['user_token'] = $user_token;
        }
    }

    echo json_encode($response);
}
