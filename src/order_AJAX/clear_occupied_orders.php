<?php
include('../db.php');
$sql="UPDATE `time_slot`  SET ocupide_start_time=DEFAULT ,ocupide_end_time=DEFAULT,state='prepared' WHERE state='occupied' and (TIMESTAMP(NOW()) BETWEEN TIMESTAMP(ocupide_start_time) AND TIMESTAMP(ocupide_end_time)) = '0' "; // definuj dopyt
if ($result = $mysqli->query($sql)) {
    echo 'PRECISTENE';
}else{
    echo 'CHYBA';
}