<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: *");
header('Content-Type: text/html; charset=utf-8');

include '../../core/config.php';

$data = json_decode(file_get_contents("php://input"));
$user_id = $data->user_id;
$id = $data->id;

if (isset($id)) {
    if ($id > 0) {
        $sql = "SELECT * FROM tbl_event_judges ej LEFT JOIN tbl_events e ON ej.event_id=e.event_id WHERE e.event_status='F' AND e.event_id='$id' ORDER BY e.event_start DESC LIMIT 1";
    } else {
        $sql = "SELECT * FROM tbl_event_judges ej LEFT JOIN tbl_events e ON ej.event_id=e.event_id WHERE judge_id='$user_id' AND e.event_status='F' ORDER BY e.event_start DESC";
    }

    $fetch = $mysqli->query($sql);

    $data = array();
    while ($row = $fetch->fetch_assoc()) {
        $response = array();
        $response = $row;

        $response['judges'] = array();
        $judges = [];
        $fetch_judges = $mysqli->query("SELECT judge_name, j.judge_id, ej.judge_no FROM tbl_event_judges ej LEFT JOIN tbl_judges j ON ej.judge_id=j.judge_id WHERE ej.event_id='$row[event_id]' ORDER BY ej.judge_no ASC");
        while ($judges_row = $fetch_judges->fetch_assoc()) {
            $judges[] = $judges_row;
            array_push($response['judges'], $judges_row);
        }

        $fetch_participants = $mysqli->query("SELECT * FROM tbl_participants p LEFT JOIN tbl_event_participants ep ON p.participant_id=ep.participant_id WHERE event_id='$row[event_id]'");

        $response['participants'] = array();
        while ($participants_row = $fetch_participants->fetch_assoc()) {
            $participants_row['participant_result'] = $participants_row['rank'];
            // fetch judges
            $response_judges = [];
            $total_rank = 0;
            foreach ($judges as $judges_row) {
                $fetch_ranks = $mysqli->query("SELECT * from tbl_event_ranks WHERE event_id='$row[event_id]' and participant_id='$participants_row[participant_id]' and judge_id='$judges_row[judge_id]'");
                $ranks_row = $fetch_ranks->fetch_assoc();
                $judges_row['scores'] = $ranks_row['scores'];
                $judges_row['rank'] = $ranks_row['rank'];
                $total_rank += $ranks_row['rank'];
                array_push($response_judges, $judges_row);
            }

            $participants_row['total_rank'] = $total_rank;
            $participants_row['ranks'] = $response_judges;

            array_push($response['participants'], $participants_row);
        }


        array_push($data, $response);
    }

    echo json_encode($data);
}
