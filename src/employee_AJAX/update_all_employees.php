<?php
session_start();
include('../db.php');

$employee_with_not_success = '';
$founded_employee_with_no_success = false;
if (!$mysqli->connect_errno) {
    if (isset($_POST["data"])){
        if (isset($_SESSION['role'])){
            if ($_SESSION['role'] == 'AD' ){
                for ($employee_index = 0 ;$employee_index < count($_POST['data']);$employee_index++){
                    $f_name =  mysqli_real_escape_string($mysqli,$_POST["data"][$employee_index][1]);
                    $l_name =  mysqli_real_escape_string($mysqli,$_POST["data"][$employee_index][2]);
                    $email =  mysqli_real_escape_string($mysqli,$_POST["data"][$employee_index][3]);
                    $company =  mysqli_real_escape_string($mysqli,$_POST["data"][$employee_index][4]);
                    $role =  mysqli_real_escape_string($mysqli,$_POST["data"][$employee_index][5]);
                    $is_working =  mysqli_real_escape_string($mysqli,$_POST["data"][$employee_index][6]);
                    $id =  mysqli_real_escape_string($mysqli,$_POST["data"][$employee_index][0]);

                    $sql="UPDATE employee SET
                            meno= '{$f_name}',
                            priezvisko='{$l_name}',
                            email='{$email}',
                            meno_splocnosti='{$company}',
                            role='{$role}',
                            is_working={$is_working}
                            WHERE id={$id} ";
                    if ($result = $mysqli->query($sql)) {
                        if (mysqli_affected_rows($mysqli) < 0){
                            $founded_employee_with_no_success = true;
                            $employee_with_not_success .=  'Something went wrong with employee :<br>'.
                                'First : '.'<strong>'.$_POST["data"][$employee_index][1] .'</strong><br>' .
                                'Last : '.'<strong>'.$_POST["data"][$employee_index][2] .'</strong><br>' .
                                'email : '.'<strong>'.$_POST["data"][$employee_index][3] .'</strong><br>' .
                                'company : '.'<strong>'.$_POST["data"][$employee_index][4] .'</strong><br>' .
                                'role : '.'<strong>'.$_POST["data"][$employee_index][5] .'</strong><br>' .
                                'working : '.'<strong>'.$_POST["data"][$employee_index][6] .'</strong><br>' ;
                        }
                    } else {
                        echo 'Nepodarilo sa wikonat dopit <strong>'.$sql.'</strong>';
                    }
                }
                if ($founded_employee_with_no_success){
                    echo '2$'.$employee_with_not_success ;
                }else{
                    echo '1$all users has been successfuly updated';
                }
            }else {
                echo 'Not valid user';
            }
        }else{
            echo 'Please log <a href="../index.php">in</a>';
        }
    }else{
        echo 'Neboli poslane data  ';
    }
}else{
    echo 'Nepodarilo sa spojit so serverom ';
}