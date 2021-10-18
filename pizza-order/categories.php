<?php include('partials-front/menu.php'); ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php 

            //display all categories that are active
            //sql query
            $sql = "SELECT * FROM tbl_categories WHERE active='Yes'";

            //execute query
            $res = mysqli_query($conn, $sql);

            //count rows
            $count = mysqli_num_rows($res);

            //check if category is available or not
            if($count>0)
            {
                //category available
                while($row=mysqli_fetch_assoc($res))
                {
                    //get details
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
                    ?>
                    
                    <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                        <div class="box-3 float-container">
                            <?php

                            if($image_name=="")
                            {
                                //image unavailable
                                echo "Image Unavailable.";
                            }
                            else
                            {
                                //available image
                                ?>
                                
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">

                                <?php
                            }
                            
                            ?>
                            
                            <h3 class="float-text text-white"><?php echo $title; ?></h3>
                        </div>
                    </a>

                    <?php
                }
            }
            else
            {
                //category unavailable
                echo "Category Unavailable.";
            }
            
            ?>        

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->


    <?php include('partials-front/footer.php'); ?>