<?php
$host = 'localhost';
$username = 'root';
$password = 'usbw';
$dbname = 'tis';

$mysqli = new mysqli($host,$username,$password,$dbname);
if ($mysqli->connect_errno) {
	echo '<strong>NEpodarilo sa pripojiť s databazou</strong>';
} else {
	$mysqli->query("SET CHARACTER SET 'utf8'");
}
