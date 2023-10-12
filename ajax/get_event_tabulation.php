<?php
include '../core/config.php';

$inject = isset($_POST["params"]) ? $_POST["params"] : "";

$judge_ids = [];
$response['judges'] = array();
$fetch_judge = $mysqli->query("SELECT * FROM tbl_event_judges $inject");
while ($row = $fetch_judge->fetch_assoc()) {
    $judge_ids[] = $row['judge_id'];
	array_push($response['judges'], $row);
}


$fetch_participant = $mysqli->query("SELECT * FROM tbl_event_participants $inject");
$response['data'] = array();
while ($row = $fetch_participant->fetch_assoc()) {

    $points = [];
    foreach($judge_ids as $judge_id){
        $points[] = rand(1,10);
    }

    $row['points'] = $points;
    $row['ranks'] = 1;
    $row['result'] = 1;
    $row['participant_name'] = getParticipantName($row['participant_id']);
	array_push($response['data'], $row);
}

echo json_encode($response);