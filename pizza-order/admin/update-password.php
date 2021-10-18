<?php include('partials/menu.php')?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php
        if(isset($_GET['id']))
        {
            $id=$_GET['id'];
        }
        ?>
        
        <form action="" method="POST">

        <table class="tbl-30">
            <tr>
                <td>Current Password: </td>
                <td>
                    <input type="password" name="current_password" placeholder="Current Password">
                </td>
            </tr>
            <tr>
                <td>New Password: </td>
                <td>
                    <input type="password" name="new_password" placeholder="New Password">
                </td>
            </tr>
            <tr>
                <td>Confirm Password: </td>
                <td>
                    <input type="password" name="confirm_password" placeholder="Confirm Password">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                </td>
            </tr>

        </table>

        </form>


    </div>
</div>

<?php

//check button
if(isset($_POST['submit']))
{
    //echo "Clicked";

    //1.get data
    $id = $_POST['id'];
    $current_password = md5($_POST['current_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);

    //2.check if user with current password exists or not
    $sql = "SELECT * FROM tbl_admin WHERE id='$id' AND password='$current_password'";

    //execute query
    $res = mysqli_query($conn, $sql);

    if($res==TRUE)
    {
        //check if data is there or not
        $count = mysqli_num_rows($res);

        if($count==1)
        {
            //user exists and password change
            //echo "User Found";

            //check if new password and confirm pwd match
            if($new_password==$confirm_password)
            {
                //update password
                $sql2 = "UPDATE tbl_admin SET
                password='$new_password'
                WHERE id=$id
                ";
                //execute
                $res2 = mysqli_query($conn, $sql2);

                //check if query works
                if($res2==TRUE)
                {
                    //display message
                    $_SESSION['change-pwd'] = "Password Changed.";
                    //redirect
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
                else
                {
                    //display error
                    $_SESSION['change-pwd'] = "Failed to change Password.";
                    //redirect
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }
            else
            {
                //redirect to manage admin and error
                $_SESSION['pwd-not-match'] = "Passwords do not match.";
                //redirect
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }
        else
        {
            //user no exist and no change, redirect
            $_SESSION['user-not-found'] = "User Not Found.";
            //redirect
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
    }

    //3.check if new password and confirm password match or not

    //4.change password if all is okay
}

?>


<?php include('partials/footer.php')?>