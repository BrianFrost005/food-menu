<?php 
    include('../config/constants.php');

    //destroy session
    session_destroy(); //unset 'user' session

    //redirect to login
    header('location:'.HOMEURL.'admin/login.php');
?>