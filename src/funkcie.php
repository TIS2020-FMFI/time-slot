<?php
include('db.php');











function skontroluj($udaj) {
    if((int)$udaj[0] > 0){
        return '';
    }
    else{
        return trim(strip_tags($udaj));
    }
}
function dobra_adresa($adres) {//spravna=dobra  ci ma viac ako 5 znakov
  return strlen($adres) >= 5;
}

//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
function dobra_dlzka($z) {//spravna dlzka ma viac ako 3 znaky a menej nez 30 !!!!!!pri registracii
  return strlen($z) >= 3 && strlen($z) <= 30;
}
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!



function spravny_nazov ($nazov) {// spravny_nazov 
	return strlen($nazov) >= 3 && strlen($nazov) <= 100;
}

function spravne_meno($men) {// meno + medzera + priezvisko			treba pri registracii?
  $medzera = strpos($men, ' ');
  if (!$medzera) return false;       
  $priezvisko = substr($men, $medzera+1);  
  return ($medzera > 2 && (strpos($priezvisko, ' ') === FALSE) && strlen($priezvisko) > 2);// viac ako 2 = tri,...
}




function over_pouzivatela($mysqli, $username, $pass) {
	if (!$mysqli->connect_errno) {
		$sql = "SELECT * FROM pouzivatelia WHERE prihlasmeno='$username' AND heslo=MD5('$pass')";  // definuj dopyt
//		echo "sql = $sql <br>";
		if (($result = $mysqli->query($sql)) && ($result->num_rows > 0)) {  // vykonaj dopyt
			// dopyt sa podarilo vykonať
			$row = $result->fetch_assoc();
			$result->free();
			return $row;
		} else {
			// dopyt sa NEpodarilo vykonať, resp. používateľ neexistuje!
			echo '<p class="chyba">Používateľ neexistuje! Nesprávne meno alebo heslo!</p>';
			return false;
		}
	} else {
		// NEpodarilo sa spojiť s databázovým serverom!
		return false;
	}
}

/*function pridaj_pouzivatela($mysqli, $prihlasmeno, $heslo, $meno, $priezvisko) {
	if (!$mysqli->connect_errno) {
		$prihlasmeno = $mysqli->real_escape_string($prihlasmeno);
		$heslo = $mysqli->real_escape_string($heslo);
		$meno = $mysqli->real_escape_string($meno);
		$priezvisko = $mysqli->real_escape_string($priezvisko);
		
		$sql = "INSERT INTO pouzivatelia SET prihlasmeno='$prihlasmeno', heslo=MD5('$heslo'), meno='$meno', priezvisko='$priezvisko'"; // definuj dopyt
		if ($result = $mysqli->query($sql)) { 
	    echo '<p>Používateľ bol pridaný.</p>'. "\n"; 
			return true;
	 	} else {
			echo '<p class="chyba">Nastala chyba pri pridávaní používateľa';
			// kontrola, či nenastala duplicita kľúča (číslo chyby 1062) - prihlasovacie meno už existuje
			if ($mysqli->errno == 1062) echo ' (Zadané prihlasovacie meno už existuje, použite prosím iné.)';
			echo '.</p>' . "\n";
			return false;
	  }
	} else {
		// NEpodarilo sa spojiť s databázovým serverom alebo vybrať databázu!
		echo '<p class="chyba">NEpodarilo sa spojiť s databázovým serverom!</p>';
		return false;
	}
}	// koniec funkcie*/

function zmen_heslo($mysqli, $id, $pass) {
	if (!$mysqli->connect_errno) {
	  $sql="UPDATE pouzivatelia SET heslo=MD5('$pass') WHERE id_pouz='$id'"; // definuj dopyt   
//		echo "sql = $sql <br>";
		if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
			// dopyt sa podarilo vykonať
      echo '<p>Heslo bolo zmenené.</p>'. "\n"; 
    } else {
			// NEpodarilo sa vykonať dopyt!
      echo '<p class="chyba">Nastala chyba pri zmene hesla.</p>'. "\n"; 
		}
	} else {
		// NEpodarilo sa spojiť s databázovým serverom alebo vybrať databázu!
		echo '<p class="chyba">NEpodarilo sa spojiť s databázovým serverom!</p>';
	}
}	// koniec funkcie




//hkjhkhkjhjh!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
function vypis_kosik($mysqli) {
	if (!$mysqli->connect_errno) {
		$sql = "SELECT * FROM ponuka2";
		if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
			// dopyt sa podarilo vykonať
			echo '<form method="post">';
			echo '<p>'; 
			while ($row = $result->fetch_assoc()) {
    		echo "<input type='checkbox' name='tovar[]' value='{$row['kod']}' id='tovar{$row['kod']}'><label for='tovar{$row['kod']}'>{$row['nazov']}</label><br>\n";
			} 
			echo '</p>'; 
  		echo '<p><input type="submit" name="zrus" value="Zruš tovary"></p>';
  		echo '</form>';
			$result->free();
  	} else {
			// NEpodarilo sa vykonať dopyt!
    	echo '<p class="chyba">Nastala chyba pri získavaní údajov z DB.</p>' . "\n";
    }
	}
}
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!1




function vypis_zrus($mysqli) {
    $arr = array();
    //$total = 0;
    if (!$mysqli->connect_errno) {
        $sql = "SELECT * FROM objednavka ORDER BY meno_uz ASC";
        if ($result = $mysqli->query($sql)) {  // vykonaj dopyt
            // dopyt sa podarilo vykonať
            echo '<form method="post">';
            echo '<p>';
            while ($row = $result->fetch_assoc()) {
                $arr[] = $row['kod_to'];
                //$total +=
                echo "<input type='checkbox' name='tovar[]' value='{$row['kod_to']}' id='tovar{$row['kod_to']}'> <label for='tovar{$row['kod_to']}'> {$row['kod_to']}</label><br>\n";
            }
            echo '</p>';
            echo '<p><input type="submit" name="zrus" value="zrus tovar"></p>';
            echo '</form>';

            $result->free();
            $_SESSION['aktualne_meno'] = array();
            $_SESSION['aktualne_meno'] = $arr;
        } else {
            // NEpodarilo sa vykonať dopyt!
            echo '<p class="chyba">Nastala chyba pri získavaní údajov z DB.</p>' . "\n";
        }
    }
}
function zrus_tovar($mysqli, $idt) {
    if (!$mysqli->connect_errno) {
        $sql="DELETE FROM objednavka WHERE kod_to='{$mysqli->real_escape_string($idt)}'"; // definuj dopyt
        if ($result = $mysqli->query($sql) && ($mysqli->affected_rows > 0)) {  // vykonaj dopyt
            // dopyt sa podarilo vykonať

            echo "<p>Tovar č. $idt bol zrušený.</p>\n";
            // treba zistiť, či mal tovar obrázok, ak áno, treba ho zrušiť
            /*$subor = 'tovar-obrazky/' . $idt . '.png';
            if (file_exists($subor)) {
                if (unlink($subor)) echo '<p>Obrázok tovaru bol vymazaný.</p>'. "\n";
                else echo '<p class="chyba">Obrázok tovaru sa nepodarilo vymazať. Treba ho vymazať ručne.</p>'. "\n";
            }*/
        } else {
            // NEpodarilo sa vykonať dopyt!
            echo "<p class='chyba'>Nastala chyba pri rušení tovaru č. $idt.</p>\n";
        }
    }
} 	// koniec funkcie
?>
