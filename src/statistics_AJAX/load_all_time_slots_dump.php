<?php
include('../db.php');
session_start();
ini_set('memory_limit', '256M');

if (isset($_SESSION['role'])){
    if ( $_SESSION['role'] == 'IND' || $_SESSION['role'] == 'AD'){
        if (!$mysqli->connect_errno) {
            $sql = "SELECT * FROM dump_table ORDER BY gate_number ASC ,start_date_time_slot ASC";
            if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
                $vysl =  $result->fetch_all();
                header("Content-Type:application/json");
                echo json_encode($vysl);
            }else{
                echo 'Wrong SQL <strong>internal_AJAX/load_all_time_slots.php</strong> '.$sql;
            }
        }else{
            echo 'Serverova chyba databaza nieje pripojena';
        }
    } else {
        echo 'Nespravni user ';
    }
}else{
    echo 'Please log <a href="../index.php">in</a>';
}
