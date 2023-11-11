<?php include('partials/menu.php'); ?>

        <!-- Main content start -->
        <div class="main-content">
            <div class="wrapper">
                <h1>Manage Admin</h1>
                <br/><br/>

                <!-- session variable -->
                <?php 
                    //message shown when admin added
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add']; //display message
                        unset($_SESSION['add']); //reset session
                    }

                    //message shown when admin deleted
                    if(isset($_SESSION['delete']))
                    {
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }

                    //message shown when admin updated
                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }

                    //message shown when update password user not found
                    if(isset($_SESSION['user-not-found']))
                    {
                        echo $_SESSION['user-not-found'];
                        unset($_SESSION['user-not-found']);
                    }

                    //message shown when update password not match
                    if(isset($_SESSION['password-not-match']))
                    {
                        echo $_SESSION['password-not-match'];
                        unset($_SESSION['password-not-match']);
                    }

                    //message shown when update password
                    if(isset($_SESSION['change-password']))
                    {
                        echo $_SESSION['change-password'];
                        unset($_SESSION['change-password']);
                    }
                ?>

                <br/><br/>
                <!-- Button add admin -->
                <a href="add-admin.php" class="btn-primary">Add Admin</a>

                <br/><br/>
                <table class="tbl-full">
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                        //query to select all admin
                        $sql = "SELECT * FROM table_admin";
                        //execute query
                        $res = mysqli_query($conn, $sql);

                        //check if query executed
                        if($res==TRUE)
                        {
                            //count rows
                            $count = mysqli_num_rows($res); //functionn get all rows

                            //check no. rows
                            if($count>0)
                            {
                                //have data
                                while($rows=mysqli_fetch_assoc($res))
                                {
                                    //get each data
                                    $id = $rows['id'];
                                    $full_name = $rows['full_name'];
                                    $username = $rows['username'];

                                    //display rows
                                    ?>

                                    <tr>
                                        <td class="text-center"><?php echo $id;?></td>
                                        <td><?php echo $full_name; ?></td>
                                        <td><?php echo $username; ?></td>
                                        <td>
                                            <a href="<?php echo HOMEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                                            <a href="<?php echo HOMEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                                            <a href="<?php echo HOMEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-warning">Delete Admin</a>
                                        </td>
                                    </tr>

                                    <?php
                                }
                            }
                            else
                            {
                                //no data
                            }
                        }
                    ?>

                </table>

            </div>
        </div>
        <!-- Main content end -->

<?php include('partials/footer.php'); ?>