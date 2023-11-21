<?php
include '../core/config.php';

$event_id = $_POST['event_id'];
$time = $_POST['time'];

// Get the current date and time
$currentDateTime = new DateTime();

// Add 2 minutes
$currentDateTime->modify("+$time minutes");

// Display the result
$event_time = $currentDateTime->format('Y-m-d H:i:s');

$sql = "UPDATE tbl_events SET event_end = '$event_time' WHERE event_id = '$event_id'";
echo $mysqli->query($sql);