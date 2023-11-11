<?php 
    //authorization, access control
    //check if user logged in
    if(!isset($_SESSION['user'])) //if 'user' not set
    {
        //not logged in
        $_SESSION['not-logged-in'] = "<div class='error text-center'>Please login to access Admin page.</div>";
        //redirect to login page
        header('location:'.HOMEURL.'admin/login.php');

    }
?>