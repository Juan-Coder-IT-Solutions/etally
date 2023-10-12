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
	global $mysqli;
	$sql = "SELECT judge_name FROM tbl_judges WHERE judge_id = '$judge_id'";
	$fetch = $mysqli->query($sql);
	$row = $fetch->fetch_array();
	return $row['judge_name'];
}

function getParticipantName($participant_id)
{
	global $mysqli;
	$sql = "SELECT participant_name FROM tbl_participants WHERE participant_id = '$participant_id'";
	$fetch = $mysqli->query($sql);
	$row = $fetch->fetch_array();
	return $row['participant_name'];
}

function checkIfUsernameExists($username)
{
	global $mysqli;
	$fetch = $mysqli->query("SELECT user_id FROM tbl_users WHERE username = '$username'");
	return $fetch->num_rows;
}