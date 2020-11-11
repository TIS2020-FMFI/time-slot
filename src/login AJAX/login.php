<?php
//session_start();
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
                header("Content-Type:application/json");
                echo json_encode($row);
                //echo  $row["meno"] .'$'. $row["priezvisko"] .'$'. $row["email"] .'$'. $row["role"] . '$'. $row["login_count"]; //
                /*
                    $_SESSION['id'] = $result['id'];
                    $_SESSION['meno'] = $result['meno'];
                    $_SESSION['priezvisko'] = $result['priezvisko'];
                    $_SESSION['email'] = $result['email'];
                    $_SESSION['rola'] = $result['rola'];

                */
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

