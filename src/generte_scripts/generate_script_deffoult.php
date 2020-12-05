<?php
include('../db.php');

$sql = "delete from time_slot where id > 0";
if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
    echo "VYCISTENA DB(TIME SLOTS)<br>";
} else{
    echo "CHYBA SKRIPTU ";
}

// toto sluzi ako nahrada subselectu ktori asi bute trvat dlhsie aspon podla mna !!! a je to zataz pre db !!
$state = 'prepared';
// kazdy vnutorni array in $array_of_times predstavuje den monday [7:00 , 22:00] vo formate intigerov [7 , 22]
$array_of_times = [[7 , 19.5], // pondelok povodne hodnoti boli vasde 22 koli for ciku su zmeneni o 2.5 aby sa zmestili do konca pracovnej doby
                    [6 , 19.5], // utorok
                    [6 , 19.5], // streda
                    [7 , 19.5], // stvrtok
                    [7 , 19.5], //piatok
                    [0,-1], // sobota [0,-1] lebo sa nerobi v dane dni
                    [0,-1]]; //nedela [0,-1] lebo sa nerobi v dane dni

$holidays = ['2020-12-14','2020-12-15']; // array of holidays format YYYY:MM:DD picom zapis musi splnat poziadavki ak je napr.mesiac 1 tak zapis vyzera '01' to iste pre dni


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
        if (in_array($tomorrow_of_today,$holidays)){
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

