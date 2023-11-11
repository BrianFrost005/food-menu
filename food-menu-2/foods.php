<?php include('partials-front/menu.php') ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo HOMEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
            
                //display food from database
                //create query
                $sql = "SELECT * FROM table_food WHERE active='Yes'";

                //execute query
                $res = mysqli_query($conn, $sql);

                //get row count
                $count = mysqli_num_rows($res);

                //check foood availablility
                if($count>0)
                {
                    //has food
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //get values
                        $id = $row['id'];
                        $title = $row['title'];
                        $description = $row['description'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];

                        //display
                        ?>

                        <div class="food-menu-box">
                            <div class="food-menu-img">

                                <?php
                                    //check image availability
                                    if($image_name=="")
                                    {
                                        //not available
                                        echo "<div class='error'>Image not available.</div>";
                                    }
                                    else
                                    {
                                        //available

                                        ?>

                                        <img src="<?php echo HOMEURL; ?>images/food/<?php echo $image_name; ?>" class="img-responsive img-curve">
                                        
                                        <?php

                                    }
                                ?> 

                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title; ?></h4>
                                <p class="food-price">RM<?php echo $price; ?></p>
                                <p class="food-detail">
                                    <?php echo $description; ?>
                                </p>
                                <br>

                                <a href="<?php echo HOMEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>

                        <?php
                    }
                }
                else
                {
                    //no food
                    echo "<div class='error'>No food found.</div>";
                }
            
            ?>

            


            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php') ?>