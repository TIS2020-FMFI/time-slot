<?php
session_start();
include('../db.php');

if (isset($_POST['ramps'])){
    if (isset($_SESSION['role'])){
        if ( $_SESSION['role'] == 'AD' ||  $_SESSION['role'] == 'IND'){
            if (!$mysqli->connect_errno) {

                $norm_ramps =  mysqli_real_escape_string($mysqli,$_POST['ramps']);
                $sql = "UPDATE holidays SET holidays='{$norm_ramps}' WHERE id=2";
                if ($result = $mysqli->query($sql)) {
                    if (mysqli_affected_rows($mysqli) >= 0){
                        echo '1$New ramps set.';
                    }else{
                        echo '2$Error occured with saving new ramp settings.';
                    }
                }else{
                    echo 'Wrong SQL server <strong>config_AJAX/set_new_holidays.php</strong> .';
                }
            }else{
                echo 'Could not connect to the server. Please check your <strong>internet connection</strong>.';
            }
        } else {
            echo 'The data is not valid.';
        }
    }else{
        echo 'Please <a href="../index.php">log in</a>';
    }
}else{
    echo 'Data not sent.';
}
