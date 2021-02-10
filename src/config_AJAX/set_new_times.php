<?php
session_start();
include('../db.php');

if (isset($_POST['send_array_start']) && isset($_POST['send_array_end']) && isset($_POST['send_array_special'])){
    $start_times = $_POST['send_array_start'];
    $end_times = $_POST['send_array_end'];
    $special_times = $_POST['send_array_special'];
    if (count($start_times) !== count($end_times) && count($start_times) !== count($special_times)){
        echo 'This Web page has been corupted <strong>Not valid amount of row columns in days / hours on server site</strong>';
        return;
    }
    if ((isset($_SESSION['role']) == 'AD' ||  isset($_SESSION['role']) == 'IND')){
        if ($_SESSION['role'] == 'AD' ||  $_SESSION['role'] == 'IND'){
            if (!$mysqli->connect_errno) {
                $founded = false;
                for ($day = 0;$day < count($start_times);$day++){
                    $real_day_plus_one = $day+1;
                    // sql injection
                    $norm_start_times = mysqli_real_escape_string($mysqli,$start_times[$day]);
                    $norm_end_times = mysqli_real_escape_string($mysqli,$end_times[$day]);
                    $norm_special_times = mysqli_real_escape_string($mysqli,$special_times[$day]);
                    $sql = "UPDATE config_start_end_working 
                        SET starting_hour='{$norm_start_times }',
                            ending_hour='{$norm_end_times }',
                            exception_status={$norm_special_times} 
                        where id={$real_day_plus_one} ";
                    if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
                        if (mysqli_affected_rows($mysqli) < 0){
                            $founded = true;
                        }
                    }else{
                        echo 'Wrong SQL server <strong>config_AJAX/set_new_times.php</strong>.';
                    }
                }
                if ($founded){
                    echo '2$Error occured with saving new times.';
                }else{
                    echo '1$New times set.';
                }
            }else{
                echo 'Could not connect to the server. Please check your <strong>internet connection</strong>.';
            }
        }else{
            echo 'The data is invalid.';
        }
    }else{
        echo 'Please <a href="../index.php">log in</a>';
    }
}else{
    echo 'Data not sent.';
}
