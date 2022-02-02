<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Image</th>
            <th>Role</th>
            <th>Change to</th>
            <!-- <th colspan="2">Change to</th> -->
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $query = "SELECT * FROM users";
            $select_users = mysqli_query($connection,$query);
            if(!$select_users){
                die("Query failed" . mysqli_error($connection));
            } else {
                while($row = mysqli_fetch_assoc($select_users)){
                    $user_id = $row['user_id'];
                    $username = $row['username'];
                    $user_firstname = $row['user_firstname'];
                    $user_lastname = $row['user_lastname'];
                    $user_email = $row['user_email'];
                    $user_image = $row['user_image'];
                    $user_role = $row['user_role'];

                    echo "<tr>";
                    echo "<td>{$user_id}</td>";
                    echo "<td>{$username}</td>";
                    echo "<td>{$user_firstname}</td>";
                    echo "<td>{$user_lastname}</td>";
                    echo "<td>{$user_email}</td>";
                    echo "<td><img height='75' src='../images/" . $user_image . "' alt=''></td>";
                    echo "<td>{$user_role}</td>";
                    if($user_role == "subscriber"){
                        // echo "<td style='width:100px'><a href='users.php?change_to_admin={$user_id}'>Admin</a></td>";
                        // echo "<td style='width:100px'></td>";
                        echo "<td><a href='users.php?change_to_admin={$user_id}'>Admin</a></td>";
                    } else {
                        // echo "<td style='width:100px'></td>";
                        // echo "<td style='width:100px'><a href='users.php?change_to_subscriber={$user_id}'>Subscriber</a></td>";
                        echo "<td><a href='users.php?change_to_subscriber={$user_id}'>Subscriber</a></td>";
                    }
                    echo "<td><a href='users.php?source=edit_user&edit={$user_id}'>Edit</a></td>";
                    echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?') \" href='users.php?delete={$user_id}'>Delete</a></td>";
                    echo "</tr>";
                }
            }

            change_role();
            delete_user();
        ?>
    </tbody>
</table>