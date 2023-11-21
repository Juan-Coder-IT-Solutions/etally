<?php
include '../core/config.php';

$event_id = $_POST['event_id'];

// CHECK IF CRITERIA IS 100%
$fetch = $mysqli->query("SELECT SUM(points) AS points FROM tbl_event_criterias WHERE event_id = '$event_id'");
$row_points = $fetch->fetch_assoc();

if($row_points['points'] < 1){
    echo -1;
    die;
}

$form_data = array(
    'event_status' => 'P',
);

$sql = sql_update("tbl_events", $form_data, "event_id = '$event_id'");
echo $mysqli->query($sql);