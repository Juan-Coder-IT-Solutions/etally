<?php
include '../core/config.php';

$table_name = "tbl_event_criterias";

$criteria_id    = (int) $_POST['criteria_id'];
$event_id       = (int) $_POST['event_id'];
$criteria       = $_POST['criteria'];
$points         = $_POST['points'];

$form_data = array(
	'criteria'  => $criteria,
	'points'    => $points,
	'event_id'  => $event_id
);

$sql = $criteria_id > 0? sql_update($table_name, $form_data, "criteria_id = '$criteria_id'") : sql_insert($table_name, $form_data);

echo $mysqli->query($sql);
