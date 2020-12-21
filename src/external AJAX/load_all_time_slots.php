<?php
session_start();
include('../db.php');
if (isset($_SESSION['id']) && $_SESSION['role'] == 'EXD'){
    if (!$mysqli->connect_errno) {
        $sql = "SELECT id, id_gate, DATE( start_date_time ) as reale_day , start_date_time, end_date_time, state,evc_truck,
                (select full_name from truck_driver where id=id_truck_driver_1),(select full_name from truck_driver where id=id_truck_driver_2),
                (select destination from destination_cargo where id=id_destination_order),
                (select cargo from destination_cargo where id=id_destination_order)
                FROM time_slot where state = 'prepared' or id_external_dispatcher = '{$_SESSION['id']}' and  start_date_time > CURDATE() - INTERVAL 7 DAY and start_date_time < CURDATE() +  INTERVAL 14 DAY 
                
                ORDER BY id_gate ASC , start_date_time ASC";
        if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
            $vysl =  $result->fetch_all();
            header("Content-Type:application/json");
            echo json_encode($vysl);
        }
    }
}