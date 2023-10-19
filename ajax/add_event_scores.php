<?php
include '../core/config.php';

$table_scores = "tbl_event_scores";
$table_ranks = "tbl_event_ranks";

$event_id = $_POST['event_id'];
$judge_id = $_POST['judge_id'];
$scores = $_POST['scores'];

$mysqli->query("DELETE FROM $table_scores WHERE event_id = '$event_id' AND judge_id = '$judge_id'");
$mysqli->query("DELETE FROM $table_ranks WHERE event_id = '$event_id' AND judge_id = '$judge_id'");

foreach($scores as $participants){
    $participant_id = $participants['participant_id'];
    $total_score = 0;
    foreach($participants['criterias'] as $criterias){
        $total_score += $criterias['score'];
        $form_data = array(
            'event_id'          => $event_id,
            'criteria_id'       => $criterias['criteria_id'],
            'judge_id'          => $judge_id,
            'participant_id'    => $participant_id,
            'points'            => $criterias['score']
        );
        $sql = sql_insert($table_scores, $form_data);
        $mysqli->query($sql);
    }

    $form_data = array(
        'event_id'          => $event_id,
        'judge_id'          => $judge_id,
        'participant_id'    => $participant_id,
        'scores'            => $total_score
    );
    $sql = sql_insert($table_ranks, $form_data);
    $mysqli->query($sql);
}


// RANK PER JUDGE
$rank = 1;
$fetch = $mysqli->query("SELECT * FROM $table_ranks WHERE event_id = '$event_id' AND judge_id = '$judge_id' ORDER BY scores DESC");
while($row = $fetch->fetch_assoc()){

    $participant_id = $row['participant_id'];
    
    $form_data = array(
        'rank' => $rank
    );

    $sql = sql_update($table_ranks, $form_data,"event_id = '$event_id' AND judge_id = '$judge_id' AND participant_id = '$participant_id'");
    $mysqli->query($sql);
    $rank++;
}


// TIE BREAKER
$fetch = $mysqli->query("SELECT MIN(RANK) as rank,COUNT(scores) as count_same_scores,scores FROM $table_ranks WHERE event_id = '$event_id' AND judge_id = '$judge_id' GROUP BY scores HAVING count_same_scores > 1");
while($row = $fetch->fetch_assoc()){

    $scores = $row['scores'];
    $rank = $row['rank'] + .5;
    
    $form_data = array(
        'rank' => $rank
    );

    $sql = sql_update($table_ranks, $form_data,"event_id = '$event_id' AND judge_id = '$judge_id' AND scores = '$scores'");
    $mysqli->query($sql);
}

echo 1;