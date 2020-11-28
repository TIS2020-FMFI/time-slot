<?php
include('../db.php');
$sql = "delete from time_slot where id > 0";
if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
    echo "VYCISTENA DB(TIME SLOTS)<br>";
} else{
    echo "CHYBA SKRIPTU ";
}
$array_of_state = Array("prepared","requested","finished","booked");
for ($d = 0 ;$d < 5;$d++){
    for ($i = 0 ;$i < 250;$i++){
        if (!$mysqli->connect_errno) {
            /// je tu chynba lebo generuje id_external_dispatcher pre vsetky time_slots
            $random_state = $array_of_state[array_rand($array_of_state)];
            $time_start = ($d*24)+($i).':30:00';
            $time_end =  ($d*24)+($i+2).':30:00';
            $gate_number_random = rand ( 1 , 10 ) ; // toto sluzi ako nahrada subselectu ktori asi bute trvat dlhsie aspon podla mna !!! a je to zataz pre db !!
            $characters = 'ABCDE';
            $input = array("A", "B", "C", "D", "E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
            $rand_keys_st = array_rand($input, 2);
            $rand_keys_ed = array_rand($input, 2);
            $rand_number_of_drivers = rand ( 1 , 2 ) ;
            $evc_number_random = $input[$rand_keys_st[0]].$input[$rand_keys_st[1]]."-".rand ( 100 , 999 )."-".$input[$rand_keys_ed[0]].$input[$rand_keys_ed[1]];
            $sql = "INSERT INTO time_slot (`id_gate`,id_external_dispatcher, id_truck_driver_1,id_truck_driver_2, evc_truck,`start_date_time`, `end_date_time`, `state`)
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
}