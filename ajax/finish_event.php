<?php
include '../core/config.php';

$event_id = $_POST['event_id'];

// CHECK IF ALL JUDGES ALREADY EVALUATED
$number_of_judges = countEventJudges($event_id) * 1;
$number_of_judges_evaluated = countEventRanksByJudges($event_id) * 1;

if($number_of_judges != $number_of_judges_evaluated){
    echo -1;
    die;
}

// UPDATE TOTAL RANKS PER PARTICIPANT
$mysqli->query("UPDATE tbl_event_participants AS ep
    SET ep.total_ranks = (
        SELECT SUM(er.rank) AS ranks
        FROM tbl_event_ranks AS er
        WHERE er.event_id = '$event_id'
        AND ep.participant_id = er.participant_id
        GROUP BY er.participant_id
    )
    WHERE ep.event_id = '$event_id'");

// RANK PARTICPANTS BASED ON TOTAL RANKS
$rank = 1;
$fetch = $mysqli->query("SELECT event_participant_id FROM tbl_event_participants WHERE event_id = '$event_id' ORDER BY total_ranks ASC");
while($row = $fetch->fetch_assoc()){

    $event_participant_id = $row['event_participant_id'];
    
    $form_data = array(
        'rank' => $rank
    );

    $sql = sql_update("tbl_event_participants", $form_data,"event_participant_id = '$event_participant_id'");
    $mysqli->query($sql);
    $rank++;
}

echo 1;










// // RANK OVERALL SCORE
// $rank = 1;
// $fetch = $mysqli->query("SELECT * FROM $table_ranks WHERE event_id = '$event_id' AND judge_id = '$judge_id' ORDER BY scores DESC");
// while($row = $fetch->fetch_assoc()){

//     $participant_id = $row['participant_id'];
    
//     $form_data = array(
//         'rank' => $rank
//     );

//     $sql = sql_update($table_ranks, $form_data,"event_id = '$event_id' AND judge_id = '$judge_id' AND participant_id = '$participant_id'");
//     $mysqli->query($sql);
//     $rank++;
// }

$mysqli->query(sql_update("tbl_events", ['event_status' => 'F'], "event_id = '$event_id'"));
