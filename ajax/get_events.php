<?php
include '../core/config.php';

$inject = isset($_POST["params"]) ? $_POST["params"] : "";
$sql = "SELECT * FROM tbl_events $inject";
$fetch = $mysqli->query($sql);

$response['data'] = array();

$count = 1;
while ($row = $fetch->fetch_assoc()) {
    $row['participants'] = countEventParticipants($row['event_id']);
    $row['judges'] = countEventJudges($row['event_id']);
    $row['count'] = $count++;
	array_push($response['data'], $row);
}

echo json_encode($response);
