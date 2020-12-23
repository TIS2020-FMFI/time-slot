<?php
session_start();
include('../db.php');

if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = mysqli_real_escape_string($mysqli,$_POST["email"]);
    $password = mysqli_real_escape_string($mysqli,$_POST["password"]);
    if (!$mysqli->connect_errno) {
        $sql="SELECT * FROM employee where email='$email' and  heslo=MD5('$password') "; // definuj dopyt   //
        if ($result = $mysqli->query($sql)) {
            $row = $result->fetch_assoc();
            if ($row == NULL){
                echo "1$"."Prihlasovacie udaje su nespravne skontrolujte zadani <strong>email</strong> alebo <strong>password</strong>" ;
            }else{
                $_SESSION['id'] = $row['id'];
                $_SESSION['meno'] = $row['meno'];
                $_SESSION['priezvisko'] = $row['priezvisko'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['meno_splocnosti'] = $row['meno_splocnosti'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['login_count'] = $row['login_count'];
                $_SESSION['active_time_slot'] = '';
                $_SESSION['active_time_slot_state'] = '';
                header("Content-Type:application/json");
                echo json_encode($row);
            }

        } else {
            echo 'Chybne sql <strong>login_AJAX/change_password.php</strong> '.$sql;
        }
    } else {
        echo 'Serverva chyba databaza nieje pripojena';
    }
}else{
    echo 'Neboly poslane data';
}

