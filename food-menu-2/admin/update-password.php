<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <!-- get id -->
        <?php
            if(isset($_GET['id']))
            {
                $id=$_GET['id'];
            }
        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type="password" name="current_password" placeholder="current password">
                    </td>
                </tr>

                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type="password" name="new_password" placeholder="new password">
                    </td>
                </tr>

                <tr>
                    <td>Confirm Password: </td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="confirm password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

    </div>
</div>

<?php

    //check if button clicked
    if(isset($_POST['submit']))
    {
        //get data from form
        $id = $_POST['id'];
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);

        //create query
        //check if theres row with the id and current password
        $sql = "SELECT * FROM table_admin WHERE id=$id AND password='$current_password'";

        //execute query
        $res = mysqli_query($conn, $sql);

        //check execution
        if($res==TRUE)
        {
            //check data availability
            $count=mysqli_num_rows($res);

            if($count==1)
            {
                //change password
                //check new and confirm password matching
                if($new_password==$confirm_password)
                {
                    //update password
                    //create query
                    $sql2 = "UPDATE table_admin SET
                        password='$new_password'
                        WHERE id=$id
                        ";
                    
                    //execute query
                    $res2 = mysqli_query($conn, $sql2);

                    //check execution
                    if($res2==TRUE)
                    {
                        //update success
                        $_SESSION['change-password'] = "<div class='success'>Password changed Successfully.</div>";
                        //redirect
                        header('location:'.HOMEURL.'admin/manage-admin.php');
                    }
                    else
                    {
                        //update failed
                        $_SESSION['change-password'] = "<div class='error'>FAILED to change password.</div>";
                        //redirect
                        header('location:'.HOMEURL.'admin/manage-admin.php');
                    }
                }
                else
                {
                    //not match
                    $_SESSION['password-not-match'] = "<div class='error'>Password NOT match.</div>";
                    //redirect
                    header('location:'.HOMEURL.'admin/manage-admin.php');
                }
            }
            else
            {
                //admin not found
                $_SESSION['user-not-found'] = "<div class='error'>User NOT Found. </div>";
                //redirect
                header('location:'.HOMEURL."admin/manage-admin.php");
            }
        }
       
    }

?>

<?php include('partials/footer.php'); ?>