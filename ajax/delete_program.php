<?php
include '../core/config.php';

$event_category_id = (int) $_POST['event_category_id'];


$sql = "DELETE FROM tbl_event_categories WHERE event_category_id = '$event_category_id'";

echo $mysqli->query($sql);
