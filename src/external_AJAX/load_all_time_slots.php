<?php
session_start();
include('../db.php');

if (isset($_SESSION['role'])){
    if ( $_SESSION['role'] == 'EXD'){
        if (!$mysqli->connect_errno) {
            $sql = "SELECT id, id_gate, DATE( start_date_time ) as reale_day , start_date_time, end_date_time, state,evc_truck,
                    truck_driver_1 as driver1,
                    truck_driver_2 as driver2,
                    destination ,
                    cargo
                    FROM time_slot where 
                     (state = 'prepared' or id_external_dispatcher = '{$_SESSION['id']}')
                     and  start_date_time > CURDATE() - INTERVAL 7 DAY and start_date_time < CURDATE() +  INTERVAL 15 DAY 
                    ORDER BY id_gate ASC , start_date_time ASC";
            if ($result = $mysqli->query($sql)) {
                $vysl =  $result->fetch_all();
                header("Content-Type:application/json");
                echo json_encode($vysl);
            }else{
                echo 'Wrong SQL server <strong>external_AJAX/load_all_time_slots.php</strong> .';
            }
        }else{
            echo 'Could not connect to the server. Please check your <strong>internet connection</strong>.';
        }
    } else {
        echo 'Wrong user.';
    }
}else{
    echo 'Please <a href="../index.php">log in</a>';
}

