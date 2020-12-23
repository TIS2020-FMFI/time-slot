<?php
session_start();
include('../db.php');
if (isset($_SESSION['id']) && isset($_POST['new_password']) && isset($_POST['old_password'])){
    $old_password = mysqli_real_escape_string($mysqli,$_POST['old_password']);
    $new_password = mysqli_real_escape_string($mysqli,$_POST['new_password']);
    if (!$mysqli->connect_errno) {
        $sql="UPDATE employee SET heslo=MD5('{$new_password}'),login_count=(login_count +1) WHERE id='{$_SESSION['id']}' and heslo=MD5('{$old_password}') "; // definuj dopyt
        if ($result = $mysqli->query($sql)) {
            if (mysqli_affected_rows($mysqli) > 0){
                echo '1$heslo bolo zmenene na : '.$_POST["new_password"];
            }else{
                echo '2$Chyba pri zadavani jedneho s hesiel';
            }
        }else{
            echo 'Chyba sql <strong>change_password_AJAX/change_password.php</strong> '.$sql;
        }
    } else {
        echo 'Serverva chyba databaza nieje pripojena';
    }
}else{
    echo 'Neboly poslane data alebo niesi prihlaseni <a href="../index.php">log in</a>';
}