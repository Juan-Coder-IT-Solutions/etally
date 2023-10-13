<?php
include '../core/config.php';

$judge_id			= (int) $_POST['judge_id'];
$judge_name			= $_POST['judge_name'];
$judge_affiliation	= $_POST['judge_affiliation'];

$form_data = array(
	'judge_name'		=> $judge_name,
	'judge_affiliation' => $judge_affiliation
);


if (isset($_FILES["judge_qualification"]) && $_FILES["judge_qualification"]["error"] == 0) {
	$filename = generateRandomString(9).".pdf";
	$uploadDirectory = "../assets/img/qualifications/";
	$uploadedFile = $uploadDirectory . $filename;

	if (!file_exists($uploadedFile)) {
		if (move_uploaded_file($_FILES["judge_qualification"]["tmp_name"], $uploadedFile)) {
			$form_data['judge_qualification'] = $filename;
			if($judge_id > 0){
				$old_mechanics = getJudgeData($judge_id,"judge_qualification");
				if($old_mechanics != "no_image.png"){
					unlink($uploadDirectory . $old_mechanics);
				}
			}
		}
	}
}

if($judge_id < 1){
	$username	= $_POST['username'];
	$password	= $_POST['password'];
	if(checkIfUsernameExists($username) > 0){
		echo 2;
		unlink($uploadDirectory . $filename);
		die;
	}
}


$sql = $judge_id > 0? sql_update("tbl_judges", $form_data, "judge_id = '$judge_id'") : sql_insert("tbl_judges", $form_data);
$res = $mysqli->query($sql);

if($judge_id < 1){
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
	die;
}

echo $res;
