<?php
include '../core/config.php';

$inject = isset($_POST["params"]) ? $_POST["params"] : "";
$sql = "SELECT * FROM tbl_event_participants $inject";
$fetch = $mysqli->query($sql);

$response['data'] = array();

while ($row = $fetch->fetch_assoc()) {
	$row['participant_name'] = getParticipantName($row['participant_id']);
	$row['participants'] = getParticipantData($row['participant_id'],['participant_name','participant_year','program_id','participant_img']);
	$row['program_name'] = getProgramData($row['participants']['program_id']);
	array_push($response['data'], $row);
}

echo json_encode($response);
