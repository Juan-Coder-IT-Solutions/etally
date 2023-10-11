<?php
include '../core/config.php';

$participant_id = (int) $_POST['participant_id'];


$sql = "DELETE FROM tbl_participants WHERE participant_id = '$participant_id'";

echo $mysqli->query($sql);
