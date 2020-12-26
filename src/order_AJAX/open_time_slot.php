<?php
include("../db.php");
session_start();
if (!$mysqli->connect_errno) {
    if (isset($_SESSION['role'])){
        if ($_SESSION['active_time_slot'] == ''){
            if ($_POST['state'] == 'prepared'){
                $sql="UPDATE `time_slot`  SET 
                            ocupide_start_time=TIMESTAMP(NOW()),
                            ocupide_end_time=TIMESTAMP(DATE_ADD(NOW(), INTERVAL 10 MINUTE)),
                            state='occupied'
                        WHERE id='{$_POST['id']}' and state='{$_POST['state']}' ";
                if ($result = $mysqli->query($sql)) {
                    $_SESSION['active_time_slot'] = $_POST['id'];
                    $_SESSION['active_time_slot_state'] = $_POST['state'];
                    echo '1';
                }else{
                    echo 'something went wrong with sql<strong>order_AJAX/open_time_slot.php<strong '.$sql;
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
                    echo 'something went wrong with sql<strong>order_AJAX/open_time_slot.php<strong '.$sql;
                }
            }

        }else{
            echo 'You forgot to close your order ! Do you wont to <a href="#" onclick="close_time_slot()"><strong>close it</strong></a> / <a href="order.php"><strong>open it</strong></a>';
        }
    }else{
        echo 'Please log <a href="../index.php">in</a>';
    }
}else {
    echo 'Serverova chyba databaza nieje pripojena';
}
