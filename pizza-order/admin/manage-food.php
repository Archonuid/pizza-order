<?php include('partials/menu.php')?>

<div class='main-content'>
    <div class='wrapper'>
    <h1>Manage Food</h1>
    <br>
        <!-- button to add admin-->
        <a href='<?php echo SITEURL; ?>admin/add-food.php' class='btn-primary'>Add Food</a>
        <br><br>

        <?php

        if(isset($_SESSION['add']))
        {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if(isset($_SESSION['delete']))
        {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }

        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }

        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }

        if(isset($_SESSION['unauthorized']))
        {
            echo $_SESSION['unauthorized'];
            unset($_SESSION['unauthorized']);
        }

        if(isset($_SESSION['update']))
        {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }

        ?>

        <table class='tbl-full'>
            <tr>
                <th>Sr.No.</th>
                <th>Title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php

            //make sql query to get all the food
            $sql = "SELECT * FROM tbl_food";

            //execute
            $res = mysqli_query($conn, $sql);

            //count to check if we have food in database or not
            $count = mysqli_num_rows($res);

            //serial number variable
            $sn=1;

            if($count>0)
            {
                //food in database
                //get details from database
                while($row=mysqli_fetch_assoc($res))
                {
                    //get value from individual coloumns
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $image_name = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                    ?>

                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $title; ?></td>
                        <td><?php echo $price; ?></td>
                        <td>
                            <?php

                            //check if image is there or not
                            if($image_name=="")
                            {
                                //no image, error
                                echo "No Image";
                            }
                            else
                            {
                                //image available, display image
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" width="100px">
                                <?php
                            }
                            
                            ?>
                        </td>
                        <td><?php echo $featured; ?></td>
                        <td><?php echo $active; ?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>" class='btn-secondary'>Update Food</a>
                            <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Food</a>
                        </td>
                    </tr>

                    <?php
                }
            }
            else
            {
                //food not added
                echo "<tr><td colspan='7'>Food not Added Yet. </td></tr>";
            }
            
            ?>
            
        </table>
</div>
</div>

<?php include('partials/footer.php')?>