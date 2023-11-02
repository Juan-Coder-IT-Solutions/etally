<?php
include '../core/config.php';

$table_name = "tbl_programs";

$program_id  = (int) $_POST['program_id'];
$program_name     = $_POST['program_name'];

$form_data = array('program_name' => $program_name);
$sql = $program_id > 0? sql_update($table_name, $form_data, "program_id = '$program_id'") : sql_insert($table_name, $form_data);

echo $mysqli->query($sql);
