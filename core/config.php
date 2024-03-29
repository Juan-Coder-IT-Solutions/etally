<?php

// START THE SESSION
session_start();

$mysqli = new mysqli("localhost", "root", "", "etally_db");
//$mysqli = new mysqli("localhost", "u814036432_root", "#VM>:m&8oQ", "u814036432_etally");
// Check connection
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: " . $mysqli->connect_error;
	exit();
}
date_default_timezone_set('Asia/Manila');


function sql_update($table_name, $form_data, $where_clause = '')
{
	$whereSQL = '';
	if (!empty($where_clause)) {
		if (substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE') {
			$whereSQL = " WHERE " . $where_clause;
		} else {
			$whereSQL = " " . trim($where_clause);
		}
	}
	$sql = "UPDATE " . $table_name . " SET ";
	$sets = array();
	foreach ($form_data as $column => $value) {
		$sets[] = "`" . $column . "` = '" . $value . "'";
	}
	$sql .= implode(', ', $sets);
	$sql .= $whereSQL;

	return $sql;
}

function sql_insert($table_name, $form_data)
{
	$fields = array_keys($form_data);

	$sql = "INSERT INTO " . $table_name . "
	    (`" . implode('`,`', $fields) . "`)
	    VALUES('" . implode("','", $form_data) . "')";

	return $sql;
}

function getJudgeName($judge_id)
{
	return getJudgeData($judge_id);
}

function getUserData($user_id, $data_column = "account_name")
{
	global $mysqli;
	$sql = "SELECT $data_column FROM tbl_users WHERE user_id = '$user_id'";
	$fetch = $mysqli->query($sql);
	$row = $fetch->fetch_array();
	return $row[$data_column];
}

function getJudgeData($judge_id, $data_column = "judge_name")
{
	global $mysqli;
	$sql = "SELECT $data_column FROM tbl_judges WHERE judge_id = '$judge_id'";
	$fetch = $mysqli->query($sql);
	$row = $fetch->fetch_array();
	return $row[$data_column];
}

function getParticipantName($participant_id)
{
	return getParticipantData($participant_id);
}

function getParticipantData($participant_id, $data_column = "participant_name")
{
	global $mysqli;
	$select = is_array($data_column) ? implode(",", $data_column) : $data_column;
	$sql = "SELECT $select FROM tbl_participants WHERE participant_id = '$participant_id'";
	$fetch = $mysqli->query($sql);
	$row = $fetch->fetch_assoc();
	return is_array($data_column) ? $row : $row[$data_column];
}

function getParticipantEvents($participant_id)
{
	global $mysqli;
	$events = [];
	$sql = "SELECT e.event_name FROM tbl_participants AS p,tbl_event_participants AS ep,tbl_events AS e WHERE ep.participant_id = p.participant_id AND e.event_id = ep.event_id AND p.participant_id = '$participant_id'";
	$fetch = $mysqli->query($sql);
	while ($row = $fetch->fetch_assoc()) {
		$events[] = $row['event_name'];
	}
	return implode("<br>", $events);
}

function getEventData($event_id, $data_column = "event_name")
{
	global $mysqli;
	$sql = "SELECT $data_column FROM tbl_events WHERE event_id = '$event_id'";
	$fetch = $mysqli->query($sql);
	$row = $fetch->fetch_array();
	return $row[$data_column];
}

function getEventScoresData($event_id, $data_column = "points", $inject = "")
{
	global $mysqli;
	$sql = "SELECT $data_column FROM tbl_event_scores WHERE event_id = '$event_id' $inject";
	$fetch = $mysqli->query($sql);
	$row = $fetch->fetch_array();
	return $row[0];
}

function getEventRanksData($event_id, $data_column = "rank", $inject = "")
{
	global $mysqli;
	$sql = "SELECT $data_column FROM tbl_event_ranks WHERE event_id = '$event_id' $inject";
	$fetch = $mysqli->query($sql);
	$row = $fetch->fetch_array();
	return $row[0];
}

function getProgramData($program_id, $data_column = "program_name")
{
	global $mysqli;
	$sql = "SELECT $data_column FROM tbl_programs WHERE program_id = '$program_id'";
	$fetch = $mysqli->query($sql);
	$row = $fetch->fetch_array();
	return $row[$data_column];
}

function countEventRanksByJudges($event_id)
{
	global $mysqli;
	$sql = "SELECT judge_id AS count FROM tbl_event_ranks WHERE event_id = '$event_id' GROUP BY judge_id";
	$fetch = $mysqli->query($sql);
	return (int) $fetch->num_rows;
}

function countEventTieBreakers($event_id)
{
	global $mysqli;
	$sql = "SELECT COUNT(rank) as count_same_scores,`rank` FROM tbl_event_participants WHERE event_id = '$event_id' GROUP BY `rank` HAVING count_same_scores > 1";
	$fetch = $mysqli->query($sql);
	return (int) $fetch->num_rows;
}


function countEventJudges($event_id)
{
	global $mysqli;
	$sql = "SELECT COUNT(event_id) AS count FROM tbl_event_judges WHERE event_id = '$event_id'";
	$fetch = $mysqli->query($sql);
	$row = $fetch->fetch_array();
	return $row['count'];
}

function countEventParticipants($event_id)
{
	global $mysqli;
	$sql = "SELECT COUNT(event_id) AS count FROM tbl_event_participants WHERE event_id = '$event_id'";
	$fetch = $mysqli->query($sql);
	$row = $fetch->fetch_array();
	return $row['count'];
}

function checkIfUsernameExists($username)
{
	global $mysqli;
	$fetch = $mysqli->query("SELECT user_id FROM tbl_users WHERE username = '$username'");
	return $fetch->num_rows;
}

function generateRandomString($length = 10)
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

function getTimeAgo($timestamp)
{
	$timeAgo = '';

	// Get the current timestamp
	$now = new DateTime();

	// Create a DateTime object from the provided timestamp
	$date = new DateTime($timestamp);

	// Calculate the difference between the current time and the provided timestamp
	$interval = $now->diff($date);

	// Define the time intervals
	$intervals = [
		'y' => 'yr',
		'm' => 'mo',
		'd' => 'day',
		'h' => 'hr',
		'i' => 'min',
		's' => 'sec'
	];

	// Iterate through the intervals and create the time ago string
	foreach ($intervals as $key => $value) {
		if ($interval->$key > 1) {
			$timeAgo = $interval->$key . ' ' . $value . 's';
			break;
		} elseif ($interval->$key == 1) {
			$timeAgo = $interval->$key . ' ' . $value;
			break;
		}
	}

	// If the time difference is less than a second, display "Just now"
	if ($timeAgo == '') {
		$timeAgo = 'Just now';
	}

	return $timeAgo;
}
