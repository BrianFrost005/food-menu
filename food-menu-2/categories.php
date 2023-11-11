<?php include('partials-front/menu.php') ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php
            
                //display all active categories
                //create query
                $sql = "SELECT * FROM table_category WHERE active='Yes'";

                //execute query
                $res = mysqli_query($conn, $sql);

                //count rows
                $count = mysqli_num_rows($res);

                //check availability
                if($count>0)
                {
                    //available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //get values
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>
                        
                        <a href="<?php echo HOMEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                            <div class="box-3 float-container">
                                <?php
                                    //check image value
                                    if($image_name=="")
                                    {
                                        //no image
                                        echo "<div class'error'>Image not found.</div>";
                                    }
                                    else
                                    {
                                        //has image
                                        ?>
                                        <img src="<?php echo HOMEURL; ?>images/category/<?php echo $image_name; ?>" class="img-responsive img-curve">
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
                    //not available
                    echo "<div class='error'>Categories not found.</div>";
                }
            ?>
      
            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

<?php include('partials-front/footer.php') ?>