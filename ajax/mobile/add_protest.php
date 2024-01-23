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
$user_id = $data->user_id;

$response = array();

if (isset($event_id)) {
    $user_token = ($user_token == "" || $user_token == null || $user_token == "undefined") ? generateRandomString(5) : $user_token;

    $fetch_count = $mysqli->query("SELECT count(protest_id) from tbl_protests WHERE user_id='$user_id' and event_id='$event_id' ");
    $count_row = $fetch_count->fetch_array();

    if ($count_row[0] > 0) {
        $response['response'] = -1;
        $response['user_token'] = $user_token;
    } else {
        $fetch_event = $mysqli->query("SELECT * from tbl_events WHERE event_id='$event_id'");
        $event_row = $fetch_event->fetch_array();
        $event_start = $event_row['event_start'];
        $protest_hrs = $event_row['protest_hrs'];

        $date_now = date("Y-m-d H:i:s");
        $date_end = date("Y-m-d H:i:s", strtotime("$event_start +$protest_hrs hours"));

        if ($date_now > $date_end) {
            $response['response'] = -2;
            $response['user_token'] = $date_end; //$user_token;
        } else {
            $sql = $mysqli->query("INSERT INTO tbl_protests (user_token, event_id, protest, user_id) VALUES ('$user_token', '$event_id', '$protest', '$user_id') ");
            if ($sql) {
                $response['response'] = 1;
                $response['user_token'] = $user_token;
            } else {
                $response['response'] = 0;
                $response['user_token'] = $user_token;
            }
        }
    }

    echo json_encode($response);
}
