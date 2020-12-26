<?php
include("../db.php");
session_start();
if (!$mysqli->connect_errno) {
    if (isset($_SESSION['active_time_slot'])){
        if ($_SESSION['active_time_slot'] != "" && $_SESSION['active_time_slot_state'] == 'prepared'){
            $sql="SELECT `id`, `id_gate`, 
            ( SELECT meno_splocnosti FROM employee where id='{$_SESSION['id']}' and role='EXD') as employee,
            truck_driver_1 ,
            truck_driver_2 ,
            `evc_truck`, 
            destination ,
            cargo,
            ( SELECT TIMESTAMP(NOW())) as now_time, 
            `start_date_time`, `end_date_time`, `state`, `ocupide_start_time`, `ocupide_end_time` FROM `time_slot` WHERE id = '{$_SESSION['active_time_slot']}' ";
        }else if ($_SESSION['active_time_slot'] != ""){
            $sql="SELECT `id`, `id_gate`, 
            ( SELECT meno_splocnosti FROM employee where id=id_external_dispatcher) as employee,
            truck_driver_1 ,
            truck_driver_2 ,
            `evc_truck`, 
            destination ,
            cargo,
            ( SELECT TIMESTAMP(NOW())) as now_time, 
            `start_date_time`, `end_date_time`, `state`, `ocupide_start_time`, `ocupide_end_time` FROM `time_slot` WHERE id = '{$_SESSION['active_time_slot']}' ";
        }else {
            if ($_SESSION['role'] == 'EXD') {
                echo '2';
            } else if ($_SESSION['role'] == 'IND' || $_SESSION['role'] == 'AD') {
                echo '1';
            }
            return;
        }
        if ($result = $mysqli->query($sql)) {
            $return = $result->fetch_assoc();
            header("Content-Type:application/json");
            echo json_encode($return);
        }else{
            echo 'Chybne sql <strong>order_AJAX/load_order.php</strong> '.$sql;
        }
    }else{
        echo 'Please log <a href="../index.php">in</a>';
    }
}else {
    echo 'Serverova chyba databaza nieje pripojena';
}