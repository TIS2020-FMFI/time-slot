<?php
include('../db.php');
date_default_timezone_set("Europe/Bratislava");
//$utc = new DateTimeZone('UTC');
$time_star_show =  strtotime('now'); //  treba specifikovat format generovania napr. UTC 00:00
$date_start = date("Y-m-d", $time_star_show);
$date_start .= ' 00:00:00';
$time_end_show =  strtotime('tomorrow'); //  treba specifikovat format generovania napr. UTC 00:00
$date_end = date("Y-m-d", $time_end_show);
$date_end .= ' 00:00:00';

if (!$mysqli->connect_errno) {
    $sql = "SELECT id, id_gate, DATE( start_date_time ) as reale_day , start_date_time,evc_truck,
                truck_driver_1 as driver1,
                truck_driver_2 as driver2,
                destination ,
                cargo
                FROM time_slot
	            where state = 'booked' and (start_date_time  BETWEEN '{$date_start}' AND '{$date_end}')
                ORDER BY id_gate ASC , start_date_time ASC ";
    if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
        $vysl =  $result->fetch_all();
        header("Content-Type:application/json");
        echo json_encode($vysl);
    }
}
