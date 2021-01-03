<?php
// FUNGUJE
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

date_default_timezone_set("Europe/Bratislava");


// DUMP SCRIPT


$dump_str_date = strtotime('1 days ago'); //2 week ago -
//  treba specifikovat ku ktoremu dnu to zalohujeme a NE-musi to byt jednotne s clear_time_slot.php
// a do sql sciptu podmienku Where end_time_slot <=  TIMESTAMP('{$next_start_point_of_generation}')
// oporucanie --> $next_start_point_of_generation = strtotime('1 days ago'); // to znamena ze data uz su ozaj v hotovich stavoch a nemala by nenast chyba
$dump_date = date("Y-m-d", $dump_str_date);
echo 'DATA zalohujeme k datumu  '. $dump_date . ' <br> ';
if (!$mysqli->connect_errno) {
    $sql = "INSERT INTO `dump_table` ( `id`, `gate_number`, `company_name`, `first_ruck_driver`, `second_ruck_driver`, `truck_number`, `destination`, `cargo`, `start_date_time_slot`, `end_date_time_slot`, `state` )
    (SELECT * FROM (SELECT id,
        id_gate,
        (SELECT meno_splocnosti
         FROM employee
         WHERE id = id_external_dispatcher ), 
        truck_driver_1,
        truck_driver_2 , 
        evc_truck, 
        destination,
        cargo, 
        start_date_time, 
        end_date_time,
        state
    FROM time_slot) as `T` WHERE TIMESTAMP ('{$dump_date}') >= end_date_time)
    ON DUPLICATE KEY UPDATE 
        gate_number = VALUES (`gate_number`),
        company_name = VALUES (`company_name`),
        first_ruck_driver = VALUES (`first_ruck_driver`),
        second_ruck_driver = VALUES (`second_ruck_driver`),
        truck_number = VALUES (`truck_number`),
        destination = VALUES (`destination`),
        cargo = VALUES (`cargo`),
        start_date_time_slot = VALUES (`start_date_time_slot`),
        end_date_time_slot = VALUES (`end_date_time_slot`),
        state = VALUES (`state`)";
    if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
        echo "Databaza bola zalohovana na disku  ".mysqli_affected_rows($mysqli). "<br> ";
    } else {
        echo "CHYBA SKRIPTU <br> ";
    }
}else{
    echo "CHYBA PRIPOJENIA K DB <br> ";
}

// DELETE TIME SLOT

$date_str_delete = strtotime('1 weak ago'); //  1 tizdne koli tomu ako sme sa dohodli s p.p
$date_delete = date("Y-m-d", $date_str_delete);
echo 'DATA cistime k datumu  '. $date_delete . ' <br> ';
if (!$mysqli->connect_errno) {
    $sql = "delete from time_slot where TIMESTAMP ('{$date_delete}') > end_date_time  ";
    if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
        echo "VYCISTENA DB(TIME SLOTS)<br>";
    } else{
        echo "CHYBA SKRIPTU <br> ";
    }
}else {
    echo 'Serverova chyba databaza nieje pripojena';
}









// VYTVORENIE CASOV GENEROVANIA

$const_for_validity = 2.5; // konstanta na vytvaranie time_slotov dlzky 2:30 minut
// kazdy vnutorni array in $array_of_times predstavuje den monday [7:00 , 22:00] vo formate intigerov [7 , 22] predefinovana tabulka
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
        echo '*Chybne sql na stranke <strong>generate_scripts/generate_script_default_only_default.php</strong> '.$sql;
    }
}else {
    echo '*Serverova chyba databaza nieje pripojena';
}



// VYTVORENIE ZOZNAMU HOLYDAYS

$date_str_for_next_next_week = strtotime('+7 days',strtotime("next Monday", strtotime('now')));
$year_of_date_str_for_next_next_week = date("Y", $date_str_for_next_next_week);

$holidays = []; // array of holidays format YYYY:MM:DD picom zapis musi splnat poziadavki ak je napr.mesiac 1 tak zapis vyzera '01' to iste pre dni format array = ['2020-12-14','2020-12-15']
if (!$mysqli->connect_errno) {
    $sql = "SELECT holidays  FROM holidays where id=1 ";
    if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
        $row = $result->fetch_assoc();
        //echo $row['holidays'].'';
        $parsed = explode(',',$row['holidays']);
        for ($index = 0;$index < count($parsed);$index ++){
            if ($parsed[$index] != ''){
                array_push ( $holidays ,  $year_of_date_str_for_next_next_week.'-'.$parsed[$index]) ;
            }
        }
    }else {
        echo '*Chybne sql na stranke <strong>generate_scripts/generate_script_default_only_default.php</strong> '.$sql;
    }
}else {
    echo '*Serverova chyba databaza nieje pripojena';
}
// KONTROLNI VYPIS PRE SPRAVNOST !!!

// for ($index = 0;$index < count($holidays);$index ++){
//    echo $holidays[$index] .' <br> ';
//}



// VYTVORENIE ZOZNAMU DISABLED RAMPS

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
        echo '*Chybne sql na stranke <strong>generate_scripts/generate_script_default_only_default.php</strong> '.$sql;
    }
}else {
    echo '*Serverova chyba databaza nieje pripojena';
}
// KONTROLNI VYPIS PRE SPRAVNOST !!!

//for ($index = 0;$index < count($disabled_ramps);$index ++){
//    echo $disabled_ramps[$index] .' <br> ';
//}


$date_str_for_next_next_week = strtotime('+7 days',strtotime("next Monday", strtotime('now')));
$full_date_of_for_next_next_week = date("Y-m-d H:i:s", $date_str_for_next_next_week);
for ($gate_number = 1 ;$gate_number < 38;$gate_number++) { //11 pre testovaciu DB v realite to znamena 10 ramp
    for ($gate_times = 0; $gate_times < count($array_of_times); $gate_times++) { // array of time == dni v tyzdni s danimi hodinami :D
        $tomorrow_of_today = date('Y-m-d', strtotime($full_date_of_for_next_next_week . " +".$gate_times." days"));

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
                $sql = "INSERT INTO time_slot (`id_gate`,`start_date_time`, `end_date_time`)
                        values('{$gate_number}',
                        (select TIMESTAMP(ADDTIME('{$full_date_of_for_next_next_week}', '{$time_start}'))),
                        (select TIMESTAMP(ADDTIME('{$full_date_of_for_next_next_week}', '{$time_end}'))) )";
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
echo "FINISH GENERATION";
