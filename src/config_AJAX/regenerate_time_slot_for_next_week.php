<?php
include('../db.php');
date_default_timezone_set("Europe/Bratislava");
$next_start_point_of_generation = strtotime('next Monday', strtotime('now')); // treba specifikovat format generovania napr. UTC 00:00
$date = date("d-m-Y", $next_start_point_of_generation);
echo 'DATA cistime k datumu  '. $date . ' <br> ';
$sql = "select  start_date_time,end_date_time,(select CONCAT(meno,' ',priezvisko) as full_name from employee where id = id_external_dispatcher)from time_slot where start_date_time >= TIMESTAMP( '{$date}' ) and id_external_dispatcher != 0"; // delete from `time_slot` where start_date_time  >=  TIMESTAMP($date)
if ($result = $mysqli->query($sql)){  // vykonaj dopyt
    $vysl =  $result->fetch_all();
    echo json_encode($vysl).'<br>'; // kvoli tomu aby sa dalo inforomovat o odstraneni time-slotov danych userov
} else{
    echo "CHYBA SKRIPTU <br> ";
}

$sql = "delete from time_slot where start_date_time >= TIMESTAMP( '{$date}' ) "; // delete from `time_slot` where start_date_time >= TIMESTAMP($date)
if ($result = $mysqli->query($sql)){  // vykonaj dopyt
    //echo "VYCISTENA DB(TIME SLOTS)<br>";
} else{
    echo "CHYBA SKRIPTU <br> ";
}
include('../generate_scripts/generate_script_default.php');
