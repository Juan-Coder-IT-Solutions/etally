<?php
include '../core/config.php';

$table_name = "tbl_events";

$event_id			= (int) $_POST['event_id'];
$event_category_id	= (int) $_POST['event_category_id'];
$event_name			= $_POST['event_name'];
$event_description	= $_POST['event_description'];
$event_start        = $_POST['event_start'];
$participant_needed = $_POST['participant_needed'];
$judge_needed		= $_POST['judge_needed'];
$event_venue		= $_POST['event_venue'];

$form_data = array(
	'event_name'            => $event_name,
	'event_category_id'		=> $event_category_id,
	'event_description'		=> $event_description,
	'event_start'           => $event_start,
	'participant_needed'	=> $participant_needed,
	'judge_needed'			=> $judge_needed,
	'event_venue'			=> $event_venue,
	'protest_hrs'			=> $protest_hrs
);

if (isset($_FILES["event_mechanics"]) && $_FILES["event_mechanics"]["error"] == 0) {
	$filename = generateRandomString(9).".pdf";
	$uploadDirectory = "../assets/img/mechanics/";
	$uploadedFile = $uploadDirectory . $filename;

	if (!file_exists($uploadedFile)) {
		if (move_uploaded_file($_FILES["event_mechanics"]["tmp_name"], $uploadedFile)) {
			$form_data['event_mechanics'] = $filename;
			if($event_id > 0){
				$old_mechanics = getEventData($event_id,"event_mechanics");
				if($old_mechanics != "no_image.png"){
					unlink($uploadDirectory . $old_mechanics);
				}
			}
		}
	}
}

$sql = $event_id > 0? sql_update($table_name, $form_data, "event_id = '$event_id'") : sql_insert($table_name, $form_data);

echo $mysqli->query($sql);
