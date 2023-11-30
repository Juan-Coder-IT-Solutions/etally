<?php
include '../core/config.php';

$judge_id = (int) $_POST['judge_id'];

$mysqli->query("DELETE FROM tbl_users WHERE user_id = '$judge_id'");
$sql = "DELETE FROM tbl_judges WHERE judge_id = '$judge_id'";
echo $mysqli->query($sql);
