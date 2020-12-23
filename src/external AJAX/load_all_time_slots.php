<?php
session_start();
include('../db.php');
if (isset($_SESSION['id']) && $_SESSION['role'] == 'EXD'){
    if (!$mysqli->connect_errno) {
        $sql = "SELECT id, id_gate, DATE( start_date_time ) as reale_day , start_date_time, end_date_time, state,evc_truck,
                truck_driver_1 as driver1,
                truck_driver_2 as driver2,
                destination ,
                cargo
                FROM time_slot where state = 'prepared' or id_external_dispatcher = '{$_SESSION['id']}' and  start_date_time > CURDATE() - INTERVAL 7 DAY and start_date_time < CURDATE() +  INTERVAL 14 DAY 
                
                ORDER BY id_gate ASC , start_date_time ASC";
        if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
            $vysl =  $result->fetch_all();
            header("Content-Type:application/json");
            echo json_encode($vysl);
        }
    }
}