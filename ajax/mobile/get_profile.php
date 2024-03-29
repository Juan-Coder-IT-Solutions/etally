<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: *");
header('Content-Type: text/html; charset=utf-8');

include '../../core/config.php';

$data = json_decode(file_get_contents("php://input"));
$user_id = $data->user_id;

if (isset($user_id)) {
    $sql = "SELECT * FROM tbl_users WHERE account_id='$user_id'";
    $fetch = $mysqli->query($sql);

    $response = array();

    while ($row = $fetch->fetch_assoc()) {
        $list = array();
        $list['username'] = $row['username'];
        $list['user_id'] = $row['user_id'];
        $list['account_id'] = $row['account_id'];
        $list['account_name'] = $row['account_name'];

        if ($row['user_category'] == "J") {
            $fetch_judge = $mysqli->query("SELECT * FROM tbl_judges WHERE judge_id='$row[account_id]'");
            $judge_row = $fetch_judge->fetch_assoc();
            $list['user_name'] = $judge_row['judge_name'];
            $list['judge_affiliation'] = $judge_row['judge_affiliation'];
            $list['judge_qualification'] = $judge_row['judge_qualification'];
            $list['judge_img'] = $judge_row['judge_img'];
        } else {
            $fetch = $mysqli->query("SELECT * FROM tbl_participants WHERE participant_id='$row[account_id]'");
            $participant_row = $fetch->fetch_assoc();
            $list['user_name'] = $participant_row['participant_name'];
            $list['participant_img'] = $participant_row['participant_img'];
        }

        array_push($response, $list);
    }

    echo json_encode($response);
}
