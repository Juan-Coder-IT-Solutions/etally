<?php
include '../core/config.php';

$account_id = $_SESSION['etally']['account_id'];
$sql = "SELECT e.* FROM tbl_event_judges AS ej INNER JOIN tbl_events AS e ON e.event_id = ej.event_id WHERE ej.judge_id = '$account_id' GROUP BY e.event_id";
$fetch = $mysqli->query($sql);

$response['data'] = array();

while ($row = $fetch->fetch_assoc()) {
    $criterias = [];
    $fetch_criterias = $mysqli->query("SELECT * FROM tbl_event_criterias WHERE event_id = '$row[event_id]'");
    while ($row_criteria = $fetch_criterias->fetch_assoc()) {
        array_push($criterias, $row_criteria);
    }
    $row['criterias'] = $criterias;
	array_push($response['data'], $row);
}

echo json_encode($response);
