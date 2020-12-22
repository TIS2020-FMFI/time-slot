<?php
include("../db.php");
session_start();
$sql="UPDATE `time_slot`  SET state='requested' WHERE id='{$_POST['data']}' "; // definuj dopyt
if ($result = $mysqli->query($sql)) {
    echo '1';
}else{
    echo '2';
}
