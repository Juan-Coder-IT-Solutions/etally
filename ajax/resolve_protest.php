<?php
include '../core/config.php';

$user_id        = $_SESSION['etally']['user_id'];
$protest_id       = $_POST['protest_id'];

$sql = $mysqli->query("UPDATE tbl_protests SET status = 'R' WHERE protest_id = '$protest_id'");
if ($sql) {
    echo 1;
} else {
    echo 0;
}
