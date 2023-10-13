<?php
include '../core/config.php';

$event_id = (int) $_POST['event_id'];

$event_status = getEventData($event_id,"event_status");
if($event_status == 'S'){
    $event_mechanics = getEventData($event_id,"event_mechanics");

    $sql = "DELETE FROM tbl_events WHERE event_id = '$event_id'";
    $res = $mysqli->query($sql);
    if($res == 1){
        $uploadDirectory = "../assets/img/mechanics/";
        $event_mechanics != "no_image.png" ? unlink($uploadDirectory . $event_mechanics):"";

        $mysqli->query("DELETE FROM tbl_event_criterias WHERE event_id = '$event_id'");
        $mysqli->query("DELETE FROM tbl_event_judges WHERE event_id = '$event_id'");
        $mysqli->query("DELETE FROM tbl_event_participants WHERE event_id = '$event_id'");
    }
    echo $res;
}else{
    echo 2;
}


