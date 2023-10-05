<?php
include '../core/config.php';

$judge_id			= (int) $_POST['judge_id'];
$judge_name			= $_POST['judge_name'];
$judge_affiliation	= $_POST['judge_affiliation'];

$form_data = array(
	'judge_name'		=> $judge_name,
	'judge_affiliation' => $judge_affiliation
);

$sql = $judge_id > 0? sql_update("tbl_judges", $form_data, "judge_id = '$judge_id'") : sql_insert("tbl_judges", $form_data);

echo $mysqli->query($sql);
