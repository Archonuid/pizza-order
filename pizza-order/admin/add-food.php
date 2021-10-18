<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>
        <?php 

        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }

        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the food">
                    </td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="" cols="25" rows="5" placeholder="Description of Food"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>
                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">

                            <?php
                            //create code to display categories from database
                            //1. create sql to get all active categories from database
                            $sql = "SELECT * FROM tbl_categories WHERE active='yes'";

                            //executing query
                            $res = mysqli_query($conn, $sql);

                            //count rows to check if categories available or not
                            $count = mysqli_num_rows($res);

                            //if count is greater than 0 then categories available else not available
                            if($count>0)
                            {
                                //categories available
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    //get the value details of categories
                                    $id = $row['id'];
                                    $title = $row['title'];
                                    ?>
                                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                    <?php
                                }
                            }
                            else
                            {
                                //no categories available
                                ?>
                                <option value="0">No Categories Found</option>
                                <?php
                            }

                            //2. display on drop down menu
                            ?>

                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php

        //check if button click or no
        if(isset($_POST['submit']))
        {
            //add details in database
            //echo "clicked";

            //1. get the data from form
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];
            
            //check whether radio button for featured and active is selected or not
            if(isset($_POST['featured']))
            {
                $featured = $_POST['featured'];
            }
            else
            {
                $featured = "No"; //default value
            }
            
            if(isset($_POST['active']))
            {
                $active = $_POST['active'];
            }
            else
            {
                $active = "No"; //default
            }

            //2. upload image if added
            //check if image added is clicked or not and upload image if selected
            if(isset($_FILES['image']['name']))
            {
                //get details of image added
                $image_name = $_FILES['image']['name'];

                //check if image is selected or not and upload image if added
                if($image_name!="")
                {
                    //image added
                    //a. rename image
                    //get extension of selected image(jpg, gif, etc)
                    $ext = end(explode('.', $image_name));

                    //new name of image
                    $image_name = "Food-Name-".rand(0000, 9999).".".$ext; //eg: Food-Name-2345.jpg

                    //b. upload image
                    //get src path and destination path

                    //src path is current location of image
                    $src = $_FILES['image']['tmp_name'];

                    //destination path of image
                    $dst = "../images/food/".$image_name;

                    //upload image
                    $upload = move_uploaded_file($src, $dst);

                    //check if image uploaded or not
                    if($upload==false)
                    {
                        //failed to upload image
                        //redirect to add food.php with error
                        $_SESSION['upload'] = "Failed to Upload Image";
                        header('location:'.SITEURL.'admin/add-food.php');
                        //kill process
                        die();
                    }
                }
            }
            else
            {
                $image_name = ""; //default value
            }

            //3. insert into database
            //sql query to save added food
            $sql2 = "INSERT INTO tbl_food SET
            title = '$title',
            description = '$description',
            price = $price,
            image_name = '$image_name',
            category_id = $category,
            featured = '$featured',
            active = '$active'
            ";

            //execute
            $res2 = mysqli_query($conn, $sql2);
            //check if data saved or not
            //4. redirect to manage page
            if($res2==true)
            {
                //data saved
                $_SESSION['add'] = "Food added Successfully";
                header('location:'.SITEURL.'admin/manage-food.php');
            }
            else
            {
                //failed to save data
                $_SESSION['add'] = "Failed to Add Food";
                header('location:'.SITEURL.'admin/manage-food.php');
            }

        }

        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>