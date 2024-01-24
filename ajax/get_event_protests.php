<?php
include '../core/config.php';

$sql = "SELECT * FROM tbl_protests ORDER BY date_added DESC";
$fetch = $mysqli->query($sql);

$response['data'] = array();

$count = 1;
while ($row = $fetch->fetch_assoc()) {
    $row['count'] = $count++;
    // events
    $fetch_events = $mysqli->query("SELECT * from tbl_events where event_id='$row[event_id]'");
    $event_row = $fetch_events->fetch_assoc();
    $row['event_name'] = $event_row['event_name'];
    // user
    $fetch_participants = $mysqli->query("SELECT * from tbl_participants p LEFT JOIN tbl_users u ON p.participant_id=u.account_id where u.user_id='$row[user_id]'");
    $participant_row = $fetch_participants->fetch_assoc();
    $row['account_name'] = $participant_row['participant_name'];
    $row['status'] = $row['status'] == "P" ? "Pending" : "Resolved";

    array_push($response['data'], $row);
}

echo json_encode($response);
