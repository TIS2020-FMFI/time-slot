<?php
session_start();
include('../db.php');
if (isset($_SESSION['id']) && ($_SESSION['role'] == 'AD' ||  $_SESSION['role'] == 'IND')){
    if (!$mysqli->connect_errno) {
            $sql = "SELECT holidays  FROM holidays where id=2 ";
        if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
            $vysl =  $result->fetch_all();
            header("Content-Type:application/json");
            echo json_encode($vysl);//json_encode($vysl);
        }
    }
}