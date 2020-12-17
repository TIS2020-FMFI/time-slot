<?php
include('dump.php');
$next_start_point_of_generation = strtotime('2 week ago'); //  treba specifikovat format generovania napr. UTC 00:00
$date = date("Y-m-d", $next_start_point_of_generation);
echo 'DATA cistime k datumu  '. $date . ' <br> ';
$sql = "delete from time_slot where TIMESTAMP ($date) < end_date_time  ";
if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
    echo "VYCISTENA DB(TIME SLOTS)<br>";
} else{
    echo "CHYBA SKRIPTU <br> ";
}

// Pokial to chces proste cele premzat len to odkomentuj !!!!
/*

$sql = "delete from time_slot where id > 0   ";
if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
    echo "VYCISTENA DB(TIME SLOTS)<br>";
} else{
    echo "CHYBA SKRIPTU <br> ";
}
*/