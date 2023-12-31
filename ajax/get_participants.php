<?php
include '../core/config.php';

$sql = "SELECT * FROM tbl_participants";
$fetch = $mysqli->query($sql);

$response['data'] = array();

while ($row = $fetch->fetch_assoc()) {
	$row['events'] = getParticipantEvents($row['participant_id']);
	$row['program_name'] = getProgramData($row['program_id']);
	array_push($response['data'], $row);
}

echo json_encode($response);
