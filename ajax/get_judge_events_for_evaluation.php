<?php
include '../core/config.php';

$event_id = (int) $_POST['event_id'];

$sql = "SELECT * FROM tbl_event_participants WHERE event_id = '$event_id'";
$fetch = $mysqli->query($sql);
$response['participants'] = array();
while ($row = $fetch->fetch_assoc()) {

    $criterias = [];
    $fetch_criteria = $mysqli->query("SELECT * FROM tbl_event_criterias WHERE event_id = '$event_id'");
    while ($row_criteria = $fetch_criteria->fetch_assoc()) {
        $row_criteria['criteria'] = str_replace("\n","<br>",str_replace("\r","&#13;",$row_criteria['criteria']));
        array_push($criterias, $row_criteria);
    }

	$row['criterias'] = $criterias;
	$row['participant_name'] = getParticipantName($row['participant_id']);
	array_push($response['participants'], $row);
}

echo json_encode($response);