<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>

        <br><br>
        <?php

        //check if ID is set or not
        if(isset($_GET['id']))
        {
            //get the ID details
            //echo "rawr";
            $id = $_GET['id'];
            //sql query to get other details
            $sql = "SELECT * FROM tbl_categories WHERE id=$id";

            //execute query
            $res = mysqli_query($conn, $sql);
            //count rows to check ID is there or not
            $count = mysqli_num_rows($res);

            if($count==1)
            {
                //get all details
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $current_image = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];
            }
            else
            {
                //redirect to manage category with message
                $_SESSION['no-category-found'] = "Category not Found";
                header('location:'.SITEURL.'admin/manage-category.php');
            }
        }
        else
        {
            //redirect to manage category
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                <td>Title: </td>
                <td>
                    <input type="text" name="title" value="<?php echo $title; ?>">
                </td>
                </tr>
                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php

                        if($current_image!="")
                        {
                            //display message
                            ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width = "150px">
                            <?php
                        }
                        else
                        {
                            //error message
                            echo "No Image";
                        }
                        
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>New Image: </td>
                    <td>
                    <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes

                        <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"> Yes

                        <input <?php if($active=="No"){echo "Selected";} ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        
        </form>

        <?php

        if(isset($_POST['submit']))
        {
            //echo "click";
            //1. get all values from our form
            $id = $_POST['id'];
            $title = $_POST['title'];
            $current_image = $_POST['current_image'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            //2. update new image if selected
            //check whether image is selected or not 
            if(isset($_FILES['image']['name']))
            {
                //get image details
                $image_name = $_FILES['image']['name'];
                //check whether image is available or not
                if($image_name!="")
                {
                    //image available
                    //upload image

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
                        //redirect to manage category
                        header('location:'.SITEURL.'admin/manage-category.php');
                        //stop process
                        die();
                    }

                    //remove the current image if available
                    if($current_image!=="")
                    {
                        $remove_path = "../images/category/".$current_image;
                        $remove = unlink($remove_path);

                        //check whether the image is removed or not
                        //if failed then show message and die process
                        if($remove==false)
                        {
                            //failed to remove image
                            $_SESSION['failed-remove']="Failed to Remove Image";
                            header('location:'.SITEURL.'admin/manage-category.php');
                            die(); //stop process
                        }
                    }

                }
                else
                {
                    $image_name = $current_image;
                }
            }
            else
            {
                $image_name = $current_image;
            }

            //3. update database
            $sql2 = "UPDATE tbl_categories SET
            title = '$title',
            image_name = '$image_name',
            featured = '$featured',
            active = '$active'
            WHERE id=$id
            ";

            //execute query
            $res2 = mysqli_query($conn , $sql2);

            //4. redirect to manage category
            //check if query executed or not
            if($res2==true)
            {
                //category updated
                $_SESSION['update'] = "Category Updated";
                //redirect
                header('location:'.SITEURL.'admin/manage-category.php');
            }
            else
            {
                //failed to update
                $_SESSION['update'] = "Failed to Update Category";
                //redirect
                header('location:'.SITEURL.'admin/manage-category.php');
            }

        }
        
        ?>
    </div>

</div>

<?php include('partials/footer.php'); ?>