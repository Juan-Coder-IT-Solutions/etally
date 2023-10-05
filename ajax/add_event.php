<?php
include '../core/config.php';

$table_name = "tbl_events";

$event_id			= (int) $_POST['event_id'];
$event_name			= $_POST['event_name'];
$event_start        = $_POST['event_start'];
$participant_needed = $_POST['participant_needed'];

$form_data = array(
	'event_name'            => $event_name,
	'event_start'           => $event_start,
	'participant_needed'    => $participant_needed
);

$sql = $event_id > 0? sql_update($table_name, $form_data, "event_id = '$event_id'") : sql_insert($table_name, $form_data);

echo $mysqli->query($sql);
