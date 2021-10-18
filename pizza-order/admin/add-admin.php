<?php include('partials/menu.php')?>

<div class='main-content'>
    <div class ='wrapper'>
        <h1>Add Admin</h1>
        <br><br>
        <?php
        if(isset($_SESSION['add'])) //checking whether the session is set or not
        {
            echo $_SESSION['add']; //displaying session message
            unset($_SESSION['add']); //removes session message
        }
        ?>
        <form action='' method='POST'>
            <table class='tbl-30'>
                <tr>
                    <td>Full Name: </td>
                    <td><input type='text' name="full_name" placeholder='Enter name'></td>
                </tr>
                <tr>
                <td>Username: </td>
                <td><input type='text' name= "username" placeholder='Username'></td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td><input type='password' name='password' placeholder='password'></td>
                </tr>
                <tr>
                    <td colspan='2'>
                        <input type="submit" name='submit' value='Add Admin' class='btn-secondary'>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php')?>

<?php
//process value and save in database

//check if clicked submit or not
if(isset($_POST['submit']))
{
//Button clicked
//

//1. Get data from form
$full_name=$_POST['full_name'];
$username=$_POST['username'];
$password= md5 ($_POST['password']); //md5 is a simple password encryption

//2. sql query to save data in database
$sql = "INSERT INTO tbl_admin SET
full_name='$full_name',
username='$username',
password='$password'
";

//3. Execute query and save data in database
$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "pizza-order";
$dbport = 3310;

$conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname, $dbport);
$res = mysqli_query($conn, $sql) or die(mysqli_connect());

//4. Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}
//5. check whether the data is inserted or not and display amessage
if ($res==TRUE)
{
    //data inserted
    //echo "Data Inserted";
    //create a session variable to display message
    $_SESSION['add'] = "Admin added Successfully";
    //Redirect page to manage admin
    header("location:".SITEURL.'admin/manage-admin.php');
}
else
{
    //failed to connect
    //echo "Failed to Insert Data";
    //create a session variable to display message
    $_SESSION['add'] = "Failed to Add Admin";
    //Redirect page to manage admin
    header("location:".SITEURL.'admin/manage-admin.php');
}
}
?>