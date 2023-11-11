<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Category</h1>
        <br><br>

        <!-- session variables -->
        <?php

            //message shown when add category successful
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            //message shown when remove image failed
            if(isset($_SESSION['remove']))
            {
                echo $_SESSION['remove'];
                unset($_SESSION['remove']);
            }

            //message shown when remove category
            if(isset($_SESSION['delete']))
            {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }

            //message shown when category not found
            if(isset($_SESSION['no-category-found']))
            {
                echo $_SESSION['no-category-found'];
                unset($_SESSION['no-category-found']);
            }

             //message shown when update category
             if(isset($_SESSION['update']))
             {
                 echo $_SESSION['update'];
                 unset($_SESSION['update']);
             }

             //message shown when update category image failed
             if(isset($_SESSION['upload']))
             {
                 echo $_SESSION['upload'];
                 unset($_SESSION['upload']);
             }

             //message shown when failed to remove image
             if(isset($_SESSION['failed-remove']))
             {
                 echo $_SESSION['failed-remove'];
                 unset($_SESSION['failed-remove']);
             }

        ?>

        <br/><br/>
        <!-- Button add category -->
        <a href="add-category.php" class="btn-primary">Add Category</a>

        <br/><br/>
        <table class="tbl-full">
            <tr>
                <th>No.</th>
                <th>Title</th>
                <th>Image</th>
                <th>Feature</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php

                //fetch all categories from database
                $sql = "SELECT * FROM table_category";

                //execute query
                $res = mysqli_query($conn, $sql);

                //create id variable
                //use this id instead of database
                $sn = 1;

                //get no. of rows
                $count = mysqli_num_rows($res);

                //check data availability
                if($count>0)
                {
                    //display data
                    while($row=mysqli_fetch_assoc($res))
                    {
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];

                        ?>
                        
                        <!-- category row start -->
                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $title; ?></td>

                            <td>
                                <?php 
                                    //check if name available
                                    if($image_name!="")
                                    {
                                        //display image
                                        ?>

                                        <img src="<?php echo HOMEURL; ?>images/category/<?php echo $image_name;?>" width="100px">
                                        
                                        <?php
                                    }
                                    else
                                    {
                                        //display message
                                        echo "<div class='error'>Image not found.</div>";
                                    }
                                ?>
                            </td>

                            <td><?php echo $featured; ?></td>
                            <td><?php echo $active; ?></td>
                            <td>
                                <a href="<?php echo HOMEURL; ?>admin/update-category.php?id=<?php echo $id; ?>" class="btn-secondary">Update Category</a>
                                <a href="<?php echo HOMEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-warning">Delete Category</a>
                            </td>
                        </tr>
                        <!-- category row end -->

                        <?php
                    }
                }
                else
                {
                    //data unavailable
                    ?>

                    <tr>
                        <td colspan="6"><div class="error">No categories found.</div></td>
                    </tr>
                    
                    <?php
                }
            
            ?>

        </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>