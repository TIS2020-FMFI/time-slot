<?php
session_start();
include('../db.php');

$employee_with_not_success = [];
$founded_employee_with_no_success = false;
if (isset($_POST["data"]) && $_SESSION['role'] == 'AD') {
    for ($employee_index = 0 ;$employee_index < count($_POST['data']);$employee_index++){
       // echo $_POST["data"][$employee_index][0] . '  ' .
        //            $_POST["data"][$employee_index][1] . '  ' .
        //            $_POST["data"][$employee_index][2] . '  ' .
        //            $_POST["data"][$employee_index][3] . '  ' .
        //            $_POST["data"][$employee_index][4] . '  ' .
        //            $_POST["data"][$employee_index][5] . ' <br> ' ;
        $sql="UPDATE employee SET
                meno= '{$_POST["data"][$employee_index][1]}',
                priezvisko='{$_POST["data"][$employee_index][2]}',
                email='{$_POST["data"][$employee_index][3]}',
                meno_splocnosti='{$_POST["data"][$employee_index][4]}',
                role='{$_POST["data"][$employee_index][5]}',
                is_working={$_POST["data"][$employee_index][6]}
                WHERE id={$_POST["data"][$employee_index][0]} ";
        if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
        } else {
            echo $sql;
            $founded_employee_with_no_success = true;
            array_push($employee_with_not_success,$_POST["data"][$employee_index]);

        }
    }
    if ($founded_employee_with_no_success){
        echo json_encode($employee_with_not_success);
    }
}else{
    echo '3';
}