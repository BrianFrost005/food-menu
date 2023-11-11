<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>

        <?php
            //check if id has value
            if(isset($_GET['id']))
            {
                //get id
                $id = $_GET['id'];
                //create query
                $sql = "SELECT * FROM table_category WHERE id=$id";

                //execute query
                $res = mysqli_query($conn, $sql);

                //check rows
                $count = mysqli_num_rows($res);
                if($count==1)
                {
                    //get all data
                    $row = mysqli_fetch_assoc($res);

                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                }
                else
                {
                    //redirect
                    $_SESSION['no-category-found'] = "<div class='error'>Category not found.</div>";
                    header('location:'.HOMEURL.'admin/manage-category.php');
                }
            }
            else
            {
                //redirect
                header('location:'.HOMEURL.'admin/manage-category.php');
            }
        ?>

        <!-- update-category start -->
        <form action="" method="POST" enctype="multipart/form-data"> 

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                            if($current_image != "")
                            {
                                //display image
                                ?>

                                <img src="<?php echo HOMEURL;?>images/category/<?php echo $current_image; ?>" width="100px">

                                <?php
                            }
                            else
                            {
                                //display message
                                echo "<div class='error'>Image not found</div>";
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <!-- pre check according to $featured -->
                        <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
        <!-- update-category end -->

        <?php
            //button listener
            if(isset($_POST['submit']))
            {
                //get values from form
                $id = $_POST['id'];
                //prevent injection mysqli_real_escape_string()
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                $current_image = mysqli_real_escape_string($conn, $_POST['current_image']);
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                echo $featured;
                echo $active;
                //update new image if selected    
                if(isset($_FILES['image']['name']))
                {
                    //get image details
                    //prevent injection mysqli_real_escape_string()
                    $image_name = mysqli_real_escape_string($conn, $_FILES['image']['name']);

                    //when files browsed but image not selected 
                    //check image availbility
                    if($image_name != "")
                    {
                        //image available
                        //upload image
                        //rename image
                        //get extension of the image
                        $exploded_image_name = explode('.', $image_name); //break image name at '.'
                        $ext = end($exploded_image_name); //get extension

                        //rename
                        $image_name = "Food_Category_".rand(000, 999).'.'.$ext; // e.g. food_category_385.png
                        $source_path = $_FILES['image']['tmp_name'];
                        $destination_path = "../images/category/".$image_name;

                        //upload to folder
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //check upload
                        if($upload==false)
                        {
                            //set message
                            $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                            //redirect
                            header('location:'.HOMEURL.'admin/manage-category.php');
                            //stop upload process, prevent insert to database
                            die();
                        }

                        //remove current image if available
                        if($current_image != "")
                        {
                            $remove_path = "../images/category/".$current_image;
                            $remove = unlink($remove_path);
    
                            //check removal
                            if($remove==false)
                            {
                                //failed
                                $_SESSION['failed-remove'] = "<div class='error'>Failed to remove image.</div>";
                                //redirect
                                header('location:'.HOMEURL.'admin/manage-category.php');
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
                
                //update database
                $sql2 = "UPDATE table_category SET
                    title = '$title',
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active'
                    WHERE id=$id
                ";

                //execute query
                $res2 = mysqli_query($conn, $sql2);

                //check execution
                if($res2==TRUE)
                {
                    //update success
                    $_SESSION['update'] = "<div class='success'>Category updated successfully.</div>";
                    //redirect
                    header('location:'.HOMEURL.'admin/manage-category.php');
                }
                else
                {
                    //failed to update
                    $_SESSION['update'] = "<div class='success'>Failed to update category.</div>";
                    //redirect
                    header('location:'.HOMEURL.'admin/manage-category.php');
                }

            }

        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>