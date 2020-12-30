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
                        echo 'Chyba sql <strong>config_AJAX/set_new_times.php</strong> '.$sql;
                    }
                }
                if ($founded){
                    echo '2$Chyba pri ukladani dat novich casov';
                }else{
                    echo '1$Nove casi boli ulozene';
                }
            }else{
                echo 'Nepodarilo sa spojit so serverom ';
            }
        }else{
            echo 'Not valid User';
        }
    }else{
        echo 'Please log <a href="../index.php">in</a>';
    }
}else{
    echo 'Neboly poslane data';
}
