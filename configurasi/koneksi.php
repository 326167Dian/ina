<?php
Date_Default_timezone_set('Asia/jakarta');
$server = "localhost";
$user = "u877780297_ina"; 
$password = "7390091979Dian&&"; 
$database = "u877780297_inafarma";
set_time_limit(1800);

include_once "conn.php";
($GLOBALS["___mysqli_ston"] = mysqli_connect($server, $user, $password)) or die("Koneksi gagal");
mysqli_select_db($GLOBALS["___mysqli_ston"], $database) or die("Database tidak ditemukan");
// $koneksi = new mysqli($server, $user, $password) or die("Koneksi gagal");
$db = mysqli_connect('localhost', 'u877780297_ina', '7390091979Dian&&', 'u877780297_inafarma');
