<?php
include("../db.php");
session_start();
//if ($_SESSION['role']=='EXD'){}
if ($_SESSION['active_time_slot'] == ''){
    //echo $_POST['state'].'     ';
    if ($_POST['state'] == 'prepared'){
        $sql="UPDATE `time_slot`  SET ocupide_start_time=TIMESTAMP(NOW()),ocupide_end_time=TIMESTAMP(DATE_ADD(NOW(), INTERVAL 10 MINUTE)),state='occupied' WHERE id='{$_POST['id']}' and state='{$_POST['state']}' "; // definuj dopyt
        if ($result = $mysqli->query($sql)) {
            $_SESSION['active_time_slot'] = $_POST['id'];
            $_SESSION['active_time_slot_state'] = $_POST['state'];
            //$_SESSION['active_time_slot_type'] = $_POST['slot_type'];
            echo '1';
        }else{
            echo '2';
        }
    }else{
        $sql="UPDATE `time_slot`  SET ocupide_start_time=TIMESTAMP(NOW()),ocupide_end_time=TIMESTAMP(DATE_ADD(NOW(), INTERVAL 10 MINUTE)) 
            WHERE id='{$_POST['id']}' and 
            state='{$_POST['state']}' 
            and (TIMESTAMP(NOW()) BETWEEN TIMESTAMP(ocupide_start_time) AND TIMESTAMP(ocupide_end_time)) = '0'"; // set jeden dn na to ci je datym betweeen occupide start time a occupide eend time
        if ($result = $mysqli->query($sql)) {
            //$fff = $result->();
            ///echo 'RESOULT :   '.$result;
            // result neviem ako dostanem naspet ci bol riadok updatnuti alebo nie
            $_SESSION['active_time_slot'] = $_POST['id'];
            $_SESSION['active_time_slot_state'] = $_POST['state'];
            echo '1';
        }else{
            echo '2';
        }
    }

}else{
    // tato jednotka bude nahradena dakim vipisom na strane hlavnej stranki tak aby bolo mozne odstranit acctive time slot
    echo '3';
}

//if ($_SESSION['role']=='IND'||$_SESSION['role']=='AD'){}

/*
$sql="UPDATE `time_slot`  SET state='requested' WHERE id='{$_POST['data']}' "; // definuj dopyt
if ($result = $mysqli->query($sql)) {
    echo '1';
}else{
    echo '2';
}
*/
