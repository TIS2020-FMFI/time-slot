<?php
session_start();
include('../db.php');

if (!$mysqli->connect_errno) {
    if ($_SESSION['active_time_slot'] != "" && $_SESSION['role'] == "EXD" &&
        ($_SESSION['active_time_slot_state'] != 'prepared' ||  $_SESSION['active_time_slot_state'] != 'occupied')){


        $main_sql="UPDATE `time_slot`  SET state='requested',
                    id_external_dispatcher='{$_SESSION['id']}',
                    evc_truck='{$_POST['evc']}',
                    truck_driver_1='{$_POST['kam1']}',
                    truck_driver_2='{$_POST['kam2']}',
                    destination='{$_POST['destination']}',
                    cargo='{$_POST['cargo']}'
                     WHERE id='{$_SESSION['active_time_slot']}' and id_gate='{$_POST['ramp']}'
                     and (TIMESTAMP(NOW()) BETWEEN TIMESTAMP(ocupide_start_time) AND TIMESTAMP(ocupide_end_time)) = '1' "; // definuj dopyt
        if ($result4 = $mysqli->query($main_sql)) {

            $_SESSION['active_time_slot'] = '';
            $_SESSION['active_time_slot_state'] = '';
            echo '1';
        }else{

            echo '2';
        }
        //
        //
        // CAST PRE AD A IND
        //
        //
    }else if ($_SESSION['active_time_slot'] != "" && ($_SESSION['role'] == "AD" || $_SESSION['role'] == "IND") &&
        ($_SESSION['active_time_slot_state'] != 'prepared' ||  $_SESSION['active_time_slot_state'] != 'occupied')){
        $sql_select_employee = "SELECT id FROM `employee` WHERE meno_splocnosti='{$_POST['company_name']}'";
        if ($result = $mysqli->query($sql_select_employee)) {
            $vysl = $result->fetch_assoc();
            $id_of_external_dispatcher = $vysl['id'];
            echo '1';
        }else{

            echo '2';
        }



        $main_sql="UPDATE `time_slot`  SET state='requested',
                    id_external_dispatcher='{$id_of_external_dispatcher}',
                     evc_truck='{$_POST['evc']}',
                    truck_driver_1='{$_POST['kam1']}',
                    truck_driver_2='{$_POST['kam2']}',
                    destination='{$_POST['destination']}',
                    cargo='{$_POST['cargo']}'
                     WHERE id='{$_SESSION['active_time_slot']}' and id_gate='{$_POST['ramp']}'  
                     and (TIMESTAMP(NOW()) BETWEEN TIMESTAMP(ocupide_start_time) AND TIMESTAMP(ocupide_end_time)) = '1'"; // definuj dopyt
        if ($result4 = $mysqli->query($main_sql)) {

            $_SESSION['active_time_slot'] = '';
            $_SESSION['active_time_slot_state'] = '';
            echo '1';
        }else{
            echo '2';
        }
    }else{
        echo '6';
    }
} else {
    echo '3';
}
