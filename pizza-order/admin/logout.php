<?php
//include constants php for siteurl
include('C:\xampp\htdocs\pizza-order\config\constants.php');

//1. destroy the session
session_destroy(); //unsets $_Session['user']

//2. redirect to login
header('location:'.SITEURL.'admin/login.php');

?>