<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: *");
header('Content-Type: text/html; charset=utf-8');

include '../../core/config.php';

$data = json_decode(file_get_contents("php://input"));
$judge_id = $data->judge_id;
$event_id = $data->event_id;

$mysqli->query("DELETE FROM tbl_event_ranks WHERE event_id = '$event_id' AND judge_id = '$judge_id'");


$fetch_participants = $mysqli->query("SELECT ep.participant_id from tbl_participants p LEFT JOIN tbl_event_participants ep ON p.participant_id=ep.participant_id WHERE event_id='$event_id' ");
while ($participants_row = $fetch_participants->fetch_assoc()) {
    // fetch total score
    $fetch_total_score = $mysqli->query("SELECT sum(points) from tbl_event_scores WHERE participant_id='$participants_row[participant_id]' and event_id='$event_id' and judge_id='$judge_id' ");
    $total_score = $fetch_total_score->fetch_array();

    $form_data = array(
        'event_id'          => $event_id,
        'judge_id'          => $judge_id,
        'participant_id'    => $participants_row['participant_id'],
        'scores'            => $total_score[0]
    );
    $sql = sql_insert("tbl_event_ranks", $form_data);
    $mysqli->query($sql);
}


// RANK PER JUDGE
$rank = 1;
$fetch = $mysqli->query("SELECT * FROM tbl_event_ranks WHERE event_id = '$event_id' AND judge_id = '$judge_id' ORDER BY scores DESC");
while ($row = $fetch->fetch_assoc()) {

    $participant_id = $row['participant_id'];

    $form_data = array(
        'rank' => $rank
    );

    $sql = sql_update("tbl_event_ranks", $form_data, "event_id = '$event_id' AND judge_id = '$judge_id' AND participant_id = '$participant_id'");
    $mysqli->query($sql);
    $rank++;
}


// TIE BREAKER
$fetch = $mysqli->query("SELECT MIN(RANK) as rank,COUNT(scores) as count_same_scores,scores FROM tbl_event_ranks WHERE event_id = '$event_id' AND judge_id = '$judge_id' GROUP BY scores HAVING count_same_scores > 1");
while ($row = $fetch->fetch_assoc()) {

    $scores = $row['scores'];
    $rank = $row['rank'] + .5;

    $form_data = array(
        'rank' => $rank
    );

    $sql = sql_update("tbl_event_ranks", $form_data, "event_id = '$event_id' AND judge_id = '$judge_id' AND scores = '$scores'");
    $mysqli->query($sql);
}

echo 1;
