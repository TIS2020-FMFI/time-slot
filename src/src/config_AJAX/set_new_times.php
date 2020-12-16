<?php
session_start();
include('../db.php');
if (isset($_SESSION['id']) && ($_SESSION['role'] == 'AD' ||  $_SESSION['role'] == 'IND')){
    $start_times = $_POST['send_array_start'];
    $end_times = $_POST['send_array_end'];
    $special_times = $_POST['send_array_special'];
    for ($day = 0;$day < count($start_times);$day++){
        $real_day_plus_one = $day+1;
        $sql = "UPDATE config_start_end_working 
                SET starting_hour='{$start_times[$day] }',
                ending_hour='{$end_times[$day] }',exception_status={$special_times[$day]} where id={$real_day_plus_one} ";
        if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
            echo 1;
        }else{
            echo 0;
        }
    }
}