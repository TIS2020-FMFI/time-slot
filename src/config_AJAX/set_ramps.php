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
                        echo '1$Nove prazdniny boli ulozene';
                    }else{
                        echo '2$Chyba pri ukladani novich prazdninovich dni';
                    }
                }else{
                    echo 'Chyba sql <strong>config_AJAX/set_new_holidays.php</strong> '.$sql;
                }
            }else{
                echo 'Nepodarilo sa spojit so serverom ';
            }
        } else {
            echo 'Not valid user';
        }
    }else{
        echo 'Please log <a href="../index.php">in</a>';
    }
}else{
    echo 'Neboli poslane data  ';
}
