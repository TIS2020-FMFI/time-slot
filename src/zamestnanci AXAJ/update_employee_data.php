<?php
include('db.php');

if (isset($_POST["id"])) {
    $id = $_POST["id"];
    $data = $_POST["data"];
    $co_menime = $_POST["typ_zmeni"];
    if (!$mysqli->connect_errno) {
        if ($co_menime == "email"){
            $sql="UPDATE employee SET email='$data' WHERE id='$id' ";
        }
        if ($co_menime == "first_name"){
            $sql="UPDATE employee SET meno='$data' WHERE id='$id' ";
        }
        if ($co_menime == "last_name"){
            $sql="UPDATE employee SET priezvsko='$data' WHERE id='$id' ";
        }

        if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
            echo 'employee was updated  ' . $co_menime .  "\n";
        } else {
            // NEpodarilo sa vykonať dopyt!
            echo 'Nepodarilo sa zmenit  employee'. "\n";
        }
    } else {
        // NEpodarilo sa spojiť s databázovým serverom alebo vybrať databázu!
        echo 'Serverva chyba databaza nieje pripojena';
    }
}	// koniec funkcie



?>