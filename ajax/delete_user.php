<?php
include '../core/config.php';

$user_id = (int) $_POST['user_id'];

$sql = "DELETE FROM tbl_users WHERE user_id = '$user_id'";

echo $mysqli->query($sql);
