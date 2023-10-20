<?php
include '../core/config.php';

$inject = isset($_POST["params"]) ? $_POST["params"] : "";
$sql = "SELECT * FROM tbl_event_criteria_header $inject";
$fetch = $mysqli->query($sql);

$response['data'] = array();

while ($row = $fetch->fetch_assoc()) {
	$details = [];

	$fetch_details = $mysqli->query("SELECT * FROM tbl_event_criterias WHERE ch_id = '$row[ch_id]'");
	while($row_details = $fetch_details->fetch_assoc()){
		$details[] = $row_details;
	}

	$row['details'] = $details;
	array_push($response['data'], $row);
}

echo json_encode($response);
