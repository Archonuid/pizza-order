<?php include('partials/menu.php')?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br><br>

        <?php
        
        if(isset($_SESSION['add']))
        {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        
        ?>
        <br><br>


        <!--add category form-->
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>
                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="yes"> Yes
                        <input type="radio" name="featured" value="no"> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="yes"> Yes
                        <input type="radio" name="active" value="no"> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <!--add category form ends-->
        <?php
        
        //check if submit button clicked or not
        if(isset($_POST['submit']))
        {
            //echo "Clicked";

            //1. get value from form
            $title = $_POST['title'];

            //for radio button, check if it is selected or not
            if(isset($_POST['featured']))
            {
                //get value from form
                $featured = $_POST['featured'];

            }
            else
            {
                //set default value
                $featured = "No";
            }

            if(isset($_POST['active']))
            {
                $active = $_POST['active'];
            }
            else
            {
                $active = "No";
            }

            //check if image is selected or not and set image name
            //print_r($_FILES['image']);
            //die(); //break code here

            if(isset($_FILES['image']['name']))
            {
                //upload image
                //to upload image, it need image name and source path and destination path
                $image_name=$_FILES['image']['name'];

                //upload image only if image is selected
                if($image_name!=="")
                {
                    //to auto rename our image
                    //get extension of image(jpg, png, gif, etc) eg: image1.jpg
                    $ext = end(explode('.', $image_name));
                    
                    //rename image
                    $image_name = "Food_category_".rand(000, 999).'.'.$ext; //eg: food_category_123.jpg
                    $source_path=$_FILES['image']['tmp_name'];
                    $destination_path="../images/category/".$image_name;
                    
                    //upload image
                    $upload = move_uploaded_file($source_path, $destination_path);
                    //check whether image uploaded or not
                    //if image not upload then stop the process and redirect 
                    if($upload==false)
                    {
                        //set message
                        $_SESSION['upload'] = "Failed to upload image";
                        //redirect to add category
                        header('location:'.SITEURL.'admin/add-category.php');
                        //stop process
                        die();
                    }
                }
            }
            else
            {
                //no upload image and set the image name as blank
                $image_name="";
            }

            //2. create sql query to insert data in database
            $sql = "INSERT INTO tbl_categories SET
            title = '$title',
            image_name = '$image_name',
            featured = '$featured',
            active = '$active'
            ";

            //3. execute and save
            $res = mysqli_query($conn, $sql);

            //4. check if query executed or not and data added
            if($res==true)
            {
                //query executed and data added
                $_SESSION['add'] = "Category Added Successfully";
                //redirect to manage category
                header('location:'.SITEURL.'admin/manage-category.php');
            }
            else
            {
                //failed to add
                $_SESSION['add'] = "Failed To Add Category";
                //redirect
                header('location:'.SITEURL.'admin/add-category.php');

            }

        }

        ?>

    </div>
</div>

<?php include('partials/footer.php')?>