<?php
include('../db.php');
session_start();

date_default_timezone_set("Europe/Bratislava");
// vypocet pre zistenie o dnesneho rana a dna zatim
$time_star_show =  strtotime('now');
$date_start = date("Y-m-d", $time_star_show);
$date_start .= ' 00:00:00';
$time_end_show =  strtotime('tomorrow');
$date_end = date("Y-m-d", $time_end_show);
$date_end .= ' 00:00:00';

if (isset($_SESSION['role'])){
    if ($_SESSION['role'] == 'GM' || $_SESSION['role'] == 'IND' || $_SESSION['role'] == 'AD') {
        if (!$mysqli->connect_errno) {
            $sql = "SELECT id, id_gate, DATE( start_date_time ) as reale_day , start_date_time,evc_truck,
                    truck_driver_1 as driver1,
                    truck_driver_2 as driver2,
                    destination ,
                    cargo,
                    (select meno_splocnosti from employee where id=id_external_dispatcher)
                    FROM time_slot
                    where state = 'booked' and (start_date_time  BETWEEN '{$date_start}' AND '{$date_end}')
                    ORDER BY id_gate ASC , start_date_time ASC ";
            if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
                $vysl = $result->fetch_all();
                header("Content-Type:application/json");
                echo json_encode($vysl);
            } else{
                echo 'Wrong SQL server <strong>gate_man_AJAX/load_all_time_slots.php</strong> .';
            }
        }else{
            echo 'Could not access the server.';
        }
    } else {
        echo 'Wrong user.';
    }
}else{
    echo 'Please log <a href="../index.php">in</a>';
}
