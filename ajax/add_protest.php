<?php
include '../core/config.php';

$event_id	= $_POST['event_id'];
$protest	= $_POST['protest'];

$event_end		= getEventData($event_id,'event_end');
$protest_hrs	= getEventData($event_id,'protest_hrs') * 1;

$date_now = date("Y-m-d H:i:s");
$date_end = date("Y-m-d H:i:s",strtotime("$event_end +$protest_hrs hours"));

if($date_now > $date_end){
	echo -1;
	die;
}

// echo "$date_now > $date_end [$event_end $protest_hrs] = ".($date_now > $date_end);

$form_data = array(
	'event_id'  => $event_id,
	'protest'   => $protest,
    'user_token'=> generateRandomString(5)
);

echo $mysqli->query(sql_insert("tbl_protests",$form_data));
