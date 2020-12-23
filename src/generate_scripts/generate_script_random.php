<?php
include('../db.php');
date_default_timezone_set("Europe/Bratislava");

// premazanie DB IDE LEN O TEST !!!
$sql = "delete from time_slot where id > 0  ";
if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
    echo "VYCISTENA DB(TIME SLOTS)<br>";
} else{
    echo "CHYBA SKRIPTU <br> ";
}

$array_of_state = Array("prepared","requested","finished","booked");
// kazdy vnutorni array in $array_of_times predstavuje den monday [7:00 , 22:00] vo formate intigerov [7 , 22]
$array_of_times = [[7 , 19.5],
    [6 , 19.5],
    [6 , 19.5],
    [7 , 19.5],
    [7 , 19.5],
    [7 , 19.5],
    [7 , 19.5],
    [7 , 19.5],
    [6 , 19.5],
    [6 , 19.5],
    [7 , 19.5],
    [7 , 19.5],
    [7 , 19.5],
    [7 , 19.5]];

$next_start_point_of_generation =  strtotime('1 week ago'); //  treba specifikovat format generovania napr. UTC 00:00
$date = date("Y-m-d", $next_start_point_of_generation);
$date .= ' 00:00:00';
echo $date . '\n';

$input_for_evc = array("A", "B", "C", "D", "E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
$input_for_drivers = array("Anna Biela", "Besni Baca", "Cecelia Celova", "Dobak Drobny", "Emil Email","Fratisek Drobny",
    "Gustavo Fring","Hola HOP","Ildigooo","Jakub Toma","Kazimir Kazisvet","Lud ludsky","MMM M","Nomrmal Insane",
    "Ondrej Richnak","Pikus Pikava","Quarter Quarts","Rasta Ruzovi","Studend Zeleni","Timo Ti","Uhni Dokelu",
    "Viem Neviem","Woxel Pixel","Xiara Xanaxova","YYYY Y","Zlatka Zlata");
$input_for_destination = array("Krajiny", "Kuba", "Honk Kongo", "Keňa", "Južný Sudán	","Južná Afrika",
    "Kórejská republika","severokórejský KRW","Irán","Chorvátsko","Holandsko","Guinea","Komory","Izrael",
    "kostarický colón","Prha","Quatro For mage","Rodos","Swiajciarsko","Thiland","Ukrajina",
    "Vieden","Warsava","Xian-Tiong Honkong","Yursky Park","Zlate Piesky");
$input_for_cargo = array("8x kamiion","7x zlti kamion , 4x ruzove ponozky","10x vreckovky ","50000X balikov Zuvaciek","5x kluc na skrinku");

//$firm_names = ['S - DENT SLOVAKIA, s.r.o.','H - H s.r.o.','EGO - sny z dreva s.r.o.','P&E Services s.r.o','TRIV, s.r.o.'];
for ($gate_number = 1 ;$gate_number < 11;$gate_number++) { //11 pre testovaciu DB
    //echo 'GATE NUMBER'.$gate_number.'<br>';
    for ($gate_times = 0; $gate_times < count($array_of_times); $gate_times++) {
        //echo 'DAY IN WEEK :'.($gate_times+1).'<br>';
        $tomorrow_of_today = date('Y-m-d', strtotime($date . " +".$gate_times." days"));
        for ($times = $array_of_times[$gate_times][0]; $times <= $array_of_times[$gate_times][1] ; $times += 2.5) {
            if (fmod($times,1) == 0.5){
                $time_start = ($gate_times*24)+floor($times).':30:00';
                $time_end =  ($gate_times*24)+round($times+ 2.5).':00:00';
            }
            else{
                $time_start = ($gate_times*24)+round($times).':00:00';
                $time_end =  ($gate_times*24)+floor($times+ 2.5).':30:00';
            }
            $random_state = $array_of_state[array_rand($array_of_state)];

            $rand_keys_st = array_rand($input_for_evc, 2);
            $rand_keys_ed = array_rand($input_for_evc, 2);
            $rand_drivers_1 = $input_for_drivers[array_rand($input_for_drivers, 1)];
            $rand_drivers_2 = $input_for_drivers[array_rand($input_for_drivers, 1)];
            $rand_destination = $input_for_destination[array_rand($input_for_destination, 1)];
            $rand_cargo = $input_for_cargo[array_rand($input_for_cargo, 1)];
            $rand_number_of_drivers = rand ( 1 , 2 ) ;
            $evc_number_random = $input_for_evc[$rand_keys_st[0]].$input_for_evc[$rand_keys_st[1]]."-".rand ( 100 , 999 )."-".$input_for_evc[$rand_keys_ed[0]].$input_for_evc[$rand_keys_ed[1]];

            if ($gate_times > 10 ){// parameter pre volne dni
                $sql = "INSERT INTO time_slot (`id_gate`,`start_date_time`, `end_date_time`, `state`)
                    values('{$gate_number}',
                    (select TIMESTAMP(ADDTIME('{$date}', '{$time_start}'))),
                    (select TIMESTAMP(ADDTIME('{$date}', '{$time_end}'))),
                    'prepared')";
            }else {
                $sql = "INSERT INTO time_slot ( `id_gate`, `id_external_dispatcher`, `truck_driver_1`, `truck_driver_2`, `evc_truck`, `destination`, `cargo`, `start_date_time`, `end_date_time`, `state`)
                    values('{$gate_number}',
                    (case
                        when '{$random_state}' = 'prepared' then 0
                        else    (select id from `employee` where role='EXD' and is_working='1' ORDER BY RAND() LIMIT 1)
                    end) ,
                    (case
                        when '{$random_state}' != 'prepared' then '{$rand_drivers_1}'
                        else   null
                    end) ,
                    (case
                        when '{$random_state}' != 'prepared' and {$rand_number_of_drivers} = 2 then '{$rand_drivers_2}'
                        else   null
                    end) ,
                    (case
                        when '{$random_state}' = 'prepared' then  null
                        else '{$evc_number_random}'
                    end ),
                    (case
                        when '{$random_state}' = 'prepared' then  null

                        else '{$rand_destination}'
                    end ),
                    (case
                        when '{$random_state}' = 'prepared' then  null
                        else '{$rand_cargo}'
                    end ),
                    (select TIMESTAMP(ADDTIME('{$date}', '{$time_start}'))),
                    (select TIMESTAMP(ADDTIME('{$date}', '{$time_end}'))),
                    '{$random_state}')";
            }
            if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
                echo "OK <br>";
            } else{
                echo $sql."     CHYBA SKRIPTU <br>";
            }
        }
    }
}
/*for ($d = 0 ;$d < 5;$d++){
    for ($i = 0 ;$i < 250;$i++){
        if (!$mysqli->connect_errno) {
            /// je tu chynba lebo generuje id_external_dispatcher pre vsetky time_slots

            $time_start = ($d*24)+($i).':30:00';
            $time_end =  ($d*24)+($i+3).':00:00';
            $random_state = $array_of_state[array_rand($array_of_state)];
            $gate_number_random = rand ( 1 , 10 ) ; // toto sluzi ako nahrada subselectu ktori asi bute trvat dlhsie aspon podla mna !!! a je to zataz pre db !!
            $characters = 'ABCDE';
            $input = array("A", "B", "C", "D", "E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
            $rand_keys_st = array_rand($input, 2);
            $rand_keys_ed = array_rand($input, 2);
            $rand_number_of_drivers = rand ( 1 , 2 ) ;
            $evc_number_random = $input[$rand_keys_st[0]].$input[$rand_keys_st[1]]."-".rand ( 100 , 999 )."-".$input[$rand_keys_ed[0]].$input[$rand_keys_ed[1]];
            $sql = "INSERT INTO time_slot (`id_gate`,id_external_dispatcher, id_truck_driver_1,id_truck_driver_2, evc_truck,id_destination_order,`start_date_time`, `end_date_time`, `state`)
                    values('{$gate_number_random}',
                    (case
                        when '{$random_state}' = 'prepared' then 0
                        else    (select id from `employee` where role='EXD' ORDER BY RAND() LIMIT 1)
                    end) ,
                    (case
                        when '{$random_state}' != 'prepared' then (select id from `truck_driver` ORDER BY RAND() LIMIT 1)
                        else   0
                    end) ,
                    (case
                        when '{$random_state}' != 'prepared' and {$rand_number_of_drivers} = 2 then (select id from `truck_driver` ORDER BY RAND() LIMIT 1)
                        else   0
                    end) ,
                    (case
                        when '{$random_state}' = 'prepared' then  null
                        else '{$evc_number_random}'
                    end ),
                    (case
                        when '{$random_state}' = 'prepared' then  null
                        else (select id from `destination_order` ORDER BY RAND() LIMIT 1)
                    end ),
                    (select TIMESTAMP(ADDTIME(now(), '{$time_start}'))),
                    (select TIMESTAMP(ADDTIME(now(), '{$time_end}'))),
                    '{$random_state}')";
            if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
                echo "OK <br>";
            } else{
                echo $sql."     CHYBA SKRIPTU <br>";
            }
        }
    }
}*/