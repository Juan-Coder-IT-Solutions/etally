<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: *");
header('Content-Type: text/html; charset=utf-8');

include '../../core/config.php';

$data = json_decode(file_get_contents("php://input"));
$event_id = $data->event_id;
$judge_id = $data->user_id;

if (isset($event_id) && isset($judge_id)) {
    $sql = "SELECT * FROM tbl_participants p LEFT JOIN tbl_event_participants ep ON p.participant_id=ep.participant_id WHERE event_id='$event_id'";
    $fetch = $mysqli->query($sql);

    $response = array();

    while ($row = $fetch->fetch_assoc()) {
        $list = array();


        $list['participant_id'] = $row['participant_id'];
        $list['participant_name'] = $row['participant_name'];
        $list['participant_affiliation'] = $row['participant_affiliation'];
        $list['participant_result'] = $row['rank'];

        $response_ranks = array();
        $fetch_ranks = $mysqli->query("SELECT * from tbl_event_ranks WHERE event_id='$event_id' and participant_id='$row[participant_id]' ORDER BY rank_id ASC");
        $total_rank = 0;
        while ($ranks_row = $fetch_ranks->fetch_assoc()) {
            $list_ranks = array();
            $list_ranks['rank'] = $ranks_row['rank'];
            $total_rank += $ranks_row['rank'];
            $list_ranks['scores'] = $ranks_row['scores'];
            array_push($response_ranks, $list_ranks);
        }

        $list['total_rank'] = $total_rank;
        $list['ranks'] = $response_ranks;


        array_push($response, $list);
    }

    echo json_encode($response);
}
