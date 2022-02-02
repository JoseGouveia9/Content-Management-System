<?php include "includes/admin_header.php"; ?>
<?php
    if(isset($_SESSION['username'])){
        $username = escape($_SESSION['username']);
        $query = "SELECT * FROM users WHERE username = '$username'";
        $select_user_profile_query = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($select_user_profile_query)){
            $user_id = $row['user_id'];
            $username = $row['username'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
            $user_role = $row['user_role'];
        }
    }
?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/admin_navigation.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Profile
                        </h1>
                        <?php
                            if(isset($_POST['update_profile'])){
                                $username = $_POST["username"];
                                $user_password = $_POST["user_password"];
                                $user_firstname = $_POST["user_firstname"];
                                $user_lastname = $_POST["user_lastname"];
                                
                                $user_image = $_FILES["user_image"]["name"];
                                $user_image_temp = $_FILES["user_image"]["tmp_name"]; //É importante que seja tmp não temp
                                
                                $user_email = $_POST["user_email"];

                                move_uploaded_file($user_image_temp,"../images/$user_image");

                                if(empty($user_image)){
                                    $query = "SELECT * FROM users WHERE user_id = $user_id";
                                    $select_image = mysqli_query($connection, $query);

                                    while($row = mysqli_fetch_assoc($select_image)){
                                        $user_image = $row['user_image'];
                                    }
                                }

                                if(!empty($user_password)){
                                    $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));

                                    $query = "UPDATE users SET ";
                                    $query .=  "username = '$username', ";
                                    $query .=  "user_password = '$hashed_password', ";
                                    $query .=  "user_firstname = '$user_firstname', ";
                                    $query .=  "user_lastname = '$user_lastname', ";
                                    $query .=  "user_image = '$user_image', ";
                                    $query .=  "user_email = '$user_email', ";
                                    $query .=  "user_role = '$user_role' ";
                                    $query .=  "WHERE user_id = $user_id";
                                    $update_user = mysqli_query($connection, $query);
                                    confirmQuery($update_user);
    
                                    $_SESSION['username'] = $username;
                                    $_SESSION['firstname'] = $user_firstname;
                                    $_SESSION['lastname'] = $user_lastname;
                    
                                    echo "<p class='bg-success'>Profile Updated including password! - <a href='users.php'>View All Users</a></p>";

                                } else {
                                    $query = "UPDATE users SET ";
                                    $query .=  "username = '$username', ";
                                    $query .=  "user_firstname = '$user_firstname', ";
                                    $query .=  "user_lastname = '$user_lastname', ";
                                    $query .=  "user_image = '$user_image', ";
                                    $query .=  "user_email = '$user_email', ";
                                    $query .=  "user_role = '$user_role' ";
                                    $query .=  "WHERE user_id = $user_id";
                                    $update_user = mysqli_query($connection, $query);
                                    confirmQuery($update_user);
    
                                    $_SESSION['username'] = $username;
                                    $_SESSION['firstname'] = $user_firstname;
                                    $_SESSION['lastname'] = $user_lastname;
                    
                                    echo "<p class='bg-success'>Profile Updated excluding password! - <a href='users.php'>View All Users</a></p>";
                                }
                            }
                        ?>

                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="user_firstname">First Name</label>
                                <input value="<?php if(isset($user_firstname)){echo $user_firstname;} ?>" type="text" class="form-control" name="user_firstname">
                            </div>
                            <div class="form-group">
                                <label for="user_lastname">Last Name</label>
                                <input value="<?php if(isset($user_lastname)){echo $user_lastname;} ?>" type="text" class="form-control" name="user_lastname">
                            </div>
                            <div class="form-group">
                                <label for="user_image">Image</label><br>
                                <img height="100px" src="../images/<?php if(isset($user_image)){echo $user_image;} ?>" alt="">
                                <input type="file" name="user_image">
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input value="<?php if(isset($username)){echo $username;} ?>" type="text" class="form-control" name="username">
                            </div>
                            <div class="form-group">
                                <label for="user_email">Email</label>
                                <input value="<?php if(isset($user_email)){echo $user_email;} ?>" type="email" class="form-control" name="user_email">
                            </div>
                            <div class="form-group">
                                <label for="user_password">Password</label>
                                <input autocomplete="off" type="password" class="form-control" name="user_password">
                            </div>

                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" name="update_profile" value="Update Profile">
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php include "includes/admin_footer.php"; ?>
