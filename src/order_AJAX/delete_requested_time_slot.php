<?php
session_start();
include('../db.php');

if ($_SESSION['active_time_slot'] != "" && ($_SESSION['role'] == "IND" || $_SESSION['role'] == "AD" || $_SESSION['role'] == "EXD" )){
    $sql="UPDATE `time_slot`  SET 
                    id_external_dispatcher=DEFAULT,
                    evc_truck=DEFAULT,
                    truck_driver_1=DEFAULT,
                    truck_driver_2=DEFAULT,
                    destination=DEFAULT,
                    cargo=DEFAULT,
                    state=DEFAULT,
                    ocupide_start_time=DEFAULT,
                    ocupide_end_time=DEFAULT
    WHERE id='{$_SESSION['active_time_slot']}' and 
     state='{$_SESSION['active_time_slot_state']}' and 
    (TIMESTAMP(NOW()) BETWEEN TIMESTAMP(ocupide_start_time) AND TIMESTAMP(ocupide_end_time)) = '1'"; // definuj dopyt
    if ($result = $mysqli->query($sql)) {
        $_SESSION['active_time_slot'] = "";
        $_SESSION['active_time_slot_state'] = '';
        if (($_SESSION['role'] == "IND" || $_SESSION['role'] == "AD" )){
            echo '2';
        }else if ($_SESSION['role'] == "EXD" ){
            echo '1';
        }else{
            echo '3';
        }
    }else{
        echo '4';
    }
}else{
    echo '5';
}