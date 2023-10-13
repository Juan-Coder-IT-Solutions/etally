<?php

// START THE SESSION
session_start();

$mysqli = new mysqli("localhost", "root", "", "etally_db");
// Check connection
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: " . $mysqli->connect_error;
	exit();
}


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
	$sql = "SELECT $data_column FROM tbl_participants WHERE participant_id = '$participant_id'";
	$fetch = $mysqli->query($sql);
	$row = $fetch->fetch_array();
	return $row[$data_column];
}

function getEventData($event_id, $data_column = "event_name")
{
	global $mysqli;
	$sql = "SELECT $data_column FROM tbl_events WHERE event_id = '$event_id'";
	$fetch = $mysqli->query($sql);
	$row = $fetch->fetch_array();
	return $row[$data_column];
}

function checkIfUsernameExists($username)
{
	global $mysqli;
	$fetch = $mysqli->query("SELECT user_id FROM tbl_users WHERE username = '$username'");
	return $fetch->num_rows;
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}