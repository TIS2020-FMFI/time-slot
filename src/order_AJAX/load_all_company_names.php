<?php
include("../db.php");
session_start();
if (!$mysqli->connect_errno) {
    if (isset($_SESSION['role']) ){
        if ( ($_SESSION['role'] == "AD" || $_SESSION['role'] == "IND") && $_SESSION['active_time_slot'] != ''){

            $sql="SELECT DISTINCT meno_splocnosti FROM `employee` WHERE is_working='1' and role='EXD' ";
            if ($result = $mysqli->query($sql)) {
                $vysl =  $result->fetch_all();
                header("Content-Type:application/json");
                echo json_encode($vysl);
            }else {
                echo "* nepodarilo sa nacitat mena_spolocnosti";
            }
        }else{
            echo 'Not valid user for obtaining data';
        }
    }else{
        echo '* Please log <a href="../index.php">in</a>';
    }
}else {
    echo 'Serverova chyba databaza nieje pripojena';
}