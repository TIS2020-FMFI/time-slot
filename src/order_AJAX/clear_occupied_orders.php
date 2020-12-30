<?php
include('../db.php');
if (!$mysqli->connect_errno) {
    $sql="UPDATE `time_slot`  SET 
                ocupide_start_time=DEFAULT ,
                ocupide_end_time=DEFAULT,
                state=DEFAULT 
            WHERE state='occupied' and
                 (TIMESTAMP(NOW()) BETWEEN TIMESTAMP(ocupide_start_time) AND TIMESTAMP(ocupide_end_time)) = '0' ";
    if ($result = $mysqli->query($sql)) {
        echo 'PRECISTENE';
    }else{
        echo 'CHYBA  '.$sql;
    }
}else{
    echo 'Serverova chyba databaza nieje pripojena';
}