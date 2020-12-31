<?php
include('../db.php');
/// SUBOR MUSI BYT ODSTRANENI PO TESTOVANI
$sql = "TRUNCATE TABLE time_slot ";
if ($result = $mysqli->query($sql)) {
    echo "VYCISTENA && Auto increment nastaveni na 1 (time slot)<br>";
} else{
    echo "CHYBA SKRIPTU <br> ";
}
$sql = "TRUNCATE TABLE dump_table ";
if ($result = $mysqli->query($sql)) {
    echo "VYCISTENA (dump_table)<br>";
} else{
    echo "CHYBA SKRIPTU <br> ";
}
$sql = "TRUNCATE TABLE employee ";
if ($result = $mysqli->query($sql)) {
    echo "VYCISTENA (employee)<br>";
} else{
    echo "CHYBA SKRIPTU <br> ";
}

$sql = "INSERT INTO employee SET 
                meno='admin',
                priezvisko='admin', 
                meno_splocnosti='GEFCO', 
                email='admin.admin@gmail.com',
                heslo=MD5('administrator'), 
                role='AD'";
if ($result = $mysqli->query($sql)) {
    echo "Pridany Admin do (employee)<br>";
} else{
    echo "CHYBA SKRIPTU <br> ";
}
$sql = "TRUNCATE TABLE holidays ";
if ($result = $mysqli->query($sql)) {
    echo "VYCISTENA (holidays)<br>";
} else{
    echo "CHYBA SKRIPTU <br> ";
}
$sql = "INSERT INTO holidays(id,holidays) VALUES (1,'' ) ";
if ($result = $mysqli->query($sql)) {
    echo "Pridany Prazdni zoznam prazdnin do (holidays)<br>";
} else{
    echo "CHYBA SKRIPTU <br> ";
}
$base_value = "Ramp1-0000000 Ramp2-0000000 Ramp3-0000000 Ramp4-0000000 Ramp5-0000000 Ramp6-0000000 Ramp7-0000000 Ramp8-0000000 Ramp9-0000000 Ramp10-0000000 Ramp11-0000000 Ramp12-0000000 Ramp13-0000000 Ramp14-0000000 Ramp15-0000000 Ramp16-0000000 Ramp17-0000000 Ramp18-0000000 Ramp19-0000000 Ramp20-0000000 Ramp21-0000000 Ramp22-0000000 Ramp23-0000000 Ramp24-0000000 Ramp25-0000000 Ramp26-0000000 Ramp27-0000000 Ramp28-0000000 Ramp29-0000000 Ramp30-0000000 Ramp31-0000000 Ramp32-0000000 Ramp33-0000000 Ramp34-0000000 Ramp35-0000000 Ramp36-0000000 Ramp37-0000000 Ramp38-0000000";

$sql = "INSERT INTO holidays(id,holidays) VALUES (2,'{$base_value}') ";
if ($result = $mysqli->query($sql)) {
    echo "Nastavenie vsetkych ramp na free (holidays)<br>";
} else{
    echo "CHYBA SKRIPTU <br> ";
}

$sql = "UPDATE  config_start_end_working SET 
            starting_hour = 7, 
            ending_hour = 22,
            exception_status = 0
            WHERE id > 0";
if ($result = $mysqli->query($sql)) {
    echo "Nastavenie pracovnich dni na 7:00 - 22:00  (config_start_end_working)<br>";
} else{
    echo "CHYBA SKRIPTU <br> ";
}
$sql = "UPDATE  config_start_end_working SET 
            starting_hour = 6, 
            ending_hour = 22,
            exception_status = 0
            WHERE id = 2 OR id = 3 ";
if ($result = $mysqli->query($sql)) {
    echo "Nastavenie pracovnich dni (Utorok, Streda) na 6:00 - 22:00  (config_start_end_working)<br>";
} else{
    echo "CHYBA SKRIPTU <br> ";
}
$sql = "UPDATE  config_start_end_working SET 
            starting_hour = 0, 
            ending_hour = 0,
            exception_status = 0
            WHERE id = 6 OR id = 7 ";
if ($result = $mysqli->query($sql)) {
    echo "Nastavenie pracovnich dni (Sobota, Nedela) na 00:00 - 00:00  (config_start_end_working)<br>";
} else{
    echo "CHYBA SKRIPTU <br> ";
}
