<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>

        <!-- session variable -->
        <?php 
            //message shown when upload failed
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <br><br>
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">

                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Food title">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Food description."></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>

                <tr>
                    <td>Select image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">

                            <?php
                                //display categories from database
                                //create query
                                $sql = "SELECT * FROM table_category WHERE active='Yes'";

                                //execute query
                                $res = mysqli_query($conn, $sql);

                                //get no. rows
                                $count = mysqli_num_rows($res);

                                
                                //if have categories
                                if($count>0)
                                {
                                    while($row=mysqli_fetch_assoc($res))
                                    { 
                                        //categories found
                                        $id = $row['id'];
                                        $title = $row['title'];

                                        ?>

                                        <!-- display dropdown -->
                                        <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                        
                                        <?php
                                    }
                                }
                                else
                                {
                                    //no categories found
                                    ?>
                                    <option value="0">No category found</option>
                                    <?php
                                }
                            ?>
                            
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspn="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        <?php
        
            //button listener
            if(isset($_POST['submit']))
            {
                //add food to database
                //get values
                //prevent injection mysqli_real_escape_string()
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                $description = mysqli_real_escape_string($conn, $_POST['description']);
                $price = mysqli_real_escape_string($conn, $_POST['price']);
                $category = $_POST['category'];

                //check if featured selected
                if(isset($_POST['featured']))
                {
                    //features
                    $featured = $_POST['featured'];
                }
                else
                {
                    //default value
                    $featured = "No";
                }

                //check if active selected
                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No";
                }

                //upload image if selected
                //check if select image is clicked
                if(isset($_FILES['image']['name']))
                {
                    //image details
                    //prevent injection mysqli_real_escape_string
                    $image_name = mysqli_real_escape_string($conn, $_FILES['image']['name']);

                    //check if image is selected
                    if($image_name != "")
                    {
                        //image selected
                        //rename image
                        $exploded_image_name = explode('.', $image_name); //break image name at '.'
                        $ext = end($exploded_image_name); //get extension .png

                        //rename
                        $image_name = "Food-Name-".rand(0000,9999).".".$ext; // "Food-Name-3577.png"

                        //upload
                        //get source path
                        $src = $_FILES['image']['tmp_name'];

                        //destination path
                        $dst = "../images/food/".$image_name;

                        //upload
                        $upload = move_uploaded_file($src, $dst);

                        //check upload
                        if($upload==false)
                        {
                            //failed
                            $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                            //redirect
                            header('location:'.HOMEURL.'admin/add-food.php');
                            //stop process
                            die();
                        }
                    }
                }
                else
                {
                    //default value
                    $image_name = "";
                }

                //insert to database
                //create query
                $sql2 = "INSERT INTO table_food SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = $category,
                    featured = '$featured',
                    active = 'active'
                ";

                //execute query
                $res = mysqli_query($conn, $sql2);

                //check execution
                if($res==TRUE)
                {
                    //insert success
                    $_SESSION['add'] = "<div class='success'>Food added successfully.</div>";
                    //redirect
                    header('location:'.HOMEURL.'admin/manage-food.php');
                }
                else
                {
                    //insert failed
                    $_SESSION['add'] = "<div class='error'>Failed to add food.</div>";
                    //redirect
                    header('location:'.HOMEURL.'admin/manage-food.php');
                }
            }

        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>