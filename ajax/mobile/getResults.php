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
    $list_chart_data = array();


    $fetch_participants = $mysqli->query("SELECT participant_name, participant_affiliation from tbl_participants p LEFT JOIN tbl_event_participants ep ON p.participant_id=ep.participant_id WHERE event_id='$row[event_id]'");
    while ($participants_row = $fetch_participants->fetch_assoc()) {
        $list_scores = array();
        $list_scores['participant_name'] = $participants_row['participant_name'] . " (" . $participants_row['participant_affiliation'] . ")";
        $list_scores['participant_affiliation'] = $participants_row['participant_affiliation'];
        $list_scores['participant_overall_score'] = 100;
        array_push($list_chart_data, $list_scores);
    }

    $list['event_judge_id'] = $row['event_judge_id'];
    $list['event_name'] = $row['event_name'];
    $list['event_start'] = date("M d, Y", strtotime(($row['event_start'])));
    $list['status'] = $row['event_status'];
    $list['participant_results'] = $list_chart_data;

    array_push($response, $list);
}

echo json_encode($response);