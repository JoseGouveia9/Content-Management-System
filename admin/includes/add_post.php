<?php
    if(isset($_POST['create_post'])){
        $post_title = escape($_POST["post_title"]);
        $post_category_id = escape($_POST["post_category"]);
        $post_user = escape($_POST["post_user"]);
        $post_status = escape($_POST["post_status"]);
        
        $post_image = escape(imagePlaceholder($_FILES["post_image"]["name"]));
        $post_image_temp = escape($_FILES["post_image"]["tmp_name"]); //É importante que seja tmp não temp
        
        $post_tags = escape($_POST["post_tags"]);
        $post_content = escape($_POST["post_content"]);
        $post_date = date('d-m-y');

        move_uploaded_file($post_image_temp,"../images/$post_image");

        $query = "INSERT INTO posts(post_category_id, post_title, post_user, post_date, post_image, post_content, post_tags, post_status)";
        $query .= " VALUES ($post_category_id, '$post_title', '$post_user', now(), '$post_image', '$post_content', '$post_tags', '$post_status')";
        $create_post_query = mysqli_query($connection, $query);

        confirmQuery($create_post_query);

        $the_post_id = mysqli_insert_id($connection);

        require '../vendor/autoload.php';

        $options = array(
            'cluster' => 'eu',
            'useTLS' => true
        );
        $pusher = new Pusher\Pusher(
            '5245d2b156687e2eb8ee',
            '29171a263a0fdb6464a5',
            '1340494',
            $options
        );
        $data = 'hello world';
        $pusher->trigger('my-channel', 'my-event', $data);

        echo "<p class='bg-success'>Post Created! - <a href='../post.php?p_id={$the_post_id}'>View Post</a> or <a href='posts.php'>View All Posts</a></p>";
    }
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input type="text" class="form-control" name="post_title">
    </div>
    <div class="form-group">
        <label for="post_category">Post Category</label><br>
        <select class="form-control" name="post_category" id="post_category">
        <?php
                $query = "SELECT * FROM categories";
                $select_categories = mysqli_query($connection, $query);
                confirmQuery($select_categories);

                while($row = mysqli_fetch_assoc($select_categories)){
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];
                    echo "<option value='$cat_id'>$cat_title</option>";
                }
        ?>
        </select>
    </div>
    <?php if(!is_admin()){ ?>
        <input type="hidden" class="form-control" name="post_user" value="<?php echo $_SESSION['user_id'];?>">
    <?php } else { ?>
        <div class="form-group">
        <label for="post_user">Post Author</label>
            <select class="form-control" name="post_user" id="post_user">
            <?php
                    $query = "SELECT * FROM users";
                    $select_users = mysqli_query($connection, $query);
                    confirmQuery($select_users);

                    while($row = mysqli_fetch_assoc($select_users)){
                        $user_id = $row['user_id'];
                        $username = $row['username'];
                        $user_firstname = $row['user_firstname'];
                        $user_lastname = $row['user_lastname'];
                        ?>
                            <option value='<?php echo $user_id;?>'>
                            <?php
                                echo $username;
                                if(!empty($user_firstname) && !empty($user_lastname)){
                                    echo " - " . $user_firstname . " " . $user_lastname;
                                }
                            ?>
                            </option>
                        <?php
                    }
            ?>
            </select>
        </div>
    <?php } ?>
    <?php if(is_admin()) { ?>
        <div class="form-group">
            <label for="post_status">Post Status</label><br>
            <select class="form-control" name="post_status" id="post_status">
                <option value="published">Published</option>
                <option value="draft">Draft</option>
            </select>
        </div>
    <?php } else { ?>
        <input value="draft" type="hidden" class="form-control" name="post_status">
    <?php } ?>
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="post_image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" id="summernote" cols="30" rows="10"></textarea>
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
    </div>
</form>