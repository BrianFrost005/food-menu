<?php include('partials/menu.php')?>

        <!-- Main content start -->
        <div class="main-content">
            <div class="wrapper">
                <h1>DASHBOARD</h1>
                <br><br>

                <!-- session variable -->
                <?php
                    //message shown when login success 
                    if(isset($_SESSION['login']))
                    {
                        echo $_SESSION['login'];
                        unset($_SESSION['login']);
                    }
                ?>

                <br><br>
                <div class="col-4 text-center">
                    <!-- display no. of categories -->
                    <?php
                        //create query
                        $sql = "SELECT * FROM table_category";
                        //execute query
                        $res = mysqli_query($conn, $sql);
                        //count rows
                        $count = mysqli_num_rows($res);
                    ?>
                    <h1><?php echo $count; ?></h1>
                    <br/>
                    Categories
                </div>

                <div class="col-4 text-center">
                    <!-- display no. of food -->
                    <?php
                        //create query
                        $sql2 = "SELECT * FROM table_food";
                        //execute query
                        $res2 = mysqli_query($conn, $sql2);
                        //count rows
                        $count2 = mysqli_num_rows($res2);
                    ?>
                    <h1><?php echo $count2; ?></h1>
                    <br/>
                    Food
                </div>

                <div class="col-4 text-center">
                    <!-- display no. of orders -->
                    <?php
                        //create query
                        $sql3 = "SELECT * FROM table_order";
                        //execute query
                        $res3 = mysqli_query($conn, $sql3);
                        //count rows
                        $count3 = mysqli_num_rows($res3);
                    ?>
                    <h1><?php echo $count3; ?></h1>
                    <br/>
                    Total Order
                </div>

                <div class="col-4 text-center">
                    <!-- display total revenue -->
                    <?php
                        //create query
                        $sql4 = "SELECT SUM(total) AS Total FROM table_order WHERE status='Delivered'";
                        //execute query
                        $res4 = mysqli_query($conn, $sql4);
                        //get value
                        $row = mysqli_fetch_assoc($res4);
                        //get total
                        $total_revenue = $row['Total'];
                    ?>
                    <h1><?php echo $total_revenue; ?></h1>
                    <br/>
                    Revenue
                </div>
                
                <div class="clearfix"></div>

            </div>
        </div>
        <!-- Main content end -->

<?php include('partials/footer.php')?>