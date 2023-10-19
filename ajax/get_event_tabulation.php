<?php
include '../core/config.php';

$inject = isset($_POST["params"]) ? $_POST["params"] : "";
$event_id = $_POST['event_id'];

$judge_ids = [];
$response['judges'] = array();
$fetch_judge = $mysqli->query("SELECT * FROM tbl_event_judges $inject ORDER BY judge_no ASC");
while ($row = $fetch_judge->fetch_assoc()) {
    $judge_ids[] = $row['judge_id'];
	array_push($response['judges'], $row);
}


$fetch_participant = $mysqli->query("SELECT * FROM tbl_event_participants $inject");
$response['data'] = array();
while ($row = $fetch_participant->fetch_assoc()) {

    $points = [];
    foreach($judge_ids as $judge_id){
        $points[] = getEventRanksData($event_id,"rank","AND participant_id = '$row[participant_id]' AND judge_id = '$judge_id'") * 1;
    }

    $row['points'] = $points;
    $row['ranks'] = array_sum($points);
    $row['result'] = $row['rank'];
    $row['participant_name'] = getParticipantName($row['participant_id']);
	array_push($response['data'], $row);
}

$response['has_tie'] = countEventTieBreakers($event_id);
echo json_encode($response);