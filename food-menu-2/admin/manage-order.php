<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage order</h1>
        <br/><br/>

        <!-- session variables -->
        <?php
            //message shown when update order
            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
        ?>

        <br/><br/>
        <table class="tbl-full">

            <tr>
                <th>No.</th>
                <th>Food</th>
                <th>Price</th>
                <th>Qty.</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th>Actions</th>
            </tr>

            <?php
                //get all orders
                //create query
                $sql = "SELECT * FROM table_order ORDER BY id DESC"; //display latest order at top

                //execute query
                $res = mysqli_query($conn, $sql);

                //count rows
                $count = mysqli_num_rows($res);

                $sn = 1; //sn

                //check order availability
                if($count>0)
                {
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //available
                        $id = $row['id'];
                        $food = $row['food'];
                        $price = $row['price'];
                        $qty = $row['qty'];
                        $total = $row['total'];
                        $order_date = $row['order_date'];
                        $status = $row['status'];
                        $customer_name = $row['customer_name'];

                        ?>

                        <tr>
                            <td><?php echo $sn++; ?>.</td>
                            <td><?php echo $food; ?></td>
                            <td><?php echo $price; ?></td>
                            <td><?php echo $qty; ?></td>
                            <td><?php echo $total; ?></td>
                            <td><?php echo $order_date; ?></td>

                            <td>
                                <?php
                                    if($status=="Ordered")
                                    {
                                        echo "<label>$status</label>";
                                    }
                                    elseif($status=="Delivering")
                                    {
                                        echo "<label style='color: orange;'>$status</label>";
                                    }
                                    elseif($status=="Delivered")
                                    {
                                        echo "<label style='color: green;'>$status</label>";
                                    }
                                    elseif($status=="Cancelled")
                                    {
                                        echo "<label style='color: red;'>$status</label>";
                                    }
                                ?>
                            </td>

                            <td><?php echo $customer_name; ?></td>
                            <td>
                                <a href="<?php echo HOMEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-secondary">Update Order</a>
                            </td>
                        </tr>

                        <?php
                    }
                }
                else
                {
                    //not available
                    echo "<tr colspan='12' class='error'>Orders not found.</tr>";
                }
            ?>
            
        </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>