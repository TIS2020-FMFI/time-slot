<?php
include("../db.php");
session_start();

if (!$mysqli->connect_errno) {
    if (isset($_SESSION['role'])){
        if ($_SESSION['active_time_slot'] == ''){
            $id = mysqli_real_escape_string($mysqli,$_POST['id']);
            $state = mysqli_real_escape_string($mysqli,$_POST['state']);
            if ($_POST['state'] == 'prepared'){
                $sql="UPDATE `time_slot`  SET 
                            ocupide_start_time=TIMESTAMP(NOW()),
                            ocupide_end_time=TIMESTAMP(DATE_ADD(NOW(), INTERVAL 10 MINUTE)),
                            state='occupied'
                        WHERE id='{$id}' and state='{$state}' 
                        and (TIMESTAMP(NOW()) < start_date_time OR '{$_SESSION['role']}' = 'IND' OR '{$_SESSION['role']}' = 'AD' )";
                if ($result = $mysqli->query($sql)) {
                    if (mysqli_affected_rows($mysqli) > 0){
                        $_SESSION['active_time_slot'] = $id;
                        $_SESSION['active_time_slot_state'] = $state;
                        echo '1';
                    }else{
                        try_different_select($id,$state);
                        //echo 'Time-slot is currently <strong>occupied<strong>';
                    }
                }else{
                    echo 'something went wrong with sql <strong>order_AJAX/open_time_slot.php<strong '.$sql;
                }
            }else{
                $id = mysqli_real_escape_string($mysqli,$_POST['id']);
                $state = mysqli_real_escape_string($mysqli,$_POST['state']);
                $sql="UPDATE `time_slot`  SET ocupide_start_time=TIMESTAMP(NOW()),ocupide_end_time=TIMESTAMP(DATE_ADD(NOW(), INTERVAL 10 MINUTE)) 
                    WHERE id='{$id}' and 
                    state='{$state}' 
                    and (TIMESTAMP(NOW()) BETWEEN TIMESTAMP(ocupide_start_time) AND TIMESTAMP(ocupide_end_time)) = '0'
                     and (TIMESTAMP(NOW()) < start_date_time OR '{$_SESSION['role']}' = 'IND' OR '{$_SESSION['role']}' = 'AD' )"; // set jeden dn na to ci je datym betweeen occupide start time a occupide eend time
                if ($result = $mysqli->query($sql)) {
                    if (mysqli_affected_rows($mysqli) > 0){
                        $_SESSION['active_time_slot'] = $id;
                        $_SESSION['active_time_slot_state'] = $state;
                        echo '1';
                    }else{
                        try_different_select($id,$state);
                        //echo 'Time-slot is currently <strong>occupied<strong>';
                    }
                }else{
                    echo 'something went wrong with sql <strong>order_AJAX/open_time_slot.php</strong> '.$sql;
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

function try_different_select($id , $state){
    include("../db.php");
    $sql="select *,
            TIMESTAMPDIFF(SECOND , NOW(), ocupide_end_time) as difference,
            (TIMESTAMP(NOW()) < start_date_time) as is_occupied from `time_slot` WHERE id='{$id}' ";
    if ($resultt = $mysqli->query($sql)) {
        if (mysqli_affected_rows($mysqli) > 0) {
            $vysl = $resultt->fetch_assoc();
            if ($vysl['difference'] > 0){
                echo 'Time-slot is currently <strong>occupied</strong> please wait <strong>'.floor($vysl['difference']/60).':'.($vysl['difference']%60).'</strong>';
            }else if($state != $vysl['state']){
                echo 'This time-slot had changed state <strong>'.$vysl['state'].'</strong>';
            }else if ($vysl['is_occupied']){
                echo 'This time-slot is now not <strong>available</strong>';
            }else{
                echo 'Time-slot is currently <strong>occupied</strong>';
            }
        }else{
            echo 'Time-slot is currently <strong>occupied</strong>';
        }
    }
}