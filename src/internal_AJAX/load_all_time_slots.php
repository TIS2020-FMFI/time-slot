<?php
include('../db.php');
session_start();

if (isset($_SESSION['role'])){
    if ( $_SESSION['role'] == 'IND' || $_SESSION['role'] == 'AD'){
        if (!$mysqli->connect_errno) {
            $sql = "SELECT id, id_gate, DATE( start_date_time ) as reale_day , start_date_time, end_date_time, state,evc_truck,
                        (select meno_splocnosti from employee where id=id_external_dispatcher),
                        destination ,
                        cargo
                        FROM time_slot 
                         where start_date_time > CURDATE() - INTERVAL 7 DAY and start_date_time < CURDATE() +  INTERVAL 14 DAY 
                         ORDER BY id_gate ASC , start_date_time ASC ";
            if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
                $vysl =  $result->fetch_all();
                header("Content-Type:application/json");
                echo json_encode($vysl);
            }else{
                echo 'Wrong SQL <strong>internal_AJAX/load_all_time_slots.php</strong> '.$sql;
            }
        }else{
            echo 'Could not connect to the server. Please check your internet connection.';
        }
    } else {
        echo 'User is not valid.';
    }
}else{
    echo 'Please log <a href="../index.php">in</a>';
}
