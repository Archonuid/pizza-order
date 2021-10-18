<?php include('partials/menu.php')?>

    <!--Main content section starts-->
<div class="main-content">
    <div class="wrapper">
        <h1>DASHBOARD</h1>
        <br><br>

        <?php
        if(isset($_SESSION['login']))
        {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }
        ?>
        <br><br>

        <div class="col-4 text-center">
            <?php
            $sql = "SELECT * FROM tbl_categories";
            //execute
            $res = mysqli_query($conn, $sql);
            //count
            $count = mysqli_num_rows($res);
            ?>
            <h1><?php echo $count; ?></h1><br>
            Categories
        </div>

        <div class="col-4">
            <?php
            $sql2 = "SELECT * FROM tbl_food";
            //execute
            $res2 = mysqli_query($conn, $sql2);
            //count
            $count2 = mysqli_num_rows($res2);
            ?>
            <h1><?php echo $count2; ?></h1><br>
            Foods
        </div>

        <div class="col-4">
            <?php
            $sql3 = "SELECT * FROM tbl_order";
            //execute
            $res3 = mysqli_query($conn, $sql3);
            //count
            $count3 = mysqli_num_rows($res3);
            ?>
            <h1><?php echo $count3; ?></h1><br>
            Total Orders
        </div>

        <div class="col-4">
            <?php

            //create sql query to get total revenue
            //aggregate function in sql
            $sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status='Delivered'";
            $res4 = mysqli_query($conn, $sql4);
            $row4 = mysqli_fetch_assoc($res4);
            //get total revenue
            $total_revenue = $row4['Total'];

            ?>
            <h1>$<?php echo $total_revenue; ?></h1>
            <br>
            Revenue Generated
        </div>
        <div class="clearfix"></div>
</div>
    <!--Main content section ends-->

  <?php include('partials/footer.php')?>