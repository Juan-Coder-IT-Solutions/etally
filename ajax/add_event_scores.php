<?php
include '../core/config.php';

$table_name = "tbl_event_scores";

$event_id = $_POST['event_id'];
$judge_id = $_POST['judge_id'];
$scores = $_POST['scores'];

$mysqli->query("DELETE FROM $table_name WHERE event_id = '$event_id' AND judge_id = '$judge_id'");

foreach($scores as $participants){
    $participant_id = $participants['participant_id'];
    foreach($participants['criterias'] as $criterias){
        $form_data = array(
            'event_id'          => $event_id,
            'criteria_id'       => $criterias['criteria_id'],
            'judge_id'          => $judge_id,
            'participant_id'    => $participant_id,
            'points'            => $criterias['score']
        );
        $sql = sql_insert($table_name, $form_data);
        $mysqli->query($sql);
    }
}

echo 1;