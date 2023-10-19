<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: *");
header('Content-Type: text/html; charset=utf-8');

include '../../core/config.php';

$data = json_decode(file_get_contents("php://input"));
$user_id = $data->user_id;

if (isset($user_id)) {
    $sql = "SELECT e.event_id, ej.event_judge_id, e.event_name, e.event_description, e.event_start, e.event_status, e.event_mechanics FROM tbl_event_judges ej LEFT JOIN tbl_events e ON ej.event_id=e.event_id WHERE judge_id='$user_id' ORDER BY e.event_start DESC";
    $fetch = $mysqli->query($sql);

    $response = array();

    while ($row = $fetch->fetch_assoc()) {
        $list = array();
        $list['event_judge_id'] = $row['event_judge_id'];
        $list['event_id'] = $row['event_id'];
        $list['event_name'] = $row['event_name'];
        $list['event_mechanics'] = $row['event_mechanics'];
        $list['event_description'] = $row['event_description'];
        $list['event_start'] = date("M d, Y", strtotime(($row['event_start'])));
        $list['status'] = $row['event_status'];

        // fetch judges
        $list_judges_response = array();
        $fetch_judges = $mysqli->query("SELECT judge_name, judge_affiliation, judge_qualification, judge_img, ej.judge_no FROM tbl_event_judges ej LEFT JOIN tbl_judges j ON ej.judge_id=j.judge_id WHERE ej.event_id='$row[event_id]' ORDER BY ej.judge_no ASC");
        while ($judges_row = $fetch_judges->fetch_assoc()) {
            $list_judges = array();
            $list_judges['judge_name'] = $judges_row['judge_name'];
            $list_judges['judge_affiliation'] = $judges_row['judge_affiliation'];
            $list_judges['judge_qualification'] = $judges_row['judge_qualification'];
            $list_judges['judge_img'] = $judges_row['judge_img'];
            $list_judges['judge_no'] = $judges_row['judge_no'];
            array_push($list_judges_response, $list_judges);
        }

        $list['judges_row'] = $list_judges_response;

        array_push($response, $list);
    }

    echo json_encode($response);
}
