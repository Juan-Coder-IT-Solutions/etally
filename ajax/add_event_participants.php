<?php
include '../core/config.php';

$table_name = "tbl_event_participants";

$event_id   = (int) $_POST['event_id'];
$participant_ids  = $_POST['participant_ids'];

$sql_update = sql_update($table_name,['status' => 0],"event_id = '$event_id'");
$mysqli->query($sql_update);

foreach($participant_ids as $participant_id)
{
    $sql_select = "SELECT event_participant_id FROM $table_name WHERE event_id = '$event_id' AND participant_id = '$participant_id'";
    $fetch = $mysqli->query($sql_select);

    $form_data = array(
        'event_id'          => $event_id,
        'participant_id'    => $participant_id,
        'status'            => 1
    );

    $sql = $fetch->num_rows > 0 ? sql_update($table_name, $form_data, "event_id = '$event_id' AND participant_id = '$participant_id'") : sql_insert($table_name, $form_data);

    $mysqli->query($sql);
}

$mysqli->query("DELETE FROM $table_name WHERE event_id = '$event_id' AND `status` = 0");

echo 1;
