<?php include('partials/menu.php')?>

<?php

//check if id set or not
if(isset($_GET['id']))
{
    //get details
    $id = $_GET['id'];

    //sql query to get details
    $sql2 = "SELECT * FROM tbl_food WHERE id=$id";
    //execute
    $res2 = mysqli_query($conn, $sql2);
    //get value based on query executed
    $row2 = mysqli_fetch_assoc($res2);
    //get individual values of selected food
    $title = $row2['title'];
    $description = $row2['description'];
    $price = $row2['price'];
    $current_image = $row2['image_name'];
    $current_category = $row2['category_id'];
    $featured = $row2['featured'];
    $active = $row2['active'];

}
else
{
    //redirect
    header('location:'.SITEURL.'admin/manage-food.php');
}

?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="25" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                        if($current_image=="")
                        {
                            //image not available
                            echo "Image Not Available";
                        }
                        else
                        {
                            //image not available
                            ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="100px">
                            <?php
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Select New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">

                            <?php
                            //query to get active categories
                            $sql = "SELECT * FROM tbl_categories WHERE active='Yes'";
                            //execute
                            $res = mysqli_query($conn, $sql);
                            //count rows
                            $count = mysqli_num_rows($res);
                            //check if category available or not
                            if($count>0)
                            {
                                //category available
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    $category_title = $row['title'];
                                    $category_id = $row['id'];

                                    echo "<option value='$category_id'>$category_title</option>";
                                }
                            }
                            else
                            {
                                //category not available
                                //echo "<option value='0'>Category not Available.</option>";
                                ?>
                                <option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes"){echo "Checked";} ?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if($featured=="No"){echo "Checked";} ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active=="Yes"){echo "Checked";} ?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if($active=="No"){echo "Checked";} ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">

                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>
        <?php
        
        if(isset($_POST['submit']))
        {
            //echo "clicked";

            //1. get details
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $current_image = $_POST['current_image'];
            $category = $_POST['category'];

            $featured = $_POST['featured'];
            $active = $_POST['active'];

            //2. upload image if selected

            //upload button clicked or not
            if(isset($_FILES['image']['name']))
            {
                //upload button clicked
                $image_name = $_FILES ['image']['name']; //new image name

                //file is available or not
                if($image_name!="")
                {
                    //image available
                    //a. upload new image
                    //rename
                    $ext = end(explode('.', $image_name)); //gets extension of image
                    $image_name = "Food-Name-".rand(0000, 9999).'.'.$ext; //rename the image

                    //src and destination path
                    $src_path = $_FILES['image']['tmp_name']; //source path
                    $dest_path = "../images/food/".$image_name; //destination path

                    //upload image
                    $upload = move_uploaded_file($src_path, $dest_path);

                    //image uploaded or not
                    if($upload==false)
                    {
                        $_SESSION['upload'] = "Failed to Upload Image.";
                        header('location:'.SITEURL.'admin/manage-food.php'); 
                        //stop process
                        die();
                    }

                    //3. remove image if uploaded and new image is put
                    //b. remove current image
                    if($current_image!=="")
                    {
                        //available
                        //redirect
                        $remove_path = "../images/food/".$current_image;

                        $remove = unlink($remove_path);

                        //image removed or not
                        if($remove==false)
                        {
                            //failed to remove current image
                            $_SESSION['remove-failed'] = "Failed to Remove Image.";
                            header('location:'.SITEURL.'admin/manage-food.php');
                            die();
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

            //4. update food in database
            $sql3 = "UPDATE tbl_food SET
            title = '$title',
            description = '$description',
            price = $price,
            image_name = '$image_name',
            category_id = '$category',
            featured = '$featured',
            active = '$active'
            WHERE id=$id
            ";

            //execute query
            $res3 = mysqli_query($conn, $sql3);

            //check if query works or no
            if($res3==true)
            {
                //query executed
                $_SESSION['update'] = "Food Updated Successfully";
                header('location:'.SITEURL.'admin/manage-food.php');
            }
            else
            {
                //fail to update
                $_SESSION['update'] = "Failed to Update";
                header('location:'.SITEURL.'admin/manage-food.php');
            }
        }
        
        ?>
    </div>
</div>

<?php include('partials/footer.php')?>