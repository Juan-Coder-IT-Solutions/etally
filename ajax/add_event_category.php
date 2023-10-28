<?php
include '../core/config.php';

$table_name = "tbl_event_categories";

$event_category_id  = (int) $_POST['event_category_id'];
$event_category     = $_POST['event_category'];

$form_data = array('event_category' => $event_category);
$sql = $event_category_id > 0? sql_update($table_name, $form_data, "event_category_id = '$event_category_id'") : sql_insert($table_name, $form_data);

echo $mysqli->query($sql);
