<?php
    //include constants for sql connection
    include('../config/constants.php');

    //get id
    $id = $_GET['id'];

    //get rows
    //create query
    $sql2 = "SELECT * FROM table_admin";
    //execute query
    $res2 = mysqli_query($conn, $sql2);
    //check if 1 admin
    $count = mysqli_num_rows($res2);
    if($count==1)
    {
        $_SESSION['delete'] = "<div class='error'>Cannot delete if only one admin exist.</div>";
        //redirect
        header('location:'.HOMEURL.'admin/manage-admin.php');
    }
    else
    {
        //delete
        //create sql query
        $sql = "DELETE FROM table_admin WHERE id=$id";
        //execute query
        $res = mysqli_query($conn, $sql);
        //check query execution
        if($res==TRUE)
        {
            //delete success
            $_SESSION['delete'] = "<div class='success'>Admin deleted successfully</div>";
            //redirect page
            header('location:'.HOMEURL.'admin/manage-admin.php');
        }
        else
        {
            //delete failed
            $_SESSION['delete'] = "<div class='error'>Failed to delete admin</div>";
            header('location:'.HOMEURL.'admin/manage-admin.php');
        }
    }

?>