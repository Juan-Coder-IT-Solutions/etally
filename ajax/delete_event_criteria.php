<?php
include '../core/config.php';

$criteria_id = (int) $_POST['criteria_id'];


$sql = "DELETE FROM tbl_event_criterias WHERE criteria_id = '$criteria_id'";

echo $mysqli->query($sql);
