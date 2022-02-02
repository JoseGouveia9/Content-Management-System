<?php
    if(isset($_POST['create_user'])){
        $username = escape($_POST["username"]);
        $user_password = escape($_POST["user_password"]);
        $user_firstname = escape($_POST["user_firstname"]);
        $user_lastname = escape($_POST["user_lastname"]);
        
        $user_image = escape($_FILES["user_image"]["name"]);
        $user_image_temp = escape($_FILES["user_image"]["tmp_name"]); //É importante que seja tmp não temp
        
        $user_email = escape($_POST["user_email"]);
        $user_role = escape($_POST["user_role"]);

        move_uploaded_file($user_image_temp,"../images/$user_image");

        $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));

        $query = "INSERT INTO users(username, user_password, user_firstname, user_lastname, user_image, user_email, user_role)";
        $query .= " VALUES ('$username', '$user_password', '$user_firstname', '$user_lastname', '$user_image', '$user_email', '$user_role')";
        $create_user_query = mysqli_query($connection, $query);
        confirmQuery($create_user_query);

        header("Location: users.php");

        echo "<p class='bg-success'>User Created! - <a href='users.php'>View All Users</a></p>";
    }
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="user_firstname">First Name</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>
    <div class="form-group">
        <label for="user_lastname">Last Name</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>
    <div class="form-group">
        <label for="user_image">Image</label>
        <input type="file" name="user_image">
    </div>
    <div class="form-group">
        <label for="user_role">Role</label><br>
        <select class="form-control" name="user_role" id="user_role">
            <option value="subscriber">Select Options</option>
            <option value="admin">admin</option>
            <option value="subscriber">subscriber</option>
        </select>
    </div>
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username">
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email">
    </div>
    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" class="form-control" name="user_password">
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_user" value="Add User">
    </div>
</form>