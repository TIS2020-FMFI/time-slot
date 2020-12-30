<?php
function regenerate_data($next_start_point_of_generation){
    $date = date("Y-m-d", $next_start_point_of_generation);
    include('../db.php');
    if (!$mysqli->connect_errno) {
        $sql = "select  id_gate,start_date_time,(select CONCAT(email,' ',meno_splocnosti)  from employee where id = id_external_dispatcher)as contact_info,  state from time_slot where start_date_time >= TIMESTAMP( '{$date}' ) and state != 'prepared'"; // delete from `time_slot` where start_date_time  >=  TIMESTAMP($date)
        if ($result = $mysqli->query($sql)) {
            echo "Time sloty ktore su zaplnene alebo sa o ne ziada:<br>";
            while ($row = $result->fetch_assoc()) {
                echo "Rampa : <strong>".$row['id_gate'].
                    "</strong><br>start_date_time : <strong>".date("Y-m-d H:i:s",strtotime($row['start_date_time'])).
                    "</strong><br>Contact info : <strong>".$row['contact_info'].
                    "</strong><br> State of time slot : <strong>".$row['state']."</strong><br><br>";
            }
        } else{
            echo '*Wrong SQL <strong>config_AJAX/regenerate_time_slot_for_next_week.php</strong> '.$sql;
            return false;
        }
        $sql = "delete from time_slot where start_date_time >= TIMESTAMP( '{$date}' ) "; // delete from `time_slot` where start_date_time  >=  TIMESTAMP($date)
        if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
            echo "<strong>Databaza bola uspesne premazana</strong><br> ";
        } else{
            echo '*Wrong SQL <strong>config_AJAX/regenerate_time_slot_for_next_week.php</strong> '.$sql;
            return false;
        }

    }else{
        echo '*Nepodarilo sa spojit so serverom ';
        return false;
    }
    return true;
}