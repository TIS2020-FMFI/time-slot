<?php
include("../db.php");
session_start();
if ($_SESSION['active_time_slot'] != "" && ( $_SESSION['role'] == "AD" || $_SESSION['role'] == "IND")){
    $sql="SELECT meno_splocnosti FROM `employee` WHERE is_working='1' and role='EXD' "; // definuj dopyt
    if ($result = $mysqli->query($sql)) {
        $vysl =  $result->fetch_all();
        header("Content-Type:application/json");
        echo json_encode($vysl);
    }else{
        echo '2';
    }
}else{
    if ($_SESSION['role'] == 'IND' || $_SESSION['role'] == 'AD'){
        echo '3';
    }else{
        echo '4';
    }

}