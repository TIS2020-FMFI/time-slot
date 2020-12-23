<?php
session_start();
include('../db.php');
if (isset($_SESSION['id']) && ($_SESSION['role'] == 'AD' ||  $_SESSION['role'] == 'IND')){
    $sql = "UPDATE holidays SET holidays='{$_POST['ramps']}' WHERE id=2";
    if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
        echo 1;
    }else{
        echo 0;
    }

}