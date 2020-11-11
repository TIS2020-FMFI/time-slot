<?php
include('../db.php');

if (isset($_POST["F_name"])) {
    $id = $_POST["id"];
    $first_name = $_POST["F_name"];
    $last_name = $_POST["L_name"];
    $email = $_POST["email"];
    $is_working = $_POST["is_working"];
    if (!$mysqli->connect_errno) {
        if($is_working == 'false'){
            $sql="UPDATE employee SET is_working='0' WHERE id='$id' "; // definuj dopyt
        }
        else{
            $sql="UPDATE employee SET is_working='1' WHERE id='$id' "; // definuj dopyt
        }
        if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
            if($is_working == 'false'){
                echo 'employee : ' . "$first_name " .' '."$last_name".' '.' is now Not working' . "\n";
            }else{
                echo 'employee : ' . "$first_name " .' '."$last_name".' '.' is now working' . "\n";
            }
        } else {
            // NEpodarilo sa vykonať dopyt!
            echo 'Nepodarilo sa zmenit rolu employee'. "\n";
        }
    } else {
        // NEpodarilo sa spojiť s databázovým serverom alebo vybrať databázu!
        echo 'Serverva chyba databaza nieje pripojena';
    }
}	// koniec funkcie


?>