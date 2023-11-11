<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Food</h1>
        <br/><br/>

        <!-- session variable -->
        <?php
            //message shown when add food
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            //message shown when unauthorized access to delete
            if(isset($_SESSION['unauthorized']))
            {
                echo $_SESSION['unauthorized'];
                unset($_SESSION['unauthorized']);
            }

            //message shown when delete food image
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }

            //message shown when delete food
            if(isset($_SESSION['delete']))
            {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }

            //message shown when update food
            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
        ?>

        <br><br>
        <!-- Button add add -->
        <a href="<?php echo HOMEURL; ?>admin/add-food.php" class="btn-primary">Add Food</a>

        <br/><br/>
        <table class="tbl-full">
            <tr>
                <th>No.</th>
                <th>Title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Category id</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php
                //fetch all food from datanase
                //create query
                $sql = "SELECT * FROM table_food";

                //execute query
                $res = mysqli_query($conn, $sql);

                //get rows
                $count = mysqli_num_rows($res);

                //sn
                $sn = 1; 

                //check rows
                if($count>0)
                {
                    //food found
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //get value
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        $category_id = $row['category_id'];
                        $featured = $row['featured'];
                        $active = $row['active'];
                        ?>
                        
                        <tr>
                            <td><?php echo $sn++ ?></td>
                            <td><?php echo $title; ?></td>
                            <td><?php echo $price; ?></td>
                            <td>
                                <?php 
                                    //check image
                                    if($image_name=="")
                                    {
                                        //no image
                                        echo "<div classw='error'>Imge not added.</div>";
                                    }
                                    else
                                    {
                                        //display image
                                        ?>
                                        
                                        <img src="<?php echo HOMEURL; ?>images/food/<?php echo $image_name; ?>" width="100px">

                                        <?php
                                    }
                                ?>
                            </td>
                            <td><?php echo $category_id; ?></td>
                            <td><?php echo $featured; ?></td>
                            <td><?php echo $active; ?></td>
                            <td>
                                <a href="<?php echo HOMEURL; ?>admin/update-food.php?id=<?php echo $id; ?>" class="btn-secondary">Update Food</a>
                                <a href="<?php echo HOMEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-warning">Delete Food</a>
                            </td>
                        </tr>

                        <?php
                    }
                }
                else
                {
                    //no food found
                    echo "<tr> <td colspan='7' class='error'>No food found. </td> </tr>";
                }
            ?>

        </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>