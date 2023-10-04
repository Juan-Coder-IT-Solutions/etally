<?php
include '../core/config.php';

$sql = "SELECT * FROM tbl_users";
$fetch = $mysqli->query($sql);

$response['data'] = array();

while ($row = $fetch->fetch_assoc()) {
	array_push($response['data'], $row);
}

echo json_encode($response);
