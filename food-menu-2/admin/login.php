<?php include('../config/constants.php'); ?>

<html>
    <head>
        <title>Login - Menu</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body>
        
        <div class="login">
            <h1 class="text-center">Login</h1>
            <br><br>

            <!-- session variable -->
            <?php 
                //message shown when login success 
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }

                //message shown when not logged in
                if(isset($_SESSION['not-logged-in']))
                {
                    echo $_SESSION['not-logged-in'];
                    unset($_SESSION['not-logged-in']);
                }
            ?>

            <br><br>
            <!-- Login form start -->
            <form action="" method="POST" class="text-center">
                Username:
                <br>
                <input type="text" name="username" placeholder="enter username">
                <br><br>
                Password:
                <br>
                <input type="password" name="password" placeholder="enter password">
                <br><br>
                <input type="submit" name="submit" value="login" class="btn-primary">
            </form>
            <!-- Login form end -->
        </div>

    </body>
</html>

<?php 

    //button listener
    if(isset($_POST['submit']))
    {
        //get data from form
        //prevent injection mysqli_real_escape_string()
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));

        //check if user and pass exist
        //create query
        $sql = "SELECT * FROM table_admin WHERE username='$username' AND password='$password'";

        //execute query
        $res = mysqli_query($conn, $sql);

        //check execution
        $count = mysqli_num_rows($res);

        //check if existing
        if($count==1)
        {
            //user available
            $_SESSION['login'] = "<div class='success'>Login successful.</div>";
            //redirect to home
            header('location:'.HOMEURL.'admin/');

            //CREATE SESSION
            $_SESSION['user'] = $username;
        }
        else
        {
            //user unavailable
            $_SESSION['login'] = "<div class='error text-center'>Username or password did NOT match.</div>";
            //redirect to home
            header('location:'.HOMEURL.'admin/login.php');
        }

    }

?>

<?php include('partials/footer.php') ?>