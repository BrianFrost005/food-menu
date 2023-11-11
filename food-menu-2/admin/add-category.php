<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br><br>

        <!-- session variables -->
        <?php

            //message shown when add category failed
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            //message shown when file upload failed
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>
        
        <br><br>
        <!-- add category start -->
        <form action="" method="POST" enctype="multipart/form-data"> <!-- enctype allow upload file -->

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="category title">
                    </td>
                </tr>

                <tr>
                    <td>Select image: </td>
                    <td>
                        <input type="file" name="image">
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
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
        <!-- add category end -->

        <?php

            //button listener
            if(isset($_POST['submit']))
            {
                //get values from form
                //prevent injection mysqli_real_escape_string
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                
                //radio input
                //check if choice is made
                //featured
                if(isset($_POST['featured']))
                {
                    //get value
                    $featured = $_POST['featured'];
                }
                else
                {
                    // set default value
                    $featured = "No";
                }

                //active
                if(isset($_POST['active']))
                {
                    //get value
                    $active = $_POST['active'];
                }
                else
                {
                    //set default value
                    $active = "No";
                }

                //check if image is selected
                //print file name
                //print_r($_FILES['image']);
                //die();//break the code

                if(isset($_FILES['image']['name']))
                {
                    //upload image
                    //need image name, source path and destination path
                    //prevent injection mysqli_real_escape_string()
                    $image_name = mysqli_real_escape_string($conn, $_FILES['image']['name']);

                    //check if image is selected
                    if($image_name != "")
                    {
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
                            header('location:'.HOMEURL.'admin/add-category.php');
                            //stop upload process, prevent insert to database
                            die();
                        }
                    }
                }
                else
                {
                    //dont upload
                    //set image_name as blank
                    $image_name="";
                }

                //create query
                $sql = "INSERT INTO table_category SET 
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'
                ";

                //execute query
                $res = mysqli_query($conn, $sql);

                //check execution
                if($res==TRUE)
                {
                    //add successful
                    $_SESSION['add'] = "<div class='success'>Category added successfully.</div>";
                    //redirect
                    header('location:'.HOMEURL.'admin/manage-category.php');
                }
                else
                {
                    //failed to add
                    $_SESSION['add'] = "<div class='error'>Failed to add category.</div>";
                    //redirect
                    header('location:'.HOMEURL.'admin/manage-category.php');
                }
            }

        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>