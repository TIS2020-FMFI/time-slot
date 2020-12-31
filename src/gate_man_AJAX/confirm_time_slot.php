<?php
include('../db.php');
session_start();

if (isset($_SESSION['role'])){
    if ($_SESSION['role'] == 'GM' || $_SESSION['role'] == 'IND' || $_SESSION['role'] == 'AD') {
        $id = mysqli_real_escape_string($mysqli,$_POST['id']);
        if (!$mysqli->connect_errno) {
            $sql = "UPDATE time_slot SET state='finished' WHERE id='{$id}' ";
            if ($result = $mysqli->query($sql)) {
                if (mysqli_affected_rows($mysqli) > 0){
                    echo '1$Time slot bol uspesne ukonceni';
                }else{
                    echo '2$Chyba pri ukoncovani time slotu ' ;
                }
            }else{
                echo 'Wrong SQL <strong>gate_man_AJAX/confirm_time_slots.php</strong> '.$sql;
            }
        }else{
            echo 'Could not connect to the server. Please check your <strong>internet connection</strong>.';
        }
    } else {
        echo 'The data is invalid.';
    }
}else{
    echo 'Please log <a href="../index.php">in</a>';
}
