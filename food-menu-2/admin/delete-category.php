<?php

    include('../config/constants.php');

    //check if id and image_name have values
    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //delete based on values
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //remove image if available
        if($image_name != "")
        {
            //get path
            $path = "../images/category/".$image_name;
            //remove image
            $remove = unlink($path);

            //check removal
            if($remove==false)
            {
                //redirect
                $_SESSION['remove'] = "<div class='error'>Failed to remove image.</div>";
                header('location:'.HOMEURL.'admin/manage-category.php');
                //stop process
                die();
            }
        }

        //delete from database
        //create sql
        $sql = "DELETE FROM table_category WHERE id=$id";

        //execute query
        $res = mysqli_query($conn, $sql);

        //check execution
        if($res==TRUE)
        {
            //success
            $_SESSION['delete'] = "<div class='success'>Category deleted successfully.</div>";
            //redirect
            header('location:'.HOMEURL.'admin/manage-category.php');
        }
        else
        {
            //failed
            $_SESSION['delete'] = "<div class='error'>Failed to delete category.</div>";
            //redirect
            header('location:'.HOMEURL.'admin/manage-category.php');
        }
    }
    else
    {
        //redirect to manage-catagory
        header('location:'.HOMEURL.'admin/manage-category.php');
    }

?>