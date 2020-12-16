<?php
session_start();
include('../db.php');
if (isset($_SESSION['id'])){
    if (!$mysqli->connect_errno) {
        $sql="UPDATE employee as e SET heslo=MD5('{$_POST['new_password']}'),login_count=(e.login_count +1) WHERE id='{$_SESSION['id']}' and heslo=MD5('{$_POST['old_password']}') "; // definuj dopyt
        if ($result = $mysqli->query($sql)) {
                echo 'heslo bolo zmenene na : '.$_POST["new_password"];
        }else{
            echo $result;
            echo '* Dopit sa nepodarilo vykonat zle zadane udaje hesla '.$_POST["new_password"];
        }
    } else {
        echo '* Serverva chyba databaza nieje pripojena';
    }
}else{
    echo '* Nepovoleni request, niesi prihlaseni !!!';
}