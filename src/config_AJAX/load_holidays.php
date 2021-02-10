<?php
session_start();
include('../db.php');
if (isset($_SESSION['role'])){
    if ( $_SESSION['role'] == 'AD' ||  $_SESSION['role'] == 'IND'){
        if (!$mysqli->connect_errno) {
                $sql = "SELECT holidays  FROM holidays where id=1 ";
            if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
                $vysl =  $result->fetch_all();
                header("Content-Type:application/json");
                echo json_encode($vysl);
            }else{
                echo 'Wrong SQL server <strong>config_AJAX/load_holidays.php</strong>.';
            }
        }else{
            echo 'Could not connect to the server. Please check your <strong>internet connection</strong>.';
        }
    }else{
        echo 'The data is not valid.';
    }
}else{
    echo 'Please <a href="../index.php">log in</a>';
}