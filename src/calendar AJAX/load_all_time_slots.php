<?php
include('../db.php');

if (!$mysqli->connect_errno) {
    $sql = "SELECT id, id_gate, DATE( start_date_time ) as reale_day , start_date_time, end_date_time, state,evc_truck,
                (select full_name from truck_driver where id=id_truck_driver_1),(select full_name from truck_driver where id=id_truck_driver_2)
                FROM time_slot   ORDER BY id_gate ASC , start_date_time ASC";
    if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
        $vysl =  $result->fetch_all();
        header("Content-Type:application/json");
        echo json_encode($vysl);
    }
}