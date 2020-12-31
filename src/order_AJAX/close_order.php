<?php
session_start();
include('../db.php');
if (!$mysqli->connect_errno) {
    if (isset($_SESSION['active_time_slot'])){
        if ($_SESSION['active_time_slot'] != "" && ($_SESSION['role'] == 'EXD' || $_SESSION['role'] == 'AD'||$_SESSION['role'] == 'IND') ) {
            if ( $_SESSION['active_time_slot_state'] == 'prepared' ){
                $sql="UPDATE `time_slot`  SET 
                            ocupide_start_time=DEFAULT ,
                            ocupide_end_time=DEFAULT,
                            state=DEFAULT
                        WHERE id='{$_SESSION['active_time_slot']}' and
                              (TIMESTAMP(NOW()) BETWEEN TIMESTAMP(ocupide_start_time) AND TIMESTAMP(ocupide_end_time)) = '1'";
            }else{
                $sql="UPDATE `time_slot`  SET 
                            ocupide_start_time=DEFAULT ,
                            ocupide_end_time=DEFAULT 
                        WHERE id='{$_SESSION['active_time_slot']}' and 
                            (TIMESTAMP(NOW()) BETWEEN TIMESTAMP(ocupide_start_time) AND TIMESTAMP(ocupide_end_time)) = '1' ";
            }
            if ($result = $mysqli->query($sql)) {
                $_SESSION['active_time_slot'] = "";
                $_SESSION['active_time_slot_state'] = '';
                if ($_SESSION['role'] == 'EXD'){
                    echo '2';
                }else if ($_SESSION['role'] == 'AD'||$_SESSION['role'] == 'IND'){
                    echo '1';
                }
            }else{
                echo 'Chybne sql na stranke <strong>order_AJAX/close_order.php</strong> '.$sql;
            }
        }else{
            if ($_SESSION['role'] == 'EXD'){
                echo 'Time-slot has been removed automatically, <a href="external_dispatcher.php">choose another one</a>.';
            }else if ($_SESSION['role'] == 'AD'||$_SESSION['role'] == 'IND'){
                echo 'Time-slot has been removed automatically, <a href="internal_dispatcher.php">choose another one</a>.';
            }
        }
    }else{
        echo 'Please log <a href="../index.php">in</a>';
    }
}else{
    echo 'Could not access the server.';
}