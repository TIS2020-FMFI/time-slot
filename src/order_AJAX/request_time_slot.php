<?php
session_start();
include('../db.php');

if (!$mysqli->connect_errno) {
    if ($_SESSION['active_time_slot'] != []){


        $sql_create_truck = "INSERT INTO `truck` SET EVC='{$_POST['evc']}' ";
        if ($result1 = $mysqli->query($sql_create_truck)) {
            // toto bude asi chyba ak bude vela userov prihlasenich a vytvarat time sloty
            $last_id_truck = $mysqli->insert_id;
            echo '1';
        }else{

            echo '2';
        }
        $sql_create_truck_driver1 = "INSERT INTO `truck_driver` SET full_name='{$_POST['truck_driver1']}'";
        if ($result2 = $mysqli->query($sql_create_truck_driver1)) {
            // toto bude asi chyba ak bude vela userov prihlasenich a vytvarat time sloty
            $last_id_truck_driver_1 = $mysqli->insert_id;
            echo '1';
        }else{

            echo '2';
        }
        if ($_POST['truck_driver2'] != ""){
            $sql_create_truck_driver2 = "INSERT INTO `truck_driver` SET full_name='{$_POST['truck_driver2']}'";
            if ($result3 = $mysqli->query($sql_create_truck_driver2)) {
                // toto bude asi chyba ak bude vela userov prihlasenich a vytvarat time sloty
                $last_id_truck_driver_2 = $mysqli->insert_id;
                echo '1';
            }else{

                echo '2';
            }
        }
        if ($_POST['truck_driver2'] != ""){
                $string_of_drivers_id = $last_id_truck_driver_1.' '.$last_id_truck_driver_2;
        }else{
            $string_of_drivers_id = $last_id_truck_driver_1.'';
        }
        $main_sql="UPDATE `time_slot`  SET state='requested',id_external_dispatcher='{$_SESSION['id']}',truck_driver_ids='{$string_of_drivers_id}',id_truck='{$last_id_truck}' WHERE id='{$_SESSION['active_time_slot']['id']}' "; // definuj dopyt
        if ($result4 = $mysqli->query($main_sql)) {

            $_SESSION['active_time_slot'] = [];
            echo '1';
        }else{

            echo '2';
        }
    }
    else{
        echo '6';
    }
} else {
    echo '3';
}
