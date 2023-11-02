<?php
include '../core/config.php';

$inject = isset($_POST["params"]) ? $_POST["params"] : "";
$sql = "SELECT * FROM tbl_event_categories $inject";
$fetch = $mysqli->query($sql);

$response['data'] = array();

$count = 1;
while ($row = $fetch->fetch_assoc()) {
    $row['count'] = $count++;
	array_push($response['data'], $row);
}

echo json_encode($response);
