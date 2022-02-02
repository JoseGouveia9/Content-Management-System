<?php include "includes/db.php";?>
<?php include "includes/header.php";?>

    <!-- Navigation -->
    <?php include "includes/navigation.php";?>

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

                        $query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = '{$p_id}'";
                        $update_views_count = mysqli_query($connection, $query);

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
                            }
                            ?>

                            <!-- Blog Comments -->

                            <?php
                                if(isset($_POST['create_comment'])){
                                    $p_id = $_GET['p_id'];
                                    $comment_author = mysqli_real_escape_string($connection, $_POST['comment_author']);
                                    $comment_email = mysqli_real_escape_string($connection, $_POST['comment_email']);
                                    $comment_content = mysqli_real_escape_string($connection, $_POST['comment_content']);
                                    if(!empty($comment_author) && !empty($comment_author) && !empty($comment_content)){
                                        $query = "INSERT INTO comments(comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
                                        $query .= "VALUES ($p_id, '$comment_author', '$comment_email', '$comment_content', 'unapproved', now())";
                                        $create_comment_query = mysqli_query($connection,$query);

                                        if(!$create_comment_query){
                                            die("Query failed" . mysqli_error($connection));
                                        }
                                        header("Location: /cms/post/$p_id");
                                    } else {
                                        echo "<script>alert('Fields cannot be empty');</script>";
                                    }
                                }
                            ?>

                            <!-- Comments Form -->
                            <div class="well">
                                <h4>Leave a Comment:</h4>
                                <form role="form" action="" method="post">
                                    <div class="form-group">
                                        <label for="author">Author</label>
                                        <input class="form-control" name="comment_author" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input class="form-control" name="comment_email" type="email">
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
                                $query = "SELECT * FROM comments WHERE comment_post_id = $p_id ";
                                $query .= "AND comment_status = 'approved' ";
                                $query .= "ORDER BY comment_id DESC";
                                $select_all_comments_query = mysqli_query($connection, $query);

                                if(!$select_all_comments_query){
                                    die("Query failed" . mysqli_error($connection));
                                } else {
                                    while($row = mysqli_fetch_assoc($select_all_comments_query)){
                                        $comment_author = $row['comment_author'];
                                        $comment_content = $row['comment_content'];
                                        $comment_date = $row['comment_date'];?>

                                        <div class="media">
                                            <a class="pull-left" href="#">
                                                <img class="media-object" src="http://placehold.it/64x64" alt="">
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