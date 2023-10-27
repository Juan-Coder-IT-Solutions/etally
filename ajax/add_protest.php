<?php
include '../core/config.php';

$event_id	= $_POST['event_id'];
$protest	= $_POST['protest'];

$form_data = array(
	'event_id'  => $event_id,
	'protest'   => $protest,
    'user_token'=> generateRandomString(5)
);

echo $mysqli->query(sql_insert("tbl_protests",$form_data));
