<?php include('partials/menu.php')?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>

        <br><br>

        <?php 
        //1.get id of selected admin
        $id=$_GET['id'];

        //2.create sql query to get details
        $sql="SELECT * FROM tbl_admin WHERE id=$id";

        //execute query
        $res=mysqli_query($conn, $sql);

        //check if query works or not
        if($res==TRUE)
        {
            //check whether data comes or not
            $count = mysqli_num_rows($res);
            //check whether we have admin data or not
            if($count==1)
            {
                //get details
                //echo "Admin Available";
                $row=mysqli_fetch_assoc($res);

                $full_name = $row['full_name'];
                $username = $row['username'];
            }
            else
            {
                //redirect to managa admin
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }
        
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>

                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn_Secondary">
                    </td>

            </table>
        </form>
    </div>
</div>

<?php

//check whether submit button clicked or not
if(isset($_POST['submit']))
{
    //echo "Button Clicked";
    //update values in form
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];

    //sql query to update in database
    $sql = "UPDATE tbl_admin SET
    full_name = '$full_name',
    username = '$username'
    WHERE id='$id'
    ";

    //execute query
    $res = mysqli_query($conn, $sql);

    //check if works or not
    if($res==TRUE)
    {
        //QUERY executed
        $_SESSION['update'] = "Admin Updated.";
        //redirect to manage admin
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else
    {
        //failed to do so
        $_SESSION['update'] = "Update Failed. Try again Later";
        //redirect
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
}

?>


<?php include('partials/footer.php')?>