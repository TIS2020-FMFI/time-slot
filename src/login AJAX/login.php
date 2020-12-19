<?php
session_start();
include('../db.php');

if (isset($_POST["email"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    if (!$mysqli->connect_errno) {
        $sql="SELECT * FROM employee where email='$email' and  heslo=MD5('$password') "; // definuj dopyt
        if ($result = $mysqli->query($sql)) {
            $row = $result->fetch_assoc();
            if ($row == NULL){
                echo 'Prihlasovacie udaje su nespravne skontrolujte zadani email alebo heslo '; // . $result["meno"] .' '. $result["priezvisko"]
            }else{
                $_SESSION['id'] = $row['id'];
                $_SESSION['meno'] = $row['meno'];
                $_SESSION['priezvisko'] = $row['priezvisko'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['login_count'] = $row['login_count'];
                $_SESSION['active_time_slot'] = [];

                header("Content-Type:application/json");
                echo json_encode($row);




            }

        } else {
            // NEpodarilo sa vykonať dopyt!
            echo 'Nepodarilo sa najst employee'. "\n";
        }
    } else {
        // NEpodarilo sa spojiť s databázovým serverom alebo vybrať databázu!
        echo 'Serverva chyba databaza nieje pripojena';
    }
}	// koniec funkcie

