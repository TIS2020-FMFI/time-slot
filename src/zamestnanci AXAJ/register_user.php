<?php
include('db.php');

if (isset($_POST["F_name"])) {
    $first_name = $_POST["F_name"];
    $last_name = $_POST["L_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $role = $_POST["role"];
    if (!$mysqli->connect_errno) {
        $sql = "INSERT INTO employee SET meno='$first_name',priezvsko='$last_name',  email='$email', heslo=MD5('$password'), role='$role'"; // definuj dopyt
        if ($result = $mysqli->query($sql)) { //&& ($result->num_rows > 0)) {  // vykonaj dopyt
            // dopyt sa podarilo vykonať
            $last_id = $mysqli->insert_id;
            echo 'Používateľ bol pridaný . $ '. $last_id;
            return true;
        } else {
            // NEpodarilo sa vykonať dopyt!
            echo '<p class="chyba">Nastala chyba pri pridávaní používateľa';
            // kontrola, či nenastala duplicita kľúča (číslo chyby 1062) - prihlasovacie meno už existuje
            if ($mysqli->errno == 1062){
                echo 'Zadané prihlasovacie meno už existuje';
            }
            echo '.</p>' . "\n";
            return false;
        }
    } else {
        // NEpodarilo sa spojiť s databázovým serverom alebo vybrať databázu!
        echo '<p class="chyba">NEpodarilo sa spojiť s databázovým serverom!</p>';
        return false;
    }
}
