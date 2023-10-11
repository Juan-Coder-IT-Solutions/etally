<?php
include '../core/config.php';

$table_name = "tbl_event_judges";

$event_id   = (int) $_POST['event_id'];
$judge_ids  = $_POST['judge_ids'];

$sql_update = sql_update($table_name,['status' => 0],"event_id = '$event_id'");
$mysqli->query($sql_update);

$judge_no = 1;
foreach($judge_ids as $judge_id)
{
    $sql_select = "SELECT event_judge_id FROM $table_name WHERE event_id = '$event_id' AND judge_id = '$judge_id'";
    $fetch = $mysqli->query($sql_select);

    $form_data = array(
        'event_id'  => $event_id,
        'judge_id'  => $judge_id,
        'judge_no'  => $judge_no++,
        'status'    => 1
    );

    $sql = $fetch->num_rows > 0 ? sql_update($table_name, $form_data, "event_id = '$event_id' AND judge_id = '$judge_id'") : sql_insert($table_name, $form_data);

    $mysqli->query($sql);
}

$mysqli->query("DELETE FROM $table_name WHERE event_id = '$event_id' AND `status` = 0");

echo 1;
