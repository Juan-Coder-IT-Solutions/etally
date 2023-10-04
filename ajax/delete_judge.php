<?php
include '../core/config.php';

$judge_id			= (int) $_POST['judge_id'];


$sql = "DELETE FROM tbl_judges WHERE judge_id = '$judge_id'";

$mysqli->query($sql);

echo json_encode($form_data);
