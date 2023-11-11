<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br><br>

        <!-- session variable -->
        <!-- message shown when admin add failed -->
        <?php 
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add']; //display message
                unset($_SESSION['add']); //reset session
            }
        ?>

        <form action="" method="POST">

        <table class="tbl-30">
            <tr>
                <td>Full Name: </td>
                <td>
                    <input type="text" name="full_name" placeholder="Enter name">
                </td>
            </tr>

            <tr>
                <td>Username: </td>
                <td>
                    <input type="text" name="username" placeholder="enter username">
                </td>
            </tr>

            <tr>
                <td>Password: </td>
                <td>
                    <input type="password" name="password" placeholder="enter password">
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                </td>
            </tr>

        </table>

        </form>
    </div>
</div>

<?php include('partials/footer.php'); ?>

<?php 

    //save new admin info into database

    //if button is clicked
    if(isset($_POST['submit']))
    {
        //prevent injection mysqli_real_escape_string()
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password'])); // md5 one way encryption
    

        //create sql query 
        $sql = "INSERT INTO table_admin SET
            full_name = '$full_name',
            username = '$username',
            password = '$password'
        ";

         //connect to sql and pass in $ql, if error die()
         $res = mysqli_query($conn, $sql) or die(mysqli_error());

         //check wether successfully added or not and give message
         if($res==TRUE)
         {
            //data inserted
            //create session variable to display message
            $_SESSION['add'] = "Admin added successfully";
            //redirect page
            header("location:".HOMEURL.'admin/manage-admin.php');
         }
         else
         {
            //failed
            //create session variable to display message
            $_SESSION['add'] = "Failed to add admin";
            //redirect page
            header("location:".HOMEURL.'admin/add-admin.php');
         }
    }   

?>