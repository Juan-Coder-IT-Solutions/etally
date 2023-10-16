<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: *");
header('Content-Type: text/html; charset=utf-8');

include '../../core/config.php';

$data = json_decode(file_get_contents("php://input"));
$username = $data->username;
$password = $data->password;

$sql = "SELECT * FROM tbl_users WHERE username='$username' and password=md5('$password')";
$fetch = $mysqli->query($sql);

$response = array();

while ($row = $fetch->fetch_assoc()) {
    $list = array();
    $list['username'] = $row['username'];
    $list['user_id'] = $row['user_id'];
    $list['account_id'] = $row['account_id'];
    $list['account_name'] = $row['account_name'];
    array_push($response, $list);
}

echo json_encode($response);
