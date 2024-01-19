<?php
include '../core/config.php';

$radios		= $_POST['radio'];
$event_id	= $_POST['event_id'];
$rank		= floor($_POST['rank_result']);

$event_participant_ids = $_POST['event_participant_id'];

$judge_votes = [];

foreach($radios as $judge_id => $event_participant_id){
	if(!array_key_exists($event_participant_id,$judge_votes)){
		$judge_votes[$event_participant_id] = 1;
	}else{
		$judge_votes[$event_participant_id] += 1;
	}
}
arsort($judge_votes);
if(count($judge_votes)>1){
	$count_checker = 1;
	$last_count = 0;
	foreach($judge_votes as $event_participant_id => $countVotes){
		if($count_checker == 2){
			if($last_count == $countVotes){
				echo -1;
				die;
			}
		}
		$last_count = $countVotes;
		$count_checker++;
	}
}

foreach($event_participant_ids as $event_participant_id){
	if(!array_key_exists($event_participant_id,$judge_votes)){
		$judge_votes[$event_participant_id] = 0;
	}
}

arsort($judge_votes);

// echo json_encode($judge_votes);

// $event_id = $_POST['event_id'];
// $rank = floor($_POST['rank_result']);
// $rank_orders = $_POST['rank_orders'];

foreach($judge_votes as $event_participant_id => $value){
    $form_detail = array('rank' => $rank++);
	$sql = sql_update("tbl_event_participants", $form_detail, "event_participant_id = '$event_participant_id'");
	$mysqli->query($sql);
}

echo 1;