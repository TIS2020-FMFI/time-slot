<?php
session_start();
include('../db.php');
if ($_SESSION['active_time_slot'] != "" ) {
    if ( $_SESSION['active_time_slot_state'] == 'prepared' ){
        $sql="UPDATE `time_slot`  SET ocupide_start_time=DEFAULT ,ocupide_end_time=DEFAULT,state=DEFAULT WHERE id='{$_SESSION['active_time_slot']}' and (TIMESTAMP(NOW()) BETWEEN TIMESTAMP(ocupide_start_time) AND TIMESTAMP(ocupide_end_time)) = '1'"; // definuj dopyt

    }else{
        $sql="UPDATE `time_slot`  SET ocupide_start_time=DEFAULT ,ocupide_end_time=DEFAULT WHERE id='{$_SESSION['active_time_slot']}' and (TIMESTAMP(NOW()) BETWEEN TIMESTAMP(ocupide_start_time) AND TIMESTAMP(ocupide_end_time)) = '1' "; // definuj dopyt

    }
    if ($result = $mysqli->query($sql)) {
        $_SESSION['active_time_slot'] = "";
        $_SESSION['active_time_slot_state'] = '';
        if ($_SESSION['role'] == 'EXD'){
            echo '2';
        }else if ($_SESSION['role'] == 'AD'||$_SESSION['role'] == 'IND'){
            echo '1';
        }else{
            echo '3';
        }
    }else{
        echo '4';
    }
}else{
    // pokial prebehol automaticke odstranenie time slotu po vyprsani casoacu
    // ale order stranka je stale otvorena aby po refresi bolo automaticky targetnuti na svoju prislusnu stranku ktora mu prislucha
    // bud EXD alebo IND/AD
    if ($_SESSION['role'] == 'EXD'){
        echo '2';
    }else if ($_SESSION['role'] == 'AD'||$_SESSION['role'] == 'IND'){
        echo '1';
    }else{
        echo '3';
    }
}