<?php
session_start();
include('../db.php');

if (isset($_POST['holidays'])){
    if (isset($_SESSION['role'])){
        if ( $_SESSION['role'] == 'AD' ||  $_SESSION['role'] == 'IND'){
            if (!$mysqli->connect_errno) {
                $norm_holidays =  mysqli_real_escape_string($mysqli,$_POST['holidays']);
                $sql = "UPDATE holidays SET holidays='{$norm_holidays}' WHERE id=1";
                if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
                    if (mysqli_affected_rows($mysqli) >= 0){
                        echo '1$New holidays set.';
                    }else{
                        echo '2$Error occured with saving new holidays.';
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
