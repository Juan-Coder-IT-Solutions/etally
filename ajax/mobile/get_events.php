<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: *");
header('Content-Type: text/html; charset=utf-8');

include '../../core/config.php';

$data = json_decode(file_get_contents("php://input"));
$user_id = $data->user_id;
$user_category = $data->user_category;

if (isset($user_id)) {

    if ($user_category == "J") {
        $sql = "SELECT e.event_id, ej.event_judge_id, e.event_name, e.event_description, e.event_start, e.event_status, e.event_mechanics, e.event_venue FROM tbl_event_judges ej LEFT JOIN tbl_events e ON ej.event_id=e.event_id WHERE judge_id='$user_id' ORDER BY e.event_start DESC";
        $fetch = $mysqli->query($sql);

        $response = array();

        while ($row = $fetch->fetch_assoc()) {
            $list = array();
            $list['event_judge_id'] = $row['event_judge_id'];
            $list['event_id'] = $row['event_id'];
            $list['event_name'] = $row['event_name'];
            $list['event_mechanics'] = $row['event_mechanics'];
            $list['event_description'] = $row['event_description'];
            $list['event_venue'] = $row['event_venue'];
            $list['event_start'] = date("M d, Y h:i A", strtotime(($row['event_start'])));
            $list['status'] = $row['event_status'];

            // fetch judges
            $list_judges_response = array();
            $fetch_judges = $mysqli->query("SELECT judge_name, judge_affiliation, judge_qualification, judge_img, ej.judge_no FROM tbl_event_judges ej LEFT JOIN tbl_judges j ON ej.judge_id=j.judge_id WHERE ej.event_id='$row[event_id]' ORDER BY ej.judge_no ASC");
            while ($judges_row = $fetch_judges->fetch_assoc()) {
                $list_judges = array();
                $list_judges['judge_name'] = $judges_row['judge_name'];
                $list_judges['judge_affiliation'] = $judges_row['judge_affiliation'];
                $list_judges['judge_qualification'] = $judges_row['judge_qualification'];
                $list_judges['judge_img'] = $judges_row['judge_img'];
                $list_judges['judge_no'] = $judges_row['judge_no'];
                array_push($list_judges_response, $list_judges);
            }

            $list['judges_row'] = $list_judges_response;

            // fetch participants
            $list_participants_response = array();
            $fetch_participants = $mysqli->query("SELECT * FROM tbl_participants p LEFT JOIN tbl_event_participants ep ON p.participant_id=ep.participant_id LEFT JOIN tbl_programs pr ON p.program_id=pr.program_id WHERE event_id='$row[event_id]'");
            while ($participants_row = $fetch_participants->fetch_assoc()) {
                $list_participants = array();
                $list_participants['participant_id'] = $participants_row['participant_id'];
                $list_participants['participant_name'] = $participants_row['participant_name'];
                $list_participants['participant_affiliation'] = $participants_row['participant_affiliation'];
                $list_participants['participant_img'] = $participants_row['participant_img'];
                $list_participants['program'] = $participants_row['program_name'];
                array_push($list_participants_response, $list_participants);
            }

            $list['participants_row'] = $list_participants_response;

            array_push($response, $list);
        }
    } else {
        $sql = "SELECT e.event_id, ep.event_participant_id, e.event_name, e.event_description, e.event_start, e.event_status, e.event_mechanics, e.event_venue FROM tbl_event_participants ep LEFT JOIN tbl_events e ON ep.event_id=e.event_id WHERE participant_id='$user_id' ORDER BY e.event_start DESC";
        $fetch = $mysqli->query($sql);
        $response = array();

        while ($row = $fetch->fetch_assoc()) {
            $list = array();
            $list['event_participant_id'] = $row['event_participant_id'];
            $list['event_id'] = $row['event_id'];
            $list['event_name'] = $row['event_name'];
            $list['event_mechanics'] = $row['event_mechanics'];
            $list['event_description'] = $row['event_description'];
            $list['event_venue'] = $row['event_venue'];
            $list['event_start'] = date("M d, Y h:i A", strtotime(($row['event_start'])));
            $list['status'] = $row['event_status'];

            // fetch judges
            $list_judges_response = array();
            $fetch_judges = $mysqli->query("SELECT judge_name, judge_affiliation, judge_qualification, judge_img, ej.judge_no FROM tbl_event_judges ej LEFT JOIN tbl_judges j ON ej.judge_id=j.judge_id WHERE ej.event_id='$row[event_id]' ORDER BY ej.judge_no ASC");
            while ($judges_row = $fetch_judges->fetch_assoc()) {
                $list_judges = array();
                $list_judges['judge_name'] = $judges_row['judge_name'];
                $list_judges['judge_affiliation'] = $judges_row['judge_affiliation'];
                $list_judges['judge_qualification'] = $judges_row['judge_qualification'];
                $list_judges['judge_img'] = $judges_row['judge_img'];
                $list_judges['judge_no'] = $judges_row['judge_no'];
                array_push($list_judges_response, $list_judges);
            }

            $list['judges_row'] = $list_judges_response;

            // fetch participants
            $list_participants_response = array();
            $fetch_participants = $mysqli->query("SELECT * FROM tbl_participants p LEFT JOIN tbl_event_participants ep ON p.participant_id=ep.participant_id LEFT JOIN tbl_programs pr ON p.program_id=pr.program_id WHERE event_id='$row[event_id]'");
            while ($participants_row = $fetch_participants->fetch_assoc()) {
                $list_participants = array();
                $list_participants['participant_id'] = $participants_row['participant_id'];
                $list_participants['participant_name'] = $participants_row['participant_name'];
                $list_participants['participant_affiliation'] = $participants_row['participant_affiliation'];
                $list_participants['participant_img'] = $participants_row['participant_img'];
                $list_participants['program'] = $participants_row['program_name'];
                array_push($list_participants_response, $list_participants);
            }

            $list['participants_row'] = $list_participants_response;


            array_push($response, $list);
        }
    }

    echo json_encode($response);
}
