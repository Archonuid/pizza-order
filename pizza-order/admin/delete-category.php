<?php

//include constants 
include('C:\xampp\htdocs\pizza-order\config\constants.php');

//check whether the id and image_name value is set or not
if(isset($_GET['id']) && isset($_GET['image_name']))
{
    //get value and delete
    //echo "Get Value and delete";
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    //remove the physical image file is available
    if($image_name!="")
    {
        //image is available, so remove it
        $path = "../images/category/".$image_name;
        //remove image
        $remove = unlink($path);

        //if failed to remove image, send error text
        if($remove==false)
        {
            //set session message
            $_SESSION['remove'] = "Failed to Remove Image";
            //redirect to manage category
            header('location:'.SITEURL.'admin/manage-category.php');
            //stop process
            die();
        }
    }

    //delete data from database
    //sql query to delete
    $sql = "DELETE FROM tbl_categories WHERE id=$id";

    //execute
    $res = mysqli_query($conn, $sql);

    //check if data is delete from database
    if($res==true)
    {
        //text success and redirect
        $_SESSION['delete'] = "Deleted Successfully";
        //redirect
        header('location:'.SITEURL.'admin/manage-category.php');
    }
    else
    {
        //text error and redirect
        $_SESSION['delete'] = "Failed to Delete";
        //redirect
        header('location:'.SITEURL.'admin/manage-category.php');
    }

}
else
{
    //redirect to manage-category page
    header('location:'.SITEURL.'admin/manage-category.php');

}

?>