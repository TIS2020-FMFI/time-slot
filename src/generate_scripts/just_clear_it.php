<?php
include('../db.php');
/// SUBOR MUSI BYT ODSTRANENI PO TESTOVANI
$sql = "TRUNCATE TABLE time_slot ";
if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
    echo "VYCISTENA && Auto increment nastaveni na 1 (time slot)<br>";
} else{
    echo "CHYBA SKRIPTU <br> ";
}
$sql = "TRUNCATE TABLE dump_table ";
if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
    echo "VYCISTENA (dump_table)<br>";
} else{
    echo "CHYBA SKRIPTU <br> ";
}
