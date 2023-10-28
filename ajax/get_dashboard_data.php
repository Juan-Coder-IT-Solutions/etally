<?php
include '../core/config.php';

$fetch_events = $mysqli->query("SELECT COUNT(event_id) AS count FROM tbl_events");
$row_event = $fetch_events->fetch_assoc();
$no_of_events = $row_event['count'];

$fetch_organizers = $mysqli->query("SELECT COUNT(user_id) AS count FROM tbl_users WHERE user_category = 'O'");
$row_organizer = $fetch_organizers->fetch_assoc();
$no_of_organizers = $row_organizer['count'];

$fetch_organizers = $mysqli->query("SELECT COUNT(judge_id) AS count FROM tbl_judges");
$row_judge = $fetch_organizers->fetch_assoc();
$no_of_judges = $row_judge['count'];

$fetch_participants = $mysqli->query("SELECT COUNT(participant_id) AS count FROM tbl_participants");
$row_participant = $fetch_participants->fetch_assoc();
$no_of_participants = $row_participant['count'];

$response['data'] = array(
    'no_of_events' => $no_of_events,
    'no_of_organizers' => $no_of_organizers,
    'no_of_judges' => $no_of_judges,
    'no_of_participants' => $no_of_participants,
);

echo json_encode($response);
