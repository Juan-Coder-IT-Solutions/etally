<?php
include '../core/config.php';

$event_id = $_POST['event_id'];
$judge_id = $_POST['judge_id'];

$response['criterias'] = [];
$response['participants'] = [];

$fetch_criteria_header = $mysqli->query("SELECT ch_id,is_normal,criteria,points FROM tbl_event_criteria_header WHERE event_id = '$event_id' ORDER BY date_added ASC");
while($row_ch = $fetch_criteria_header->fetch_assoc()){
    $criterias = [];
    $fetch_criterias = $mysqli->query("SELECT criteria_id,criteria,points FROM tbl_event_criterias WHERE event_id = '$event_id' AND ch_id = '$row_ch[ch_id]' ORDER BY date_added ASC");
    while($row_criterias = $fetch_criterias->fetch_assoc()){
        $criterias[] = $row_criterias;
    }
    $row_ch['criterias'] = $criterias;
    array_push($response['criterias'], $row_ch);
}

$criterias_data = $response['criterias'];

$fetch_participants = $mysqli->query("SELECT participant_id FROM tbl_event_participants WHERE event_id = '$event_id' ORDER BY date_added ASC");
while($row_p = $fetch_participants->fetch_assoc()){
    $scores = [];
    foreach($criterias_data as $criteria_header){
        $criteria_scores = [];
        foreach($criteria_header['criterias'] as $criteria_details){
            $score = getEventScoresData($event_id,"points","AND criteria_id = '$criteria_details[criteria_id]' AND judge_id = '$judge_id' AND participant_id = '$row_p[participant_id]'") * 1;
            $criteria_scores[] = [
                'criteria_id' => $criteria_details['criteria_id'],
                'points' => $criteria_details['points'],
                'score' => $score,
            ];
        }
        array_push($scores,[
            'ch_id' => $criteria_header['criteria'],
            'points' => $criteria_header['points'],
            'is_normal' => $criteria_header['is_normal'],
            'criterias' => $criteria_scores
        ]);
    }
    $row_p['participant_name'] = getParticipantData($row_p['participant_id']);
    $row_p['rank'] = getEventRanksData($event_id,"rank","AND judge_id = '$judge_id' AND participant_id = '$row_p[participant_id]'") * 1;
    $row_p['scores'] = $scores;
    array_push($response['participants'], $row_p);
}

echo json_encode($response);