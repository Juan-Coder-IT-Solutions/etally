<?php
include '../core/config.php';

$account_name	= $_POST['account_name'];
$user_category	= $_POST['user_category'];
$username		= $_POST['username'];
$password		= $_POST['password'];

$form_data = array(
	'account_name'	=> $account_name,
	'user_category' => $user_category,
	'username'		=> $username,
	'password'		=> $password
);


$sql = "INSERT INTO tbl_users (`" . implode('`,`', array_keys($form_data)) . "`) VALUES('" . implode("','", $form_data) . "')";
$mysqli->query($sql);

echo json_encode($form_data);
