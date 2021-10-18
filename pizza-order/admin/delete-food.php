<?php

//include constants page
include('../config/constants.php');

//echo "Delete yo existence bitch";

if(isset($_GET['id']) && isset($_GET['image_name']))
{
    //delete
    //echo "Process to Delete";

    //1. get id and image name
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    //2. remove image if uploaded
    //check if image is available or not and delete
    if($image_name!="")
    {
        //image available
        //image path
        $path = "../images/food/".$image_name;

        //remove image from file
        $remove = unlink($path);

        //check if image is removed or not
        if($remove==false)
        {
            //failed to delete
            $_SESSION['upload'] = "Failed to Delete";
            header('location:'.SITEURL.'admin/manage-food.php');
            //stop process
            die();
        }
    }
    
    //3. delete food from database
    $sql = "DELETE FROM tbl_food WHERE id=$id";
    //execute
    $res = mysqli_query($conn, $sql);
    //check if works or not
    //4. redirect with message
    if($res==true)
    {
        //food deleted
        $_SESSION['delete'] = "Food Deleted Successfully.";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
    else
    {
        //failed
        $_SESSION['delete'] = "Failed to Delete.";
        header('location:'.SITEURL.'admin/manage-food.php');

    }
}
else
{
    //redirect to manage food
    //echo "Redirect";
    $_SESSION['unauthorized'] = "Unauthorized Access.";
    header('location:'.SITEURL.'admin/manage-food.php');
}

?>