<?php
include('../db.php');

if (isset($_POST["F_name"])) {
    $id = $_POST["id"];
    $first_name = $_POST["F_name"];
    $last_name = $_POST["L_name"];
    $email = $_POST["email"];
    $change_role = $_POST["change_role"];
    if (!$mysqli->connect_errno) {
        $sql="UPDATE employee SET role='$change_role' WHERE id='$id' "; // definuj dopyt
        if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
            echo 'employee : ' . "$first_name " .' '."$last_name".' '.'head been asigned to role :' ."$change_role" . "\n";
        } else {
            // NEpodarilo sa vykonať dopyt!
            echo 'Nepodarilo sa zmenit rolu employee'. "\n";
        }
    } else {
        // NEpodarilo sa spojiť s databázovým serverom alebo vybrať databázu!
        echo 'Serverva chyba databaza nieje pripojena';
    }
}	// koniec funkcie


