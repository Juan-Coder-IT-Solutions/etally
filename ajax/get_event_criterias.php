<?php
include '../core/config.php';

$inject = isset($_POST["params"]) ? $_POST["params"] : "";
$sql = "SELECT * FROM tbl_event_criterias $inject";
$fetch = $mysqli->query($sql);

$response['data'] = array();

while ($row = $fetch->fetch_assoc()) {
	array_push($response['data'], $row);
}

echo json_encode($response);
