<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Order</h1>
        <br><br>

        <?php 
        
            //check if id has value
            if(isset($_GET['id']))
            {
                //get id
                $id = $_GET['id'];

                //get all orders
                //create query
                $sql = "SELECT * FROM table_order WHERE id=$id";

                //execute query
                $res = mysqli_query($conn, $sql);

                //count rows
                $count = mysqli_num_rows($res);

                //check data availability
                if($count==1)
                {
                    //available
                    $row=mysqli_fetch_assoc($res);

                    $food = $row['food'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $status = $row['status'];
                    $customer_name = $row['customer_name'];
                }
                else
                {
                    //not available
                    //redirect
                    header('locatin:'.HOMEURL.'admin/manage-order.php');
                }
            }
            else
            {
                //redirect
                header('location:'.HOMEURL.'admin/manage-order.php');
            }

        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Food Name:</td>
                    <td><b><?php echo $food; ?></b></td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td>RM<?php echo $price; ?></td>
                </tr>

                <tr>
                    <td>Qty:</td>
                    <td>
                        <input type="number"name="qty" value="<?php echo $qty; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Status:</td>
                    <td>
                        <select name="status">
                            <option <?php if($status=="Ordered"){echo "selected";} ?> value="Ordered">Ordered</option>
                            <option <?php if($status=="Delivering"){echo "selected";} ?> value="Delivering">Delivering</option>
                            <option <?php if($status=="Delivered"){echo "selected";} ?> value="Delivered">Delivered</option>
                            <option <?php if($status=="Cancelled"){echo "selected";} ?> value="Cancelled">Cancelled</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Customer Name:</td>
                    <td>
                        <input type="text" name="customer_name" value="<?php echo $customer_name; ?>">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name ="id" value="<?php echo $id; ?>">
                        <input type="hidden" name ="price" value="<?php echo $price; ?>">
                        <input type="submit" name="submit" value="Update Order" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        <?php
        
            //button listener
            if(isset($_POST['submit']))
            {
                //get values from form
                $id = $_POST['id'];
                $price = $_POST['price'];
                $qty = mysqli_real_escape_string($conn, $_POST['qty']);
                $total = $price * $qty;
                $status = $_POST['status'];
                $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);

                //update data
                //create query
                $sql2 = "UPDATE table_order SET
                    qty = $qty,
                    total = $total,
                    status = '$status',
                    customer_name = '$customer_name'
                    WHERE id=$id
                ";

                //execute query
                $res2 = mysqli_query($conn, $sql2);

                //check execution
                if($res==TRUE)
                {
                    //success
                    $_SESSION['update'] = "<div class='success'>Order updated successfully.</div>"; 
                    //redirect
                    header('location:'.HOMEURL.'admin/manage-order.php');
                }
                else
                {
                    //failed
                    $_SESSION['update'] = "<div class='error'>Failed to update order.</div>"; 
                    //redirect
                    header('location:'.HOMEURL.'admin/manage-order.php');
                }
                
            }

        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>