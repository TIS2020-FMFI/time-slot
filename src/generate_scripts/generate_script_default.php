<?php
include('../db.php');
session_start();

date_default_timezone_set("Europe/Bratislava");
$next_start_point_of_generation = strtotime('next Monday', strtotime('now')); //  treba specifikovat format generovania napr. UTC 00:00
$next_start_point_of_generation_end = strtotime('+7 days',strtotime("next Monday", strtotime('now')));
$date_format_start = date("Y-m-d", $next_start_point_of_generation);
$date_format_end = date("Y-m-d", $next_start_point_of_generation_end);

if (isset($_POST['regenerate']) && isset($_SESSION['role']) ) {
    if ($_SESSION['role'] == 'IND' || $_SESSION['role'] == 'AD') {
        if ($_POST['regenerate'] == '1') {
            echo "REGENERATING DATA <br> from :<strong> " .
                $date_format_start . '</strong><br>' .
                "to :<strong> " . $date_format_end . '</strong><br>';
            include('../config_AJAX/regenerate_time_slot_for_next_week.php');
            if (regenerate_data($next_start_point_of_generation) == false) {
                return;
            }
        } else {
            echo "*Not valid post methoud";
            return;
        }
    }else{
        echo '*Not valid user';
        return;
    }
}else{
    echo 'data neboli poslane alebo niesi prihlaseni';
    include('clear_time_slot.php');
    // sem sa dostaneme ak sa spusta automaticky a nebola
    // pouzita ziadna post metoda a neni prihlaseni ani ziaden user
}



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
            //echo floatval($row['starting_hour']) .'    '.(floatval($row['ending_hour'])-$const_for_validity).'    '.intval($row['exception_status']).'<br>';
            $array_of_times[$index] = [floatval($row['starting_hour']) ,floatval($row['ending_hour'])-$const_for_validity,intval($row['exception_status'])];
            $index ++;
        }
    }else {
        echo '*Chybne sql na stranke <strong>generate_scripts/generate_script_default.php</strong> '.$sql;
    }
}else {
    echo '*Serverova chyba databaza nieje pripojena';
}

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
    }else {
        echo '*Chybne sql na stranke <strong>generate_scripts/generate_script_default.php</strong> '.$sql;
    }
}else {
    echo '*Serverova chyba databaza nieje pripojena';
}
// KONTROLNI VYPIS PRE SPRAVNOST !!!

// for ($index = 0;$index < count($holidays);$index ++){
//    echo $holidays[$index] .' <br> ';
//}

$disabled_ramps = []; // toto je array ktora dostava na vstup fromat textu Ramp1-111111 Ramp2-1111111 pricom 111111 oznacuju ci v dane dni su rampi odstavene alebo niesu
if (!$mysqli->connect_errno) {
    $sql = "SELECT holidays  FROM holidays where id=2 ";
    if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
        $row = $result->fetch_assoc();
        //echo $row['holidays'].'';
        $parsed = explode(' ', $row['holidays']);
        for ($index = 0; $index < count($parsed); $index++) {
            $parsed2 = explode('-', $parsed[$index]);
            array_push($disabled_ramps, $parsed2[1]);
        }
    }else {
        echo '*Chybne sql na stranke <strong>generate_scripts/generate_script_default.php</strong> '.$sql;
    }
}else {
    echo '*Serverova chyba databaza nieje pripojena';
}
// Kontrolen vypisi pre  deibled ramp
//for ($index = 0;$index < count($disabled_ramps);$index ++){
//    echo $disabled_ramps[$index] .' <br> ';
//}


$date = date("Y-m-d H:i:s", $next_start_point_of_generation);
for ($gate_number = 1 ;$gate_number < 38;$gate_number++) { //11 pre testovaciu DB v realite to znamena 10 ramp
    for ($gate_times = 0; $gate_times < count($array_of_times); $gate_times++) { // array of time == dni v tyzdni s danimi hodinami :D
        $tomorrow_of_today = date('Y-m-d', strtotime($date . " +".$gate_times." days"));

        if (in_array($tomorrow_of_today,$holidays) && $array_of_times[$gate_times][2] == 0){ // pokial je  owervrite povoleni tak sa da dogenerovat den ktori je normalne obsadeni prazdninami
            continue;
        }
        if ($disabled_ramps[$gate_number-1][$gate_times] == '1'){
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
            if (!$mysqli->connect_errno) {
                $sql = "INSERT INTO time_slot (`id_gate`,`start_date_time`, `end_date_time`, `state`)
                        values('{$gate_number}',
                        (select TIMESTAMP(ADDTIME('{$date}', '{$time_start}'))),
                        (select TIMESTAMP(ADDTIME('{$date}', '{$time_end}'))),
                        '{$state}')";
                if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
                    echo "";//OK <br>
                } else {
                    echo "*CHYBA SKRIPTU " . $sql . "<br>";
                }
            }else {
                echo '*Serverova chyba databaza nieje pripojena';
            }
        }
    }
}


