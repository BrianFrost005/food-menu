<?php include('partials-front/menu.php') ?>

<?php
    //check if 'id' has value
    if(isset($_GET['category_id']))
    {
        //get id
        $category_id = $_GET['category_id'];
        //get category title based on id
        //create query
        $sql = "SELECT title FROM table_category WHERE id=$category_id";

        //execute query
        $res = mysqli_query($conn, $sql);

        //get row
        $row = mysqli_fetch_assoc($res);
        //get title
        $category_title = $row['title'];
    }
    else
    {
        //no id set
        //redirect
        header('location:'.HOMEURL);
    }
?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2>Foods on <a href="#" class="text-white">"<?php echo $category_title; ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php

                //get food based on category_id
                //create query
                $sql2 = "SELECT * FROM table_food WHERE category_id=$category_id";

                //execute query
                $res2 = mysqli_query($conn, $sql2);

                //count rows
                $count2 = mysqli_num_rows($res2);

                //check food availability
                if($count2>0)
                {
                    //available
                    while($row2=mysqli_fetch_assoc($res2))
                    {
                        //get values
                        $id = $row2['id'];
                        $title = $row2['title'];
                        $price = $row2['price'];
                        $description = $row2['description'];
                        $image_name = $row2['image_name'];

                        //display
                        ?>

                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php
                                    //check image availablility
                                    if($image_name=="")
                                    {
                                        //unavailable
                                        echo "<div class='error'>Image unavialable.</div>";
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
                    //not availble
                    echo "<div class='error'>Food not found.</div>";
                }

            ?>

            <div class="clearfix"></div>

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php') ?>