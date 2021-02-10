<?php
session_start();
include('../db.php');
if (!$mysqli->connect_errno) {
    if (isset($_SESSION['active_time_slot'])){
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
            (TIMESTAMP(NOW()) BETWEEN TIMESTAMP(ocupide_start_time) AND TIMESTAMP(ocupide_end_time)) = '1'";
            if ($result = $mysqli->query($sql)) {
                $_SESSION['active_time_slot'] = "";
                $_SESSION['active_time_slot_state'] = '';
                if ($_SESSION['role'] == 'EXD'){
                    echo '2';
                }else if ($_SESSION['role'] == 'AD'||$_SESSION['role'] == 'IND'){
                    echo '1';
                }
            }else{
                echo 'Wrong SQL server <strong>order_AJAX/delete_requested_time_slot.php</strong> .';
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