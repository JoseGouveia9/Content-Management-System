<?php
    if(isset($_GET['edit'])){
        $post_id = escape($_GET['edit']);
        $query = "SELECT * FROM posts WHERE post_id = $post_id";
        $select_post_by_id = mysqli_query($connection, $query);
        confirmQuery($select_post_by_id);

        while($row = mysqli_fetch_assoc($select_post_by_id)){
            $post_category_id = $row["post_category_id"];
            $post_title = $row["post_title"];
            $post_user = $row["post_user"];
            $post_image = $row["post_image"];
            $post_content = $row["post_content"];
            $post_tags = $row["post_tags"];
            $post_status = $row["post_status"];
            $post_views_count = $row["post_views_count"];
        }
    }

    if(isset($_POST['update_post'])){
        $post_title = escape($_POST["post_title"]);
        $post_category_id = escape($_POST["post_category"]);
        $post_user = escape($_POST["post_user"]);
        $post_status = escape($_POST["post_status"]);

        $post_image = escape($_FILES["post_image"]["name"]);
        $post_image_temp = escape($_FILES["post_image"]["tmp_name"]); //É importante que seja tmp não temp
        
        $post_tags = escape($_POST["post_tags"]);
        $post_content = escape($_POST["post_content"]);

        move_uploaded_file($post_image_temp,"../images/$post_image");

        if(empty($post_image)){
            $query = "SELECT * FROM posts WHERE post_id = $post_id";
            $select_image = mysqli_query($connection, $query);
            confirmQuery($select_image);

            while($row = mysqli_fetch_assoc($select_image)){
                $post_image = escape($row['post_image']);
            }
        }

        $query = "UPDATE posts SET ";
        $query .=  "post_category_id = $post_category_id, ";
        $query .=  "post_title = '$post_title', ";
        $query .=  "post_user = '$post_user', ";
        $query .=  "post_date = now(), ";
        $query .=  "post_image = '$post_image', ";
        $query .=  "post_content = '$post_content', ";
        $query .=  "post_tags = '$post_tags', ";
        $query .=  "post_status = '$post_status' ";
        $query .=  "WHERE post_id = $post_id";
        $update_post = mysqli_query($connection, $query);
        confirmQuery($update_post);

        echo "<p class='bg-success'>Post Updated! - <a href='../post.php?p_id={$post_id}'>View Post</a> or <a href='posts.php'>View All Posts</a></p>";
    }

    if(isset($_POST['reset_views'])){
        $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = '{$post_id}'";
        $reset_views_count = mysqli_query($connection, $query);
        confirmQuery($reset_views_count);
    }
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input value="<?php if(isset($post_title)){echo $post_title;} ?>" type="text" class="form-control" name="post_title">
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
                    if($post_category_id == $cat_id){
                        echo "<option value='$cat_id' selected>$cat_title</option>";
                    } else {
                        echo "<option value='$cat_id'>$cat_title</option>";
                    }
                }
        ?>
        </select>
    </div>
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
                    if($post_user == $user_id){
                        ?>
                            <option value='<?php echo $user_id;?>' selected>
                            <?php
                                echo $username;
                                if(!empty($user_firstname) && !empty($user_lastname)){
                                    echo " - " . $user_firstname . " " . $user_lastname;
                                }
                            ?>
                            </option>
                        <?php
                    } else {
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
                }
        ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_status">Post Status</label><br>
        <select class="form-control" name="post_status" id="post_status">
            <?php 
                if($post_status == "published"){
                    echo "<option value='published' selected>Published</option>";
                    echo "<option value='draft'>Draft</option>";
                } else {
                    echo "<option value='published'>Published</option>";
                    echo "<option value='draft' selected>Draft</option>";
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label><br>
        <img width="100px" src="../images/<?php if(isset($post_image)){echo $post_image;} ?>" alt="">
        <input type="file" name="post_image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input value="<?php if(isset($post_tags)){echo $post_tags;} ?>" type="text" class="form-control" name="post_tags">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" id="summernote" cols="30" rows="10"><?php if(isset($post_content)){echo $post_content;} ?></textarea>
    </div>

    <div class="form-group">
        <label for="post_views_count">Views:</label>
        <span><?php echo $post_views_count; ?></span>
        <input class="btn btn-primary" type="submit" name="reset_views" value="Reset Views">
    </div>
   
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
    </div>
</form>