<?php
$host = 'localhost';
$username = 'root';
$password = 'usbw';
$dbname = 'tis';

$mysqli = new mysqli($host,$username,$password,$dbname);
if ($mysqli->connect_errno) { // tuna bude load error page ze sa neda pripojit k db
	echo '<p class="chyba">NEpodarilo sa pripojiť!</p>';
} else {
	$mysqli->query("SET CHARACTER SET 'utf8'");
}
