<?php include('partials/menu.php'); ?>

<?php
    //check if id has value
    if(isset($_GET['id']))
    {
        //get id
        $id = $_GET['id'];

        //get food based on id from database
        //create sql
        $sql2 = "SELECT * FROM table_food WHERE id='$id'";

        //execute query
        $res2 = mysqli_query($conn, $sql2);

        //get row from result
        $row2 = mysqli_fetch_assoc($res2);
        
        //get data from row
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];
    }
    else
    {
        //redirect manage-food
        header('location:'.HOMEURL.'admin/manage-food.phpw');
    }
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">

        <table class="tbl-30">

            <tr>
                <td>Title: </td>
                <td>
                    <input type="text" name="title" value="<?php echo $title; ?>">
                </td>
            </tr>

            <tr>
                <td>Description: </td>
                <td>
                    <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                </td>
            </tr>

            <tr>
                <td>Price: </td>
                <td>
                    <input type="number" name="price" value="<?php echo $price; ?>">
                </td>
            </tr>

            <tr>
                <td>Current Image: </td>
                <td>
                    <?php
                        //check if image available
                        if($current_image=="")
                        {
                            //not available
                            echo "<div class='error'>Image not available.</div>";
                        }
                        else
                        {
                            //available
                            ?>
                            
                            <img src="<?php echo HOMEURL; ?>images/food/<?php echo $current_image; ?>" width="100px">
                            
                            <?php
                        }
                    ?>
                </td>
            </tr>

            <tr>
                <td>Select New Image: </td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>

            <tr>
                <td>Category: </td>
                <td>
                    <select name="category">
                        
                        <?php
                            //get active category
                            //create query
                            $sql = "SELECT * FROM table_category WHERE active='Yes'";

                            //execute query
                            $res = mysqli_query($conn, $sql);
                            
                            //count rows
                            $count = mysqli_num_rows($res);

                            //check category availability
                            if($count>0)
                            {
                                //available
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    $category_title = $row['title'];
                                    $category_id = $row['id'];

                                    //echo "<option value='$category_id'>$category_title</option>"; | alt way to list out 

                                    ?>
                                    
                                    <option <?php if($current_category==$category_id){echo "selected";}?> value="<?php echo  $category_id; ?>"><?php echo $category_title ?></option>

                                    <?php
                                }
                            }
                            else
                            {
                                //unavailable
                                echo "<option value='0'>No category available.</option>";
                            }
                        ?>

                    </select>
                </td>
            </tr>

            <tr>
                <td>Featured: </td>
                <td>
                    <input <?php if($featured=="Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
                    <input <?php if($featured=="No") {echo "checked";} ?> type="radio" name="featured" value="No">No
                </td>
            </tr>

            <tr>
                <td>Active: </td>
                <td>
                    <input <?php if($featured=="Yes") {echo "checked";} ?> type="radio" name="active" value="Yes">Yes
                    <input <?php if($featured=="No") {echo "checked";} ?> type="radio" name="active" value="No">No
                </td>
            </tr>

            <tr>
                <td>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>"> <!-- for deletion -->
                    <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                </td>
            </tr>

        </table>

        </form>

        <?php
        
            //button listener
            if(isset($_POST['submit']))
            {
                //get details
                $id = $_POST['id'];
                //prevent injection mysqli_real_escape_string
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                $description = mysqli_real_escape_string($conn, $_POST['description']);
                $price = mysqli_real_escape_string($conn, $_POST['price']);
                $current_image = mysqli_real_escape_string($conn, $_POST['current_image']);
                $category = $_POST['category'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //upload image if selected
                //check if file was browsed
                if(isset($_FILES['image']['name']))
                {
                    //if upload button clicked 
                    //prevent injection mysqli_real_escape_string
                    $image_name = mysqli_real_escape_string($conn, $_FILES['image']['name']);

                    //check if new image selected
                    if($image_name != "")
                    {
                        //has image
                        //rename
                        $exploded_image_name = explode('.', $image_name); //break image name at '.'
                        $ext = end($exploded_image_name); //get extension

                        $image_name = "Food-Name-".rand(0000,9999).'.'.$ext; //Food-Name-577.png

                        //get source and destination path
                        $src_path = $_FILES['image']['tmp_name'];
                        $dest_path = "../images/food/".$image_name;

                        //upload image into folder
                        $upload = move_uploaded_file($src_path, $dest_path);

                        //check upload
                        if($upload==false)
                        {
                            //failed
                            $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                            //redirect
                            header('location:'.HOMEURL.'admin/manage-food.php');
                            //stop process
                            die();
                        }

                        //remove current image if present
                        if($current_image!="")
                        {
                            //remove image
                            $remove_path = "../images/food/".$current_image;
                            $remove = unlink($remove_path);

                            //check removal
                            if($remove==false)
                            {
                                //remove failed
                                $_SESSION['remove-failed'] = "<div class='error'>Failed to remove current image</div>";
                                //redirect
                                header('location:'.HOMEURL.'admin/manage-food.php');
                                //stop process
                                die();
                            }
                        }
                    }
                    else
                    {
                        $image_name = $current_image;
                    }
                }
                else
                {
                    $image_name = $current_image;
                }

                //insert to database
                //create query
                $sql3 = "UPDATE table_food SET
                    title = '$title',
                    description = '$description',
                    price = '$price',
                    image_name = '$image_name',
                    category_id = '$category',
                    featured = '$featured',
                    active = '$active'
                    WHERE id=$id
                ";

                //execute query
                $res3 = mysqli_query($conn, $sql3);

                //check execution
                if($res3==TRUE)
                {
                    //success
                    $_SESSION['update'] = "<div class='success'>Food updated successfully.</div>";
                    //redirect
                    header('location:'.HOMEURL.'admin/manage-food.php');
                }
                else
                {
                    //failed
                    $_SESSION['update'] = "<div class='error'>Failed to update food.</div>";
                    //redirect
                    header('location:'.HOMEURL.'admin/manage-food.php');
                }
            }

        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>