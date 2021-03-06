<?php
include('../db.php');
date_default_timezone_set("Europe/Bratislava");

$next_start_point_of_generation = strtotime('today'); //2 week ago -
//  treba specifikovat ku ktoremu dnu to zalohujeme a NE-musi to byt jednotne s clear_time_slot.php
// a do sql sciptu podmienku Where end_time_slot <=  TIMESTAMP('{$next_start_point_of_generation}')
// oporucanie --> $next_start_point_of_generation = strtotime('1 days ago'); // to znamena ze data uz su ozaj v hotovich stavoch a nemala by nenast chyba
$date = date("Y-m-d", $next_start_point_of_generation);
echo 'DATA zalohujeme k datumu  '. $date . ' <br> ';
if (!$mysqli->connect_errno) {
    $sql = "INSERT INTO `dump_table` ( `id`, `gate_number`, `company_name`, `first_ruck_driver`, `second_ruck_driver`, `truck_number`, `destination`, `cargo`, `start_date_time_slot`, `end_date_time_slot`, `state` )
    (SELECT * FROM (SELECT id,
        id_gate,
        (SELECT meno_splocnosti
         FROM employee
         WHERE id = id_external_dispatcher ), 
        truck_driver_1,
        truck_driver_2 , 
        evc_truck, 
        destination,
        cargo, 
        start_date_time, 
        end_date_time,
        state
    FROM time_slot) as `T` WHERE TIMESTAMP ('{$date}') >= end_date_time)
    ON DUPLICATE KEY UPDATE 
        gate_number = VALUES (`gate_number`),
        company_name = VALUES (`company_name`),
        first_ruck_driver = VALUES (`first_ruck_driver`),
        second_ruck_driver = VALUES (`second_ruck_driver`),
        truck_number = VALUES (`truck_number`),
        destination = VALUES (`destination`),
        cargo = VALUES (`cargo`),
        start_date_time_slot = VALUES (`start_date_time_slot`),
        end_date_time_slot = VALUES (`end_date_time_slot`),
        state = VALUES (`state`)";
    if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
        echo "Databaza bola zalohovana na disku  ".mysqli_affected_rows($mysqli). "<br> ";
    } else {
        echo "CHYBA SKRIPTU <br> ";
    }
}else{
    echo "CHYBA PRIPOJENIA K DB <br> ";
}
