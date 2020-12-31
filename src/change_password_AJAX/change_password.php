<?php
session_start();
include('../db.php');
if (isset($_POST['new_password']) && isset($_POST['old_password']) && isset($_SESSION['role'])){
    if ( $_SESSION['role'] == 'AD' || $_SESSION['role'] == 'GM' || $_SESSION['role'] == 'IND' || $_SESSION['role'] == 'EXD'){
        $old_password = mysqli_real_escape_string($mysqli,$_POST['old_password']);
        $new_password = mysqli_real_escape_string($mysqli,$_POST['new_password']);
        if (!$mysqli->connect_errno) {
            $sql="UPDATE employee SET heslo=MD5('{$new_password}'),login_count=(login_count +1) WHERE id='{$_SESSION['id']}' and heslo=MD5('{$old_password}') ";
            if ($result = $mysqli->query($sql)) {
                if (mysqli_affected_rows($mysqli) > 0){
                    echo '1$Your password has been changed to: '.'<strong>'.$_POST["new_password"].'<strong';
                }else{
                    echo '2$An error occured while selecting new password.';
                }
            }else{
                echo 'Chyba sql <strong>change_password_AJAX/change_password.php</strong> '.$sql;
            }
        } else {
            echo 'Could not connect to the server. Please check your <strong>internet connection</strong>.';
        }
    }else{
        echo 'The data is invalid.';
    }
}else{
    echo 'Data not sent.';
}