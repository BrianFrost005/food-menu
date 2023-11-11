<?php

    include('../config/constants.php');

    //check if id and image_name have values
    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //delete
        //get id and image_name
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //remove image if available
        if($image_name != "")
        {
            //remove
            //get path
            $path = "../images/food/".$image_name;

            //remove image from folder
            $remove = unlink($path);

            //check removal
            if($remove==false)
            {
                //remove failed
                $_SESSION['upload'] = "<div class='error'>Failed to remove image.</div>";
                //redirect
                header('location:'.HOMEURL.'admin/manage-food.php');
                //stop process
                die();
            }
        }

        //delete from database
        //create query
        $sql = "DELETE FROM table_food WHERE id=$id";

        //execute query
        $res = mysqli_query($conn, $sql);

        //check execution
        if($res==TRUE)
        {
            //delete success
            $_SESSION['delete'] = "<div class='success'>Food deleted successfully.</div>";
            //redirect
            header('location:'.HOMEURL.'admin/manage-food.php');
        }
        else
        {
            //delete failed
            $_SESSION['delete'] = "<div class='error'>Failed to delete food.</div>";
            //redirect
            header('location:'.HOMEURL.'admin/manage-food.php');
        }

    }
    else
    {
        //redirect manage-food
        $_SESSION['unauthorized'] = "<div class='error'>Unauthorized access.</div>";
        header('location:'.HOMEURL.'admin/manage-food.php');
    }

?>