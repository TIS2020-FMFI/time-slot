<?php
session_start();
include('../db.php');
if ($_SESSION['active_time_slot'] == [] ) {//||$_SESSION['active_time_slot']['state'] != 'prepared'
    $sql="INSERT INTO `event_log` SET employee_id='{$_SESSION['id']}',task_event='Close without active time slot' ";
    if ($result = $mysqli->query($sql)) {
        //$_SESSION['active_time_slot'] = [];
        echo '4';
    }else{

        echo '???';
    }
}else{
    if (!$mysqli->connect_errno) {
        $sql2="INSERT INTO `event_log` SET employee_id='{$_SESSION['id']}',task_event='Close time slot {$_SESSION['active_time_slot']['id']}' ";
        if ($result = $mysqli->query($sql2)) {
        }else{
            echo '???';
        }
        $sql="UPDATE `time_slot`  SET state='prepared' WHERE id='{$_SESSION['active_time_slot']['id']}' "; // definuj dopyt
        if ($result = $mysqli->query($sql)) {
                $_SESSION['active_time_slot'] = [];
                echo '1';
        }else{

            echo '2';
        }

    }else {
        echo '3';
    }
}
