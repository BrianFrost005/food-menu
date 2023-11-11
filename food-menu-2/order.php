<?php include('partials-front/menu.php') ?>

<?php
    //check if food_id has value
    if(isset($_GET['food_id']))
    {
        //get values
        $food_id = $_GET['food_id'];

        //get selected food details
        //create query
        $sql = "SELECT * FROM table_food WHERE id=$food_id";

        //execute query
        $res = mysqli_query($conn, $sql);

        //count rows
        $count = mysqli_num_rows($res);

        //check food availability
        if($count==1)
        {
            //food found
            $row = mysqli_fetch_assoc($res);
            //get data
            $title = $row['title'];
            $price = $row['price'];
            $image_name = $row['image_name'];


        }
        else
        {
            //failed
            //redirect
            header('location:'.HOMEURL);
        }
    }
    else
    {
        //redirect
        header('location:'.HOMEURL);
    }
?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                        <?php 
                        
                            //check image availablility
                            if($image_name=="")
                            {
                                //not available
                                echo "<div class='error'>Image not available.</div>";
                            }
                            else
                            {
                                //available
                                //display
                                ?>
                                <img src="<?php echo HOMEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                <?php
                            }

                        ?>
                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="food" value="<?php echo $title; ?>">

                        <p class="food-price">RM<?php echo $price; ?></p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. John Wake" class="input-responsive" required>


                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>

            <?php
            
                //button listener
                if(isset($_POST['submit']))
                {
                    //get form values
                    $food = $_POST['food'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];

                    $total = $price * $qty;

                    $order_date = date("Y-m-d h:i:sa"); //date 

                    $status = "Ordered"; //ordered, delivering, delivered, cancelled

                    $customer_name = $_POST['full-name'];

                    //insert to database
                    //create query
                    $sql2 = "INSERT INTO table_order SET
                        food = '$food',
                        price = $price,
                        qty = $qty,
                        total = $total,
                        order_date = '$order_date',
                        status = '$status',
                        customer_name = '$customer_name' 
                    ";

                    //execute query
                    $res2 = mysqli_query($conn, $sql2);

                    //check execution
                    if($res==true)
                    {
                        //success
                        $_SESSION['order'] = "<div class='success text-center'>Food ordered successfully.</div>";
                        //redirect
                        header('location:'.HOMEURL);
                    }
                    else
                    {
                        //failed
                        $_SESSION['order'] = "<div class='error text-center'>Failed to order.</div>";
                        //redirect
                        header('location:'.HOMEURL);
                    }
                }
            
            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <?php include('partials-front/footer.php') ?>