<?php
//start session
session_start();

//create constants to store values not repeating
define('SITEURL', 'http://localhost/pizza-order/');

//3. Execute query and save data in database
$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "pizza-order";
$dbport = 3310;

$conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname, $dbport);

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}
?>