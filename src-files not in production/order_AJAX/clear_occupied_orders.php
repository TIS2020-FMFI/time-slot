<?php
$host = 'localhost';
$username = 'timeslot';
$password = 'ieotmsltieo';
$dbname = 'timeslot';


$mysqli = new mysqli($host,$username,$password,$dbname);
if ($mysqli->connect_errno) {
    echo '<strong>NEpodarilo sa pripojiť s databazou</strong>';
} else {
    $mysqli->query("SET CHARACTER SET 'utf8'");
}


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
    echo 'Could not access the server.';
}