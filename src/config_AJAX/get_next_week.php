<?php
date_default_timezone_set("Europe/Bratislava");
$next_start_point_of_generation = strtotime('next Monday', strtotime('now')); // treba specifikovat format generovania napr. UTC 00:00
$date_monday = date("d-m-Y", $next_start_point_of_generation);
$tomorrow_of_today_tuesday = date('d-m-Y', strtotime($date_monday . " +1 days"));
$tomorrow_of_today_wednesday = date('d-m-Y', strtotime($date_monday . " +2 days"));
$tomorrow_of_today_thursday = date('d-m-Y', strtotime($date_monday . " +3 days"));
$tomorrow_of_today_friday = date('d-m-Y', strtotime($date_monday . " +4 days"));
$tomorrow_of_today_saturday = date('d-m-Y', strtotime($date_monday . " +5 days"));
$tomorrow_of_today_sunday = date('d-m-Y', strtotime($date_monday . " +6 days"));

echo $date_monday.'|'.$tomorrow_of_today_tuesday.'|'.$tomorrow_of_today_wednesday
    .'|'.$tomorrow_of_today_thursday.'|'.$tomorrow_of_today_friday.'|'.$tomorrow_of_today_saturday
    .'|'.$tomorrow_of_today_sunday;