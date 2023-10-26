<?php
include '../core/config.php';

$inject = isset($_POST["params"]) ? $_POST["params"] : "";
$sql = "SELECT * FROM tbl_protests $inject";
$fetch = $mysqli->query($sql);

$response['data'] = array();

$count = 1;
while ($row = $fetch->fetch_assoc()) {
    $row['count'] = $count++;
    $row['time_past'] = getTimeAgo($row['date_added']);
    $row['event_name'] = getEventData($row['event_id']);
	array_push($response['data'], $row);
}

echo json_encode($response);
