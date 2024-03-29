<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: *");
header('Content-Type: text/html; charset=utf-8');

include '../../core/config.php';

$data = json_decode(file_get_contents("php://input"));
$username = $data->username;
$password = $data->password;

if (isset($username)) {
    $sql = "SELECT * FROM tbl_users WHERE username='$username' and password=md5('$password') and (user_category='J' or user_category='P')";
    $fetch = $mysqli->query($sql);

    $response = array();

    $row_count = $fetch->num_rows;
    if ($row_count > 0) {
        while ($row = $fetch->fetch_assoc()) {
            $list = array();
            $list['username'] = $row['username'];
            $list['user_id'] = $row['user_id'];
            $list['account_id'] = $row['account_id'];
            $list['account_name'] = $row['account_name'];
            $list['user_category'] = $row['user_category'];

            if($row['user_category'] == "J"){
                $fetch_judge = $mysqli->query("SELECT * FROM tbl_judges WHERE judge_id='$row[account_id]'");
                $judge_row = $fetch_judge->fetch_assoc();
                $list['judge_name'] = $judge_row['judge_name'];
                $list['judge_affiliation'] = $judge_row['judge_affiliation'];
                $list['judge_qualification'] = $judge_row['judge_qualification'];
                $list['judge_img'] = $judge_row['judge_img']; 
            }else{
                $fetch_participant = $mysqli->query("SELECT * FROM tbl_participants WHERE participant_id='$row[account_id]'");
                $participant_row = $fetch_participant->fetch_assoc();
                $list['participant_name'] = $participant_row['participant_name'];
                $list['participant_year'] = $participant_row['participant_year'];
                $list['participant_img'] = $participant_row['participant_img'];
            }

            array_push($response, $list);
        }
    } else {
        $list = array();
        $list['username'] = "";
        $list['user_id'] = 0;
        $list['user_category'] = "";
        $list['account_id'] = 0;
        $list['account_name'] = "";

        array_push($response, $list);
    }

    echo json_encode($response);
}
