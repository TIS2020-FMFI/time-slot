<?php
include('../db.php');
include('dump.php');
date_default_timezone_set("Europe/Bratislava");

$next_start_point_of_generation_clear = strtotime('1 week ago'); //  1 tizdne koli tomu ako sme sa dohodli s p.p
$date_clear = date("Y-m-d", $next_start_point_of_generation_clear);
echo 'DATA cistime k datumu  '. $date_clear . ' <br> ';
if (!$mysqli->connect_errno) {
    $sql = "delete from time_slot where TIMESTAMP ($date_clear) < end_date_time  ";
    if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
        echo "VYCISTENA DB(TIME SLOTS)<br>";
    } else{
        echo "CHYBA SKRIPTU <br> ";
    }
}else {
    echo 'Serverova chyba databaza nieje pripojena';
}
