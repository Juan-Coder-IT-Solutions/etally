<?php
include '../core/config.php';

$table_header = "tbl_event_criteria_header";
$table_sub = "tbl_event_criterias";

$form = json_decode($_POST['data'], true);

$ch_id		= (int) $form['ch_id'];
$event_id	= (int) $form['event_id'];
$is_normal	= (int) $form['is_normal'];
$criteria	= $form['criteria'];
$points		= $form['points'];
$details	= $form['details'];
$deletes	= $form['deleted_criterias'];

$form_header = array(
	'event_id'  => $event_id,
	'criteria'  => $criteria,
	'points'    => $points,
	'is_normal' => $is_normal
);

$sql = $ch_id > 0? sql_update($table_header, $form_header, "ch_id = '$ch_id'") : sql_insert($table_header, $form_header);
$mysqli->query($sql);

if($ch_id < 1){
	$ch_id = $mysqli->insert_id;

	if($is_normal == 1){
		$form_detail = array(
			'ch_id'		=> $ch_id,
			'event_id'  => $event_id,
			'criteria'  => $criteria,
			'points'    => $points,
		);
		$sql = sql_insert($table_sub, $form_detail);
		$mysqli->query($sql);
	}
}

foreach($details as $detail){
	$criteria_id = $detail['criteria_id'];
	$form_detail = array(
		'ch_id'		=> $ch_id,
		'event_id'  => $event_id,
		'criteria'  => $detail['name'],
		'points'    => $detail['points'],
	);
	$sql = $criteria_id > 0? sql_update($table_sub, $form_detail, "criteria_id = '$criteria_id'") : sql_insert($table_sub, $form_detail);
	$mysqli->query($sql);
}

if(count($deletes) > 0){
	$mysqli->query("DELETE FROM $table_sub WHERE criteria_id IN(".implode(",",$deletes).")");
}

echo 1;