<?php
include '../core/config.php';

$table_name = "tbl_participants";

$participant_id     = (int) $_POST['participant_id'];
$participant_name   = $_POST['participant_name'];
$participant_year   = $_POST['participant_year'];
$program_id			= $_POST['program_id'];

$form_data = array(
	'participant_id'    => $participant_id,
	'participant_name'  => $participant_name,
	'participant_year'  => $participant_year,
	'program_id'		=> $program_id
);

$sql = $participant_id > 0? sql_update($table_name, $form_data, "participant_id = '$participant_id'") : sql_insert($table_name, $form_data);

echo $mysqli->query($sql);
