<?php include "includes/db.php";?>
<?php include "includes/header.php";?>

    <!-- Navigation -->
    <?php include "includes/navigation.php";?>

    <?php
        if(isset($_POST['liked'])){
            $post_id = $_POST['post_id'];
            $user_id = $_POST['user_id'];

            $searchPostQuery = "SELECT * FROM posts WHERE post_id=$post_id";
            $postResult =  mysqli_query($connection, $searchPostQuery);
            $post = mysqli_fetch_array($postResult);
            $likes = $post['likes'];

            if(mysqli_num_rows($postResult) >= 1){
                echo $post['post_id'];
            }

            mysqli_query($connection, "UPDATE posts SET likes=$likes+1 WHERE post_ID=$post_id");

            mysqli_query($connection, "INSERT INTO likes(user_id, post_id) VALUES ($user_id, $post_id)");
            exit();
        }

        if(isset($_POST['unliked'])){
            $post_id = $_POST['post_id'];
            $user_id = $_POST['user_id'];

            $searchPostQuery = "SELECT * FROM posts WHERE post_id=$post_id";
            $postResult =  mysqli_query($connection, $searchPostQuery);
            $post = mysqli_fetch_array($postResult);
            $likes = $post['likes'];

            mysqli_query($connection, "UPDATE posts SET likes=$likes-1 WHERE post_id=$post_id");

            mysqli_query($connection, "DELETE FROM likes WHERE user_id=$user_id AND post_id=$post_id");
            exit();
        }
    ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <!-- <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1> -->

                <?php
                    if(isset($_GET['p_id'])){
                        $p_id = mysqli_real_escape_string($connection, $_GET['p_id']);

                        if($_SERVER['REQUEST_METHOD'] !== 'POST'){

                            $query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = '{$p_id}'";
                            $update_views_count = mysqli_query($connection, $query);
                        
                        }

                            if($_SESSION['user_role'] == 'admin'){
                                $query = "SELECT * FROM users, posts WHERE post_user = user_id AND post_id = $p_id";
                            } else {
                                $query = "SELECT * FROM users, posts WHERE post_user = user_id AND post_id = $p_id AND post_status = 'published'";
                            }
                            $select_all_posts_query = mysqli_query($connection, $query);


                        
                        if(mysqli_num_rows($select_all_posts_query) == 0){
                            echo "<h1 class='text-center'>Post unavailable</h1>";
                        } else {
                            while($row = mysqli_fetch_assoc($select_all_posts_query)){
                                $post_title = $row['post_title'];
                                $post_user = $row['post_user'];
                                $post_date = $row['post_date'];
                                $post_image = $row['post_image'];
                                $post_content = $row['post_content'];

                                $username = $row['username'];
                                $user_firstname = $row['user_firstname'];
                                $user_lastname = $row['user_lastname'];

                                ?>

                                <h2>
                                <?php echo $post_title; ?>
                                </h2>

                                <?php
                                    if(!empty($user_firstname) && !empty($user_lastname)){
                                        ?>
                                            <p class="lead">
                                                by <a href="/cms/author_posts/<?php echo $post_user; ?>"><?php echo $user_firstname . " " . $user_lastname; ?></a>
                                            </p>
                                        <?php
                                    } else {
                                        ?>
                                            <p class="lead">
                                                by <a href="/cms/author_posts/<?php echo $post_user; ?>"><?php echo $username; ?></a>
                                            </p>
                                        <?php
                                    }
                                ?>

                                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                                <hr>
                                <img class="img-responsive" src="/cms/images/<?php echo $post_image; ?>" alt="">
                                <hr>
                                <p><?php echo $post_content;?></p>
                                <hr>

                                <?php
                                    if(isLoggedIn()){?>
                                        <div class="row">
                                            <p class="pull-right"><a 
                                            class="<?php echo userLikedThisPost($p_id) ? 'unlike' : 'like'; ?>" 
                                            href=""
                                            data-toggle="tooltip" 
                                            data-placement="top" 
                                            title="<?php echo userLikedThisPost($p_id) ? 'You liked this before' : 'You want to like it?'; ?>"
                                            ><span class="<?php echo userLikedThisPost($p_id) ? 'glyphicon glyphicon-thumbs-down' : 'glyphicon glyphicon-thumbs-up'; ?>"></span> <?php echo userLikedThisPost($p_id) ? 'Unlike' : 'Like'; ?>
                                            </a></p>
                                        </div>
                                    <?php
                                    } else { ?>
                                        <div class="row">
                                            <p class="pull-right">You need to <a href="/cms/login.php">login</a> to like</p>
                                        </div>
                                    <?php
                                    }
                                ?>

                                <div class="row">
                                    <p class="pull-right">Like: <?php echo getPostLikes($p_id) ?></p>
                                </div>

                                <div class="clearfix"></div>

                                <?php
                            }
                            ?>

                            <!-- Blog Comments -->

                            <?php
                                if($_SERVER['REQUEST_METHOD'] === 'POST'){

                                    if(isset($_POST['create_comment'])){
                                        $p_id = $_GET['p_id'];
                                        $comment_author = mysqli_real_escape_string($connection, $_POST['comment_author']);
                                        $comment_email = mysqli_real_escape_string($connection, $_POST['comment_email']);
                                        $comment_content = mysqli_real_escape_string($connection, $_POST['comment_content']);
                                        if(!empty($comment_author) && !empty($comment_author) && !empty($comment_content)){
                                            if(isLoggedIn()){
                                                $query = "INSERT INTO comments(comment_post_id, comment_author, comment_author_id, comment_email, comment_content, comment_status, comment_date) ";
                                                $query .= "VALUES ($p_id, '$comment_author', " . $_SESSION['user_id'] . ", '$comment_email', '$comment_content', 'unapproved', now())";
                                            } else {
                                                $query = "INSERT INTO comments(comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
                                                $query .= "VALUES ($p_id, '$comment_author', '$comment_email', '$comment_content', 'unapproved', now())";
                                            }
                                            $create_comment_query = mysqli_query($connection,$query);

                                            if(!$create_comment_query){
                                                die("Query failed" . mysqli_error($connection));
                                            }
                                            header("Location: /cms/post/$p_id");
                                        } else {
                                            echo "<script>alert('Fields cannot be empty');</script>";
                                        }
                                    } 
                                }
                            ?>

                            <!-- Comments Form -->
                            <div class="well">
                                <h4>Leave a Comment:</h4>
                                <form role="form" action="" method="post">
                                    <div class="form-group">
                                        <label for="author">Author</label>
                                        <?php if(isLoggedIn()){ ?>
                                            <input class="form-control" name="comment_author" type="text" 
                                            value="<?php if(empty($_SESSION['firstname']) && empty($_SESSION['lastname'])){
                                                echo $_SESSION['username'];
                                            } else {
                                                echo $_SESSION['firstname'] . " " . $_SESSION['lastname'];
                                            } ?>" readonly>
                                        <?php } else { ?>
                                            <input class="form-control" name="comment_author" type="text">
                                        <?php }?>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <?php if(isLoggedIn()){ ?>
                                            <input class="form-control" name="comment_email" type="email" 
                                            value="<?php echo $_SESSION['email']; ?>" readonly>
                                        <?php } else { ?>
                                            <input class="form-control" name="comment_email" type="email">
                                        <?php }?>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="comment">Your Comment</label>
                                        <textarea name="comment_content" class="form-control" rows="3"></textarea>
                                    </div>
                                    <button name="create_comment" type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>

                            <hr>

                            <!-- Posted Comments -->

                            <?php
                                $p_id = mysqli_real_escape_string($connection, $_GET['p_id']);
                                $query = "SELECT * FROM comments LEFT JOIN users ON comment_author_id = user_id ";
                                $query .= "WHERE comment_post_id = $p_id AND comment_status = 'approved' ";
                                $query .= "ORDER BY comment_id DESC";
                                $select_all_comments_query = mysqli_query($connection, $query);

                                if(!$select_all_comments_query){
                                    die("Query failed" . mysqli_error($connection));
                                } else {
                                    while($row = mysqli_fetch_assoc($select_all_comments_query)){
                                        $comment_author = $row['comment_author'];
                                        $comment_content = $row['comment_content'];
                                        $comment_date = $row['comment_date'];
                                        $user_image = $row['user_image'];?>

                                        <div class="media">
                                            <a class="pull-left" href="#">
                                                <img height="64px" class="media-object" src="<?php if($user_image != ''){echo "/images/".$user_image.""; } else { echo 'http://placehold.it/64x64';}?>" alt="">
                                            </a>
                                            <div class="media-body">
                                                

                                                <h4 class="media-heading"><?php echo $comment_author; ?>
                                                    <small><?php echo $comment_date; ?></small>
                                                </h4>
                                                <?php echo $comment_content; ?>
                                            </div>
                                        </div>
                                        <?php

                                    }
                                }
                        }
                    
                    } else {
                        header("Location: index.php");
                    }
                        ?>
            </div>


            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php";?>

        </div>
        <!-- /.row -->

        <hr>


<?php include "includes/footer.php";?>

<script>
    $(document).ready(function(){
        var post_id = <?php echo $p_id ?>;
        var user_id = <?php echo loggedInUserId() ?>;

        $('.like').click(function(){
            $.ajax({
                url: "/cms/post.php?p_id=<?php echo $p_id ?>",
                type: 'post',
                data: {
                    liked: 1,
                    post_id: post_id,
                    user_id: user_id,
                }
            });
        });

        $('.unlike').click(function(){
            $.ajax({
                url: "/cms/post.php?p_id=<?php echo $p_id ?>",
                type: 'post',
                data: {
                    unliked: 1,
                    post_id: post_id,
                    user_id: user_id,
                }
            });
        });

        $('[data-toggle="tooltip"]').tooltip();
    });
</script>