<?php
include '../core/config.php';

$event_id = $_POST['event_id'];
$rank = floor($_POST['rank_result']);
$rank_orders = $_POST['rank_orders'];

foreach($rank_orders as $event_participant_id){
    $form_detail = array('rank' => $rank++);
	$sql = sql_update("tbl_event_participants", $form_detail, "event_participant_id = '$event_participant_id'");
	$mysqli->query($sql);
}

echo 1;