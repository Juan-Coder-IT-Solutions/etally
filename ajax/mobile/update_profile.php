<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: *");
header('Content-Type: text/html; charset=utf-8');

include '../../core/config.php';

$data = json_decode(file_get_contents("php://input"));
$user_id = $data->user_id;
$username = $data->username;
$password = $data->password;
$judge_name = $data->judge_name;

if (isset($username) && isset($password)) {

    if ($password != "") {
        $sql = $mysqli->query("UPDATE tbl_users set username='$username', password=md5('$password') WHERE  account_id='$user_id' ");
    } else {
        $sql = $mysqli->query("UPDATE tbl_users set username='$username' WHERE  account_id='$user_id' ");
    }

    if ($sql) {
        $mysqli->query("UPDATE tbl_judges set judge_name='$judge_name' WHERE  judge_id='$user_id' ");
        $response = 1;
    } else {
        $response = 0;
    }

    echo json_encode($response);
}
