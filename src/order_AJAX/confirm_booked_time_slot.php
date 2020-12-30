<?php
session_start();
include('../db.php');
if (!$mysqli->connect_errno) {
    if (isset($_SESSION['active_time_slot'])){
        if ($_SESSION['active_time_slot'] != "" && ($_SESSION['role'] == "IND" || $_SESSION['role'] == "AD") && $_SESSION['active_time_slot_state'] == 'booked' ) {
            $sql = "UPDATE `time_slot`  SET state='finished'
                         WHERE id='{$_SESSION['active_time_slot']}' 
                         and (TIMESTAMP(NOW()) BETWEEN TIMESTAMP(ocupide_start_time) AND TIMESTAMP(ocupide_end_time)) = '1' ";
            if ($result = $mysqli->query($sql)) {

                $_SESSION['active_time_slot'] = '';
                $_SESSION['active_time_slot_state'] = '';
                echo '1';
            }else{
                echo 'Chybne sql na stranke <strong>order_AJAX/confirm_requested_time_slot.php</strong> '.$sql;
            }
        }else{
            echo 'Not valid user or this operation';
        }
    }else{
        echo 'Please log <a href="../index.php">in</a>';
    }
}else {
    echo 'Serverova chyba databaza nieje pripojena';
}