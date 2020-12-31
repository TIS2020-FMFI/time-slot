<?php
include('../db.php');
session_start();

if (isset($_SESSION['role'])){
    if ($_SESSION['role'] == 'AD' ){
        if (!$mysqli->connect_errno) {
            $sql = "SELECT `id`, `meno`, `priezvisko`, `meno_splocnosti`, `email`, `role`, `is_working` FROM employee";
            if ($result = $mysqli->query($sql)) {
                $vysl =  $result->fetch_all();
                header("Content-Type:application/json");
                echo json_encode($vysl);
            } else{
                echo 'Wrong SQL <strong>employee_AJAX/load_all_employee.php</strong> '.$sql;
            }
        }else{
            echo 'Could not access the server.';
        }
    }else{
        echo 'Not valid user';
    }
}else{
    echo 'Please log <a href="../index.php">in</a>';
}