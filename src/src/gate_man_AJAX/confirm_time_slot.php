<?php
include('../db.php');

if ($_POST['data']){
    if (!$mysqli->connect_errno) {
        $sql = "UPDATE time_slot SET id_external_dipatcher='{$_SESSION['id']}' WHERE id='{$_POST['data']}' ";
        if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
            return;
        }
    }
}else{
    echo 'CHYBA';
}
