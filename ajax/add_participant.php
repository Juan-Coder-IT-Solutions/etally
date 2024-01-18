<?php
include '../core/config.php';

$table_name = "tbl_participants";

$participant_id     = (int) $_POST['participant_id'];
$participant_name   = $_POST['participant_name'];
$participant_year   = $_POST['participant_year'];
$program_id			= $_POST['program_id'];

$form_data = array(
	'participant_id'    => $participant_id,
	'participant_name'  => $participant_name,
	'participant_year'  => $participant_year,
	'program_id'		=> $program_id
);

if (isset($_FILES["participant_img"]) && $_FILES["participant_img"]["error"] == 0) {
	$filename = generateRandomString(9).".".pathinfo($_FILES['participant_img']['name'], PATHINFO_EXTENSION);
	$uploadDirectory = "../assets/img/profiles/";
	$uploadedFile = $uploadDirectory . $filename;

	if (!file_exists($uploadedFile)) {
		if (move_uploaded_file($_FILES["participant_img"]["tmp_name"], $uploadedFile)) {
			$form_data['participant_img'] = $filename;
			if($participant_id > 0){
				$old_mechanics = getParticipantData($participant_id,"participant_img");
				if($old_mechanics != "user_img.png"){
					unlink($uploadDirectory . $old_mechanics);
				}
			}
		}
	}
}


if($participant_id < 1){
	$username	= $_POST['username'];
	$password	= $_POST['password'];
	if(checkIfUsernameExists($username) > 0){
		echo 2;
		unlink($uploadDirectory . $filename);
		die;
	}
}


$sql = $participant_id > 0? sql_update($table_name, $form_data, "participant_id = '$participant_id'") : sql_insert($table_name, $form_data);

$res = $mysqli->query($sql);

if($participant_id < 1){
	$account_id = $mysqli->insert_id;

	$form_data = array(
		'account_name'	=> $judge_name,
		'account_id'	=> $account_id,
		'user_category' => "P",
		'username'		=> $username,
		'password'		=> md5($password)
	);
	
	$sql = sql_insert("tbl_users", $form_data);
	echo $mysqli->query($sql);
	die;
}

echo $res;

