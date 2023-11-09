<?php
include '../core/config.php';

$event_id = (int) $_POST['event_id'];
$judge_id = (int) $_SESSION['etally']['account_id'];

$sql = "SELECT * FROM tbl_event_participants WHERE event_id = '$event_id'";
$fetch = $mysqli->query($sql);
$response['participants'] = array();
while ($row = $fetch->fetch_assoc()) {
    $participant_id = $row['participant_id'];

    $fetch_criteria_header = $mysqli->query("SELECT * FROM tbl_event_criteria_header WHERE event_id = '$event_id'");
    $main_criterias = [];
    $main_score = 0;
    while($row_criteria_header = $fetch_criteria_header->fetch_assoc()){
        $ch_id = $row_criteria_header['ch_id'];

        $criterias = [];
        $total_score = 0;
        $fetch_criteria = $mysqli->query("SELECT * FROM tbl_event_criterias WHERE ch_id = '$ch_id'");
        while ($row_criteria = $fetch_criteria->fetch_assoc()) {
            $criteria_id = $row_criteria['criteria_id'];
            $row_criteria['score'] = getEventScoresData($event_id,"SUM(points)","AND criteria_id = '$criteria_id' AND participant_id = '$participant_id' AND judge_id = '$judge_id'") * 1;
            $total_score += $row_criteria['score'];
            array_push($criterias, $row_criteria);
        }
        $row_criteria_header['score'] = $total_score;
        $row_criteria_header['criterias'] = $criterias;
        $main_score += $total_score;

        array_push($main_criterias, $row_criteria_header);
    }
	$row['score'] = $main_score;
	$row['main_criterias'] = $main_criterias;
	$row['participant_name'] = getParticipantName($row['participant_id']);
	$row['participant'] = getParticipantData($row['participant_id'],['participant_name','participant_img','participant_year','program_id']);
    $row['participant']['program_name'] = getProgramData($row['participant']['program_id']);
	array_push($response['participants'], $row);
}

echo json_encode($response);