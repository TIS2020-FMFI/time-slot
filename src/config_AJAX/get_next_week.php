<?php
date_default_timezone_set("Europe/Bratislava");
$next_start_point_of_generation = strtotime('next Monday', strtotime('now')); //  treba specifikovat format generovania napr. UTC 00:00
$date_monday = date("Y-m-d", $next_start_point_of_generation);
$tomorrow_of_today_tuesday = date('Y-m-d', strtotime($date_monday . " +1 days"));
$tomorrow_of_today_wednesday = date('Y-m-d', strtotime($date_monday . " +2 days"));
$tomorrow_of_today_thursday = date('Y-m-d', strtotime($date_monday . " +3 days"));
$tomorrow_of_today_friday = date('Y-m-d', strtotime($date_monday . " +4 days"));
$tomorrow_of_today_saturday = date('Y-m-d', strtotime($date_monday . " +5 days"));
$tomorrow_of_today_sunday = date('Y-m-d', strtotime($date_monday . " +6 days"));

echo $date_monday.'|'.$tomorrow_of_today_tuesday.'|'.$tomorrow_of_today_wednesday
    .'|'.$tomorrow_of_today_thursday.'|'.$tomorrow_of_today_friday.'|'.$tomorrow_of_today_saturday
    .'|'.$tomorrow_of_today_sunday;