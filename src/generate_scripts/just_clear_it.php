<?php
include('../db.php');
/// !!! tento subor misi byt odsteaneni !!!
$sql = "delete from time_slot where id > 0   ";
if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
    echo "VYCISTENA DB(TIME SLOTS)<br>";
} else{
    echo "CHYBA SKRIPTU <br> ";
}