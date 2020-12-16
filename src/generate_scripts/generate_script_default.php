<?php
include('../db.php');
date_default_timezone_set("Europe/Bratislava");
include('clear_time_slot.php');


// toto sluzi ako nahrada subselectu ktori asi bute trvat dlhsie aspon podla mna !!! a je to zataz pre db !!
$state = 'prepared';

$const_for_validity = 2.5; // teba pridat popis podobni nizsiemu
// ABSOLUT DEFAULT
// kazdy vnutorni array in $array_of_times predstavuje den monday [7:00 , 22:00] vo formate intigerov [7 , 22]
$array_of_times = [[7 , 19.5 , 0], // pondelok povodne hodnoti boli vasde 22 koli for ciku su zmeneni o 2.5 aby sa zmestili do konca pracovnej doby
    [6 , 19.5, 0], // utorok
    [6 , 19.5, 0], // streda
    [7 , 19.5, 0], // stvrtok
    [7 , 19.5, 0], //piatok
    [0,-1, 0], // sobota [0,-1] lebo sa nerobi v dane dni
    [0,-1, 0]]; //nedela [0,-1] lebo sa nerobi v dane dni
if (!$mysqli->connect_errno) {
    $sql = "SELECT *  FROM config_start_end_working ";
    if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
        $index = 0;
        while ($row = $result->fetch_assoc()) {
            echo floatval($row['starting_hour']) .'    '.(floatval($row['ending_hour'])-$const_for_validity).'    '.intval($row['exception_status']).'<br>';
            $array_of_times[$index] = [floatval($row['starting_hour']) ,floatval($row['ending_hour'])-$const_for_validity,intval($row['exception_status'])];
            $index ++;
        }
    }
}

$next_start_point_of_generation = strtotime('next Monday', strtotime('now')); //  treba specifikovat format generovania napr. UTC 00:00
$year = date("Y", $next_start_point_of_generation);


// !!!! neviem ake bude spravanie na prelome roka
$holidays = []; // array of holidays format YYYY:MM:DD picom zapis musi splnat poziadavki ak je napr.mesiac 1 tak zapis vyzera '01' to iste pre dni format array = ['2020-12-14','2020-12-15']
if (!$mysqli->connect_errno) {
    $sql = "SELECT holidays  FROM holidays where id=1 ";
    if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
        $row = $result->fetch_assoc();
        //echo $row['holidays'].'';
        $parsed = explode(',',$row['holidays']);
        for ($index = 0;$index < count($parsed);$index ++){
            if ($parsed[$index] != ''){
                array_push ( $holidays ,  $year.'-'.$parsed[$index]) ;
            }
        }
    }
}
// KONTROLNI VYPIS PRE SPRAVNOST !!!

// for ($index = 0;$index < count($holidays);$index ++){
//    echo $holidays[$index] .' <br> ';
//}


//Monday Tuesday Wednesday ...
$next_start_point_of_generation = strtotime('next Monday', strtotime('now')); //  treba specifikovat format generovania napr. UTC 00:00
$date = date("Y-m-d H:i:s", $next_start_point_of_generation);

for ($gate_number = 1 ;$gate_number < 2;$gate_number++) { //11 pre testovaciu DB
    //echo 'GATE NUMBER'.$gate_number.'<br>';
    for ($gate_times = 0; $gate_times < count($array_of_times); $gate_times++) {
        //echo 'DAY IN WEEK :'.($gate_times+1).'<br>';
        $tomorrow_of_today = date('Y-m-d', strtotime($date . " +".$gate_times." days"));
        //$res = in_array($tomorrow_of_today,$holidays);
        //echo "is in ??? : ".json_encode($res).'<br>';
        echo $tomorrow_of_today.'<br>';
        if (in_array($tomorrow_of_today,$holidays) && $array_of_times[$gate_times][2] == 0){ // pokial je  owervrite povoleni tak sa da dogenerovat den ktori je normalne obsadeni prazdninami
            continue;
        }
        for ($times = $array_of_times[$gate_times][0]; $times <= $array_of_times[$gate_times][1] ; $times += 2.5) {
            if (fmod($times,1) == 0.5){
                $time_start = ($gate_times*24)+floor($times).':30:00';
                $time_end =  ($gate_times*24)+round($times+ 2.5).':00:00';
            }
            else{
                $time_start = ($gate_times*24)+round($times).':00:00';
                $time_end =  ($gate_times*24)+floor($times+ 2.5).':30:00';
            }
            //echo 'START TIME : '.$time_start.'<br>';
            //echo 'END TIME : '.$time_end.'<br>';
            //echo '<br>';
            $sql = "INSERT INTO time_slot (`id_gate`,`start_date_time`, `end_date_time`, `state`)
                        values('{$gate_number}',
                        (select TIMESTAMP(ADDTIME('{$date}', '{$time_start}'))),
                        (select TIMESTAMP(ADDTIME('{$date}', '{$time_end}'))),
                        '{$state}')";
            if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
                echo "OK <br>";
            } else{
                echo $sql."     CHYBA SKRIPTU <br>";
            }
        }
    }
}

