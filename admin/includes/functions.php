<?php
    function query($query){
        global $connection;
        return mysqli_query($connection, $query);
    }

    function imagePlaceholder($image=''){
        if(!$image){
            return '900x300.png';
        } else {
            return $image;
        }
    }

    function checkIfUserIsLoggedInAndRedirect($redirectLocation){
        if(isLoggedIn()){
            redirect($redirectLocation);
        }
    }

    function isLoggedIn(){
        if(isset($_SESSION['user_role'])){
            return true;
        } 
        return false;
    }

    function loggedInUserId(){
        if(isLoggedIn()){
            $result= query("SELECT * FROM users WHERE username='" . $_SESSION['username'] . "'");
            confirmQuery($result);
            $user = mysqli_fetch_array($result);
            return mysqli_num_rows($result) >= 1 ? $user['user_id'] : false;
        }
    }

    function userLikedThisPost($post_id = ''){
        $result = query("SELECT * FROM likes WHERE user_id=". loggedInUserId() ." AND post_id=$post_id");
        confirmQuery($result);
        return mysqli_num_rows($result) >= 1 ? true : false;
    }

    function getPostLikes($post_id){
        $result = query("SELECT * FROM posts WHERE post_id=$post_id");
        confirmQuery($result);
        $post = mysqli_fetch_array($result);
        return $post['likes'];
    }

    function ifItIsMethod($method=null){
        if($_SERVER['REQUEST_METHOD'] == strtoupper($method)){
            return true;
        }
        return false;
    }

    function login_user($username, $password){
        global $connection;

        $username = escape(trim($username));
        $password = escape(trim($password));

        $query = "SELECT * FROM users WHERE username = '$username'";
        $select_user_query = mysqli_query($connection, $query);
        confirmQuery($select_user_query);
        while($row = mysqli_fetch_assoc($select_user_query)){
            $db_user_id = $row['user_id'];
            $db_username = $row['username'];
            $db_user_password = $row['user_password'];
            $db_user_firstname = $row['user_firstname'];
            $db_user_lastname = $row['user_lastname'];
            $db_user_role = $row['user_role'];

            //$password = crypt($password, $db_user_password);

            if(password_verify($password, $db_user_password)){
                $_SESSION['user_id'] = $db_user_id;
                $_SESSION['username'] = $db_username;
                $_SESSION['firstname'] = $db_user_firstname;
                $_SESSION['lastname'] = $db_user_lastname;
                $_SESSION['user_role'] = $db_user_role;
                redirect('/cms/admin');
            } else {
                return false;
            }
        }
    }

    function register_user($username, $email, $password){
        global $connection;

        $username = escape($username);
        $email = escape($email);
        $password = escape($password);

        $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

        // $query =  "SELECT randSalt FROM users";
        // $select_randsalt_query = mysqli_query($connection, $query);
        // if(!$select_randsalt_query){
        //     die("Query failed" . mysqli_error($connection));
        // }
        // $row = mysqli_fetch_assoc($select_randsalt_query);
        // $randSalt = $row['randSalt'];

        // $password = crypt($password, $randSalt);

        $query =  "INSERT INTO users(username, user_password, user_email, user_role) ";
        $query .= "VALUES ('$username', '$password', '$email', 'subscriber')";
        $create_user = mysqli_query($connection, $query);
        confirmQuery($create_user);
    }

    function redirect($location){
        header("Location: ". $location);
        exit;
    }

    function email_exists($email){
        global $connection;
        
        $query = "SELECT user_email FROM users WHERE user_email = '$email'";
        $result = mysqli_query($connection, $query);
        confirmQuery($result);

        if(mysqli_num_rows($result) > 0){
            return true;
        } else {
            return false;
        }
    }

    function username_exists($username){
        global $connection;
        
        $query = "SELECT username FROM users WHERE username = '$username'";
        $result = mysqli_query($connection, $query);
        confirmQuery($result);

        if(mysqli_num_rows($result) > 0){
            return true;
        } else {
            return false;
        }
    }

    function is_admin($username){
        global $connection;

        $query = "SELECT user_role FROM users WHERE username = '$username'";
        $result = mysqli_query($connection, $query);
        confirmQuery($result);

        $row = mysqli_fetch_assoc($result);

        if(!isset($row['user_role'])){
            return false;
        } else if($row['user_role'] == 'admin'){
            return true;
        } else {
            return false;
        }
    }

    function checkUserRole($table, $column, $status){
        global $connection;

        $query = "SELECT * FROM $table WHERE $column = '$status'";
        $select_all = mysqli_query($connection, $query);
        confirmQuery($select_all);
        $count = mysqli_num_rows($select_all);
        return $count;
    }

    function checkStatus($table, $column, $status){
        global $connection;

        $query = "SELECT * FROM $table WHERE $column = '$status'";
        $select_all = mysqli_query($connection, $query);
        confirmQuery($select_all);
        $count = mysqli_num_rows($select_all);
        return $count;
    }

    function recordCount($table){
        global $connection;

        $query = "SELECT * FROM $table";
        $select_all = mysqli_query($connection, $query);
        confirmQuery($select_all);
        $count = mysqli_num_rows($select_all);
        return $count;
    }

    function escape($string){
            global $connection;
            return mysqli_real_escape_string($connection, $string);
    }

    function users_online(){
        /* Faz mais sentido para mim
        $session = session_id();
        $time = time();
        $time_out_in_seconds = 10;
        $time_out = $time + $time_out_in_seconds;

        $query = "SELECT * FROM users_online WHERE session = '$session'";
        $send_query = mysqli_query($connection, $query);
        confirmQuery($send_query);
        $count = mysqli_num_rows($send_query);

        if($count == NULL){
            $insert_user_online = mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES ('$session', $time_out)");
            confirmQuery($insert_users_online);
        } else {
            $update_user_online = mysqli_query($connection, "UPDATE users_online SET time = $time_out WHERE session = '$session'");
            confirmQuery($update_user_online);
        }

        $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time'");
        confirmQuery($users_online_query);
        $count_user = mysqli_num_rows($users_online_query); */
        if(isset($_GET['onlineusers'])) {
            global $connection;

            //É necessário fazer isto pois o script está a iniciar diretamente a função
            if(!$connection){
                session_start();

                include("../../includes/db.php");

                $session = session_id();
                $time = time();
                $time_out_in_seconds = 10;
                $time_out = $time - $time_out_in_seconds;
    
                $query = "SELECT * FROM users_online WHERE session = '$session'";
                $send_query = mysqli_query($connection, $query);
                confirmQuery($send_query);
                $count = mysqli_num_rows($send_query);
    
                if($count == NULL){
                    $insert_user_online = mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES ('$session', $time)");
                    confirmQuery($insert_user_online);
                } else {
                    $update_user_online = mysqli_query($connection, "UPDATE users_online SET time = $time WHERE session = '$session'");
                    confirmQuery($update_user_online);
                }
                $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
                confirmQuery($users_online_query);
                echo $count_user = mysqli_num_rows($users_online_query);
            }

        }

        //Versão online, pois está a haver um problema com o CORS
        // global $connection;

        // $session = session_id();
        // $time = time();
        // $time_out_in_seconds = 10;
        // $time_out = $time - $time_out_in_seconds;

        // $query = "SELECT * FROM users_online WHERE session = '$session'";
        // $send_query = mysqli_query($connection, $query);
        // confirmQuery($send_query);
        // $count = mysqli_num_rows($send_query);

        // if($count == NULL){
        //     $insert_user_online = mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES ('$session', $time)");
        //     confirmQuery($insert_user_online);
        // } else {
        //     $update_user_online = mysqli_query($connection, "UPDATE users_online SET time = $time WHERE session = '$session'");
        //     confirmQuery($update_user_online);
        // }
        // $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
        // confirmQuery($users_online_query);
        // return $count_user = mysqli_num_rows($users_online_query);
    }

    users_online();

    function reset_views(){
        if(isset($_GET['reset'])){
            global $connection;
            $post_id = $_GET['reset'];

            $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = '{$post_id}'";
            $reset_views_count = mysqli_query($connection, $query);
            confirmQuery($reset_views_count);

            header("Location: posts.php");
        }
    }
    

    function change_role(){
        if(isset($_GET['change_to_admin'])){
            global $connection;
            $id = $_GET['change_to_admin'];

            $query = "UPDATE users SET user_role = 'admin' WHERE user_id = $id";
            $change_to_query = mysqli_query($connection, $query);
            confirmQuery($change_to_query);

            header("Location: users.php");
        }
        if(isset($_GET['change_to_subscriber'])){
            global $connection;
            $id = $_GET['change_to_subscriber'];

            $query = "UPDATE users SET user_role = 'subscriber' WHERE user_id = $id";
            $change_to_query = mysqli_query($connection, $query);
            confirmQuery($change_to_query);

            header("Location: users.php");
        }
    }


    function delete_user(){
        if(isset($_SESSION['user_role'])){
            if($_SESSION['user_role'] == 'admin'){
                if(isset($_GET['delete'])){
                    global $connection;
                    $id = escape($_GET['delete']);
        
                    $query = "DELETE FROM users WHERE user_id = $id";
                    $delete_query = mysqli_query($connection, $query);
                    confirmQuery($delete_query);
        
                    header("Location: users.php");
                }
            }
        }
    }

    function approve_comment(){
        if(isset($_GET['approve'])){
            global $connection;
            $id = escape($_GET['approve']);

            $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $id";
            $approve_comment_query = mysqli_query($connection, $query);
            confirmQuery($approve_comment_query);

            if(isset($_GET['p_id'])){
                $post_id = $_GET['p_id'];
                header("Location: post_comments.php?id=$post_id");
            } else {
                header("Location: comments.php");
            }
        }
    }

    function unapprove_comment(){
        if(isset($_GET['unapprove'])){
            global $connection;
            $id = escape($_GET['unapprove']);

            $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $id";
            $unapprove_comment_query = mysqli_query($connection, $query);
            confirmQuery($unapprove_comment_query);

            if(isset($_GET['p_id'])){
                $post_id = $_GET['p_id'];
                header("Location: post_comments.php?id=$post_id");
            } else {
                header("Location: comments.php");
            }
        }
    }

    function delete_comment(){
        if(isset($_GET['delete'])){
            global $connection;
            $id = escape($_GET['delete']);

            $query = "DELETE FROM comments WHERE comment_id = $id";
            $delete_query = mysqli_query($connection, $query);
            confirmQuery($delete_query);

            if(isset($_GET['p_id'])){
                $post_id = $_GET['p_id'];
                header("Location: post_comments.php?id=$post_id");
            } else {
                header("Location: comments.php");
            }
        }
    }

    function delete_post(){
        if(isset($_POST['delete'])){
            global $connection;
            $id = escape($_POST['post_id']);

            $query = "DELETE FROM posts WHERE post_id = $id";
            $delete_query = mysqli_query($connection, $query);

            confirmQuery($delete_query);

            header("Location: posts.php");
        }
    }

    function confirmQuery($result){
        if(!$result){
            global $connection;
            die("Query failed" . mysqli_error($connection));
        }
    }

    function insert_categories(){
        global $connection;
        if(isset($_POST['submit'])){
            $cat_title = escape($_POST['cat_title']);

            if($cat_title == "" || empty($cat_title)){
                echo "This field should not be empty";
            } else {
                $stmt = mysqli_prepare($connection, "INSERT INTO categories(cat_title) VALUES (?)");
                mysqli_stmt_bind_param($stmt, "s", $cat_title); //"i" if it's a interger, "is" if it's a interger and string
                mysqli_stmt_execute($stmt);
                confirmQuery($stmt);

                mysqli_stmt_close($stmt);


                // $query = "INSERT INTO categories(cat_title)";
                // $query .= " VALUES ('$cat_title')";
                // $create_category_query = mysqli_query($connection,$query);
                
                // if(!$create_category_query){
                //     die("Query failed" . mysqli_error($connection));
                // }

                // header("Location: categories.php");
            
                echo "<p class='bg-success'>Category Created!</p>";
            }
        }
    }

    function findAllCategories(){
        //Find all categories
        global $connection;
        $query = "SELECT * FROM categories";
        $select_all_categories_query = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($select_all_categories_query)){
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];
            echo "<tr>";
            echo "<td>{$cat_id}</td>";
            echo "<td>{$cat_title}</td>";
            echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
            echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
            echo "</tr>";
        }

        /* Feito por mim 
        query = "SELECT * FROM categories";
        $select_all_categories_query = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($select_all_categories_query)){
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];
            ?>
            <tr>
                <td><?php echo $cat_id; ?></td>
                <td><?php echo $cat_title; ?></td>
            </tr>
            <?php
        }*/
    }

    function deleteCategories(){
        //Delete selected category
        global $connection;
        if(isset($_GET['delete'])){
            $the_cat_id = escape($_GET['delete']);
            $query = "DELETE FROM categories WHERE cat_id = $the_cat_id";
            $delete_query = mysqli_query($connection, $query);
            if(!$delete_query){
                die("Query failed" . mysqli_error($connection));
            } else {
                header("Location: categories.php");
            }
        }
    }

?>