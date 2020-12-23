<?php
session_start();
include('../db.php');

if (!$mysqli->connect_errno) {
    if ($_SESSION['active_time_slot'] != "" && ($_SESSION['role'] == "IND" || $_SESSION['role'] == "AD") && $_SESSION['active_time_slot_state'] == 'booked' ) {

        $main_sql = "UPDATE `time_slot`  SET state='finished'
                     WHERE id='{$_SESSION['active_time_slot']}' 
                     and (TIMESTAMP(NOW()) BETWEEN TIMESTAMP(ocupide_start_time) AND TIMESTAMP(ocupide_end_time)) = '1' "; // definuj dopyt
        if ($result = $mysqli->query($main_sql)) {

            $_SESSION['active_time_slot'] = '';
            $_SESSION['active_time_slot_state'] = '';
            echo '1';
        } else {

            echo '2';
        }

    }else{
        echo '4';
    }
}else{
    echo '3';
}