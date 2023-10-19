<?php
include '../core/config.php';

$account_id = $_SESSION['etally']['account_id'];
$sql = "SELECT e.* FROM tbl_event_judges AS ej INNER JOIN tbl_events AS e ON e.event_id = ej.event_id WHERE ej.judge_id = '$account_id' GROUP BY e.event_id";
$fetch = $mysqli->query($sql);

$response['data'] = array();
$response['judge_id'] = $account_id;

while ($row = $fetch->fetch_assoc()) {
    // $criterias = [];
    // $fetch_criterias = $mysqli->query("SELECT * FROM tbl_event_criterias WHERE event_id = '$row[event_id]'");
    // while ($row_criteria = $fetch_criterias->fetch_assoc()) {
    //     $row_criteria['criteria'] = str_replace("\n","<br>",str_replace("\r","&#13;",$row_criteria['criteria']));
    //     array_push($criterias, $row_criteria);
    // }
    // $row['criterias'] = $criterias;

    // $participants = [];
    // $fetch_participants = $mysqli->query("SELECT ep.participant_id,er.rank,er.scores
    // FROM tbl_event_participants AS ep
    // LEFT JOIN tbl_event_ranks AS er ON er.event_id = ep.event_id AND er.participant_id = ep.participant_id WHERE ep.event_id = '$row[event_id]' AND er.judge_id = '$account_id'");
    // while ($row_participant = $fetch_participants->fetch_assoc()) {
    //     $row_participant['participant_name'] = getParticipantName($row_participant['participant_id']);
    //     array_push($participants, $row_participant);
    // }

    $participants = [];
    $fetch_participant = $mysqli->query("SELECT * FROM tbl_event_participants WHERE event_id = '$row[event_id]'");
    while ($row_participant = $fetch_participant->fetch_assoc()) {
        $row_participant['participant_name'] = getParticipantName($row_participant['participant_id']);
        $row_participant['rank'] = getEventRanksData($row['event_id'],"rank","AND participant_id = '$row_participant[participant_id]' AND judge_id = '$account_id'") * 1;
        $row_participant['scores'] = getEventRanksData($row['event_id'],"scores","AND participant_id = '$row_participant[participant_id]' AND judge_id = '$account_id'") * 1;
        array_push($participants, $row_participant);
    }



    $row['participants'] = $participants;
	array_push($response['data'], $row);
}

echo json_encode($response);
