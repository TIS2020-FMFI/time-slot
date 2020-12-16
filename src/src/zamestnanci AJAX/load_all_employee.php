<?php
include('../db.php');

if (!$mysqli->connect_errno) {
    $sql = "SELECT * FROM employee";
    if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
        $vysl =  $result->fetch_all();
        header("Content-Type:application/json");
        echo json_encode($vysl);
    } else {
        // NEpodarilo sa vykonať dopyt!
        echo '<p class="chyba">Nastala chyba pri získavaní údajov z DB.</p>' . "\n";
    }
}