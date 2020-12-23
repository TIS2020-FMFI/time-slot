<?php
include("../db.php");
session_start();
if ($_SESSION['active_time_slot'] != "" && ($_SESSION['role'] == "IND" || $_SESSION['role'] == "AD")){
    $sql="DELETE FROM time_slot WHERE id = '{$_SESSION['active_time_slot']}' "; // definuj dopyt
    if ($result = $mysqli->query($sql)) {
        $_SESSION['active_time_slot'] = "";
        $_SESSION['active_time_slot_state'] = '';
        if ($_SESSION['role'] == 'AD'||$_SESSION['role'] == 'IND'){
            echo '1';
        }
    }else{
        echo '2';
    }
}else{
    echo '3';
}