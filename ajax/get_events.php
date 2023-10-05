<?php
include '../core/config.php';

$sql = "SELECT * FROM tbl_events";
$fetch = $mysqli->query($sql);

$response['data'] = array();

while ($row = $fetch->fetch_assoc()) {
    $row['participants'] = rand(1,$row['participant_needed']);
	array_push($response['data'], $row);
}

echo json_encode($response);
