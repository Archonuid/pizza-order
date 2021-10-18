<?php

//include constants.php 
include('C:\xampp\htdocs\pizza-order\config\constants.php');

//1. get id of admin to delete
$id = $_GET['id'];

//2. create sql query to delete
$sql = "DELETE FROM tbl_admin WHERE id=$id";

//execute the query
$res = mysqli_query($conn, $sql);

//check if query executed or not
if($res==TRUE)
{
    //query executed and admin deleted
    //echo "Admin Deleted";
    //create session variable to display message
    $_SESSION['delete'] = "Admin Deleted.";
    //redirect to manage admin
    header('location:'.SITEURL."admin/manage-admin.php");
}
else
{
    //failed to delete
    //echo "Failed to Delete";

    $_SESSION['delete'] = "Failed to Delete. Try again later.";
    header('location:'.SITEURL."admin/manage-admin.php");
}

//3. redirect to manage admin page 

?>