<?php
include '../core/config.php';

$ch_id = (int) $_POST['ch_id'];

$sql = "DELETE FROM tbl_event_criterias WHERE ch_id = '$ch_id'";
$mysqli->query($sql);

$sql = "DELETE FROM tbl_event_criteria_header WHERE ch_id = '$ch_id'";
$mysqli->query($sql);
echo 1;
