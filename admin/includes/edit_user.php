<?php
    if(isset($_GET['edit'])){
        $user_id = escape($_GET['edit']);

        $query = "SELECT * FROM users WHERE user_id = $user_id";
        $select_user_by_id = mysqli_query($connection, $query);
        confirmQuery($select_user_by_id);

        while($row = mysqli_fetch_assoc($select_user_by_id)){
            $username = $row["username"];
            $user_password	 = $row["user_password"];
            $user_firstname = $row["user_firstname"];
            $user_lastname = $row["user_lastname"];
            $user_email = $row["user_email"];
            $user_image	 = $row["user_image"];
            $user_role = $row["user_role"];
        }

        if(isset($_POST['update_user'])){
            $username = escape($_POST["username"]);
            $user_password = escape($_POST["user_password"]);
            $user_firstname = escape($_POST["user_firstname"]);
            $user_lastname = escape($_POST["user_lastname"]);
            
            $user_image = escape($_FILES["user_image"]["name"]);
            $user_image_temp = escape($_FILES["user_image"]["tmp_name"]); //É importante que seja tmp não temp
            
            $user_email = escape($_POST["user_email"]);
            $user_role = escape($_POST["user_role"]);

            move_uploaded_file($user_image_temp,"../images/$user_image");

            if(empty($user_image)){
                $query = "SELECT * FROM users WHERE user_id = $user_id";
                $select_image = mysqli_query($connection, $query);
                confirmQuery($select_image);

                while($row = mysqli_fetch_assoc($select_image)){
                    $user_image = $row['user_image'];
                }
            }

            // $query =  "SELECT randSalt FROM users";
            // $select_randsalt_query = mysqli_query($connection, $query);
            // confirmQuery($select_randsalt_query);
            // $row = mysqli_fetch_assoc($select_randsalt_query);

            // $randSalt = $row['randSalt'];

            // $hashed_password = crypt($user_password, $randSalt);

            //Para que?
            // $query =  "SELECT user_password FROM users WHERE user_id = $user_id";
            // $get_user_query = mysqli_query($connection, $query);
            // confirmQuery($get_user_query);
            // $row = mysqli_fetch_assoc($get_user_query);

            // $db_user_password = $row['user_password'];

            if(!empty($user_password)){
                $hashed_password = escape(password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12)));

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

                echo "<p class='bg-success'>User Updated including password! - <a href='users.php'>View All Users</a></p>";
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

                echo "<p class='bg-success'>User Updated excluding password! - <a href='users.php'>View All Users</a></p>";
            }

            
        }
    } else {
        header("Location: users.php");
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
        <label for="user_role">Role</label><br>
        <select class="form-control" name="user_role" id="user_role">
            <option value='<?php echo $user_role;?>'><?php echo $user_role;?></option>
            <?php
                    if($user_role == 'admin'){
                        echo "<option value='subscriber' >subscriber</option>";
                    } else {
                        echo "<option value='admin'>admin</option>";
                    }
            ?>
        </select>
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
        <input class="btn btn-primary" type="submit" name="update_user" value="Update User">
    </div>
</form>