<?php include('C:\xampp\htdocs\pizza-order\config\constants.php') ?>

<html>
    <head>
        <title>Login - Pizza order system</title>
        <link rel="stylesheet" href="..\css\admin.css">
    </head>
    <body>
        <div class="login">
            <h1 class="text-center">Login</h1>
            <br><br>

            <?php
            if(isset($_SESSION['login']))
            {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
            if(isset($_SESSION['no-login-message']))
            {
                echo $_SESSION['no-login-message'];
                unset($_SESSION['no-login-message']);
            }
            ?>
            <br><br>

            <!-- login form -->
            <form action="" method="POST">
                Username: <br>
                <input type="text" name="username" placeholder="Enter username"><br><br>
                Password:<br>
                <input type="password" name="password" placeholder="Enter password"><br><br>

                <input type="submit" name="submit" value="Login" class="btn-primary">
                <br><br>
            </form>
            <!-- login form -->

            <p class="text-center">Meghna Phanse, TYCS - 9271</p>
        </div>
    </body>
</html>

<?php

//check if button is clicked or not
if(isset($_POST['submit']))
{

    //process for login
    //1. get data from login form
    $username = $_POST['username'];
    $password= md5 ($_POST['password']);

    //2.sql query to check if username password exist or not
    $sql="SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

    //3. execute query
    $res=mysqli_query($conn, $sql);

    //4. count rows to whether the user exists or not
    $count=mysqli_num_rows($res);
    if($count==1)
    {
        //user available and logged in
        $_SESSION['login']="Login Successful";

        $_SESSION['user'] = $username; //to check if user is logged in or not and logout will unset it

        //redirect to home
        header('location:'.SITEURL.'admin/');
    }
    else
    {
        //user not available and login failed
        $_SESSION['login']="Login Failed. Username or Password do not match.";
        //redirect to home
        header('location:'.SITEURL.'admin/login.php');
    }

}

?>