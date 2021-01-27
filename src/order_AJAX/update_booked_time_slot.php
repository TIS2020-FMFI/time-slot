<?php
session_start();
include('../db.php');
if (!$mysqli->connect_errno) {
    if (isset($_SESSION['active_time_slot'])){
        if ($_SESSION['active_time_slot'] != "" && ($_SESSION['role'] == "AD" || $_SESSION['role'] == "IND") &&
            ($_SESSION['active_time_slot_state'] != 'prepared' ||  $_SESSION['active_time_slot_state'] != 'occupied')){
            $norm_company_name = mysqli_real_escape_string($mysqli,$_POST['company_name']);
            $norm_company_employee_email = mysqli_real_escape_string($mysqli,$_POST['company_email']);
            $sql_select_employee = "SELECT id FROM `employee` WHERE meno_splocnosti='{$norm_company_name}' and email='{$norm_company_employee_email}'";

            if ($result = $mysqli->query($sql_select_employee)) {
                $vysl = $result->fetch_assoc();
                $id_of_external_dispatcher = $vysl['id'];
            }else{
                echo 'something went wrong with sql internal_dispatcher part 1 <strong>order_AJAX/request_time_slot.php<strong '.$sql_select_employee;
                return;
            }
            if ($id_of_external_dispatcher == null){
                echo '*employee with this email address : <strong>'.$norm_company_employee_email.' </strong><br>does not working in this company : <strong>'.$norm_company_name.'</strong> ';
                return;
            }


            $norm_evc = mysqli_real_escape_string($mysqli,$_POST['evc']);
            $norm_kam1 = mysqli_real_escape_string($mysqli,$_POST['kam1']);
            $norm_kam2 = mysqli_real_escape_string($mysqli,$_POST['kam2']);
            $norm_destination = mysqli_real_escape_string($mysqli,$_POST['destination']);
            $norm_cargo = mysqli_real_escape_string($mysqli,$_POST['cargo']);
            $sql="UPDATE `time_slot`  SET 
                        id_external_dispatcher='{$id_of_external_dispatcher}',
                        evc_truck='{$norm_evc}',
                        truck_driver_1='{$norm_kam1}',
                        truck_driver_2='{$norm_kam2}',
                        destination='{$norm_destination}',
                        ocupide_start_time=DEFAULT ,
                        ocupide_end_time=DEFAULT,
                        cargo='{$norm_cargo}'
                         WHERE id='{$_SESSION['active_time_slot']}' and id_gate='{$_POST['ramp']}'  
                         and (TIMESTAMP(NOW()) BETWEEN TIMESTAMP(ocupide_start_time) AND TIMESTAMP(ocupide_end_time)) = '1'"; // definuj dopyt
            if ($result4 = $mysqli->query($sql)) {
                $_SESSION['active_time_slot'] = '';
                $_SESSION['active_time_slot_state'] = '';
                echo '1';
            }else{
                echo 'something went wrong with sql internal_dispatcher part 2 <strong>order_AJAX/request_time_slot.php<strong '.$sql;
            }
        }else{
            if ($_SESSION['role'] == 'EXD'){
                echo 'You currently does not have opened any orders please pick <a href="#" onclick="window.open(\'external_dispatcher.php\',\'_self\')"> one</a>';
            }else if ($_SESSION['role'] == 'AD'||$_SESSION['role'] == 'IND'){
                echo 'You currently does not have opened any orders please pick <a href="#" onclick="window.open(\'internal_dispatcher.php\',\'_self\')"> one</a>';
            }
        }

    }else{
        echo 'Please log <a href="../index.php">in</a>';
    }
}else {
    echo 'Serverova chyba databaza nieje pripojena';
}
