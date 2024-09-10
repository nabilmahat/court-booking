<?php

date_default_timezone_set('Asia/Kuala_Lumpur');


$host = "localhost"; 
$user = "root"; //dbuser
$pass= "1234"; //dbpass
$db = "court_booking"; //db name
$conn = mysqli_connect($host, $user, $pass, $db);
session_start();
?>