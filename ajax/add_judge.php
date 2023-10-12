<?php
include '../core/config.php';

$judge_id			= (int) $_POST['judge_id'];
$judge_name			= $_POST['judge_name'];
$judge_affiliation	= $_POST['judge_affiliation'];
$username			= $_POST['username'];
$password			= $_POST['password'];

if(checkIfUsernameExists($username) > 0){
	echo 2;
}else{
	$form_data = array(
		'judge_name'		=> $judge_name,
		'judge_affiliation' => $judge_affiliation
	);
	
	$sql = $judge_id > 0? sql_update("tbl_judges", $form_data, "judge_id = '$judge_id'") : sql_insert("tbl_judges", $form_data);
	$mysqli->query($sql);
	$account_id = $mysqli->insert_id;
	
	$form_data = array(
		'account_name'	=> $judge_name,
		'account_id'	=> $account_id,
		'user_category' => "J",
		'username'		=> $username,
		'password'		=> md5($password)
	);

	$sql = sql_insert("tbl_users", $form_data);
	echo $mysqli->query($sql);
}

