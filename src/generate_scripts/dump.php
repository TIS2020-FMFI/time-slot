<?php
$next_start_point_of_generation = strtotime('2 week ago'); //  treba specifikovat format generovania napr. UTC 00:00
$date = date("Y-m-d", $next_start_point_of_generation);
echo 'DATA cistime k datumu  '. $date . ' <br> ';
if (!$mysqli->connect_errno) {
    $sql = "INSERT INTO `dump_table` ( `id` , `gate_number` , `full_neme_dispatcher` , `first_ruck_driver` , `second_ruck_driver` , `truck_number` , `destination` , `cargo` , `start_date_time_slot` , `end_date_time_slot` , `state` )
    SELECT id,
        id_gate,
        (SELECT CONCAT( meno, ' ', priezvisko )
         FROM employee
         WHERE id = id_external_dispatcher ), 
        (SELECT full_name
         FROM truck_driver
         WHERE id = id_truck_driver_1 ), 
        (SELECT full_name
         FROM truck_driver
         WHERE id =id_truck_driver_2 ), 
        evc_truck, 
        (SELECT destination
         FROM destination_order
         WHERE id = id_destination_order ),
        (SELECT commodity
         FROM destination_order
         WHERE id = id_destination_order ), 
        start_date_time, 
        end_date_time,
        state
    FROM time_slot
    ON DUPLICATE KEY UPDATE 
        gate_number = VALUES (`gate_number`),
        full_neme_dispatcher = VALUES (`full_neme_dispatcher`),
        first_ruck_driver = VALUES (`first_ruck_driver`),
        second_ruck_driver = VALUES (`second_ruck_driver`),
        truck_number = VALUES (`truck_number`),
        destination = VALUES (`destination`),
        cargo = VALUES (`cargo`),
        start_date_time_slot = VALUES (`start_date_time_slot`),
        end_date_time_slot = VALUES (`end_date_time_slot`),
        state = VALUES (`state`)";
    if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
        echo "Databaza bola zalohovana na disku<br>";
    } else {
        echo "CHYBA SKRIPTU <br> ";
    }
}else{
    echo "CHYBA PRIPOJENIA K DB <br> ";
}
