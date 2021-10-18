<?php

//authorisation or access control

//check if user if logged in or not
if(!isset($_SESSION['user'])) //if user session is not set
{
    //user not logged in
    $_SESSION['no-login-message'] = "Please Login to access Admin Dashboard.";
    //redirect to login
    header('location:'.SITEURL.'admin/login.php');
}
?>