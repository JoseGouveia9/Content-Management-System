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
                    if(isset($_GET['category'])){
                        $post_category_id = mysqli_real_escape_string($connection, $_GET['category']);

                        if(is_admin()){
                            //$query = "SELECT post_id, post_title, post_user, post_date, post_image, post_content, username, user_firstname, user_lastname FROM users, posts WHERE post_user = user_id AND post_category_id = $post_category_id";

                            $stmt1 = mysqli_prepare($connection, "SELECT post_id, post_title, post_user, post_date, post_image, post_content, username, user_firstname, user_lastname FROM users, posts WHERE post_user = user_id AND  post_category_id = ?");
                        } else {
                            //$query = "SELECT * FROM users, posts WHERE post_user = user_id AND post_category_id = $post_category_id AND post_status = 'published'";

                            $stmt2 = mysqli_prepare($connection, "SELECT post_id, post_title, post_user, post_date, post_image, post_content, username, user_firstname, user_lastname FROM users, posts WHERE post_user = user_id AND post_category_id = ? AND post_status = ?");
                            $published = 'published';
                        }

                        if(isset($stmt1)){
                            mysqli_stmt_bind_param($stmt1, "i", $post_category_id); //"i" if it's a interger, "is" if it's a interger and string
                            mysqli_stmt_execute($stmt1);
                            mysqli_stmt_bind_result($stmt1, $post_id, $post_title, $post_user, $post_date, $post_image, $post_content, $username, $user_firstname, $user_lastname);
                            $stmt = $stmt1;
                        } else {
                            mysqli_stmt_bind_param($stmt2, "is", $post_category_id, $published); //"i" if it's a interger, "is" if it's a interger and string
                            mysqli_stmt_execute($stmt2);
                            mysqli_stmt_bind_result($stmt2, $post_id, $post_title, $post_user, $post_date, $post_image, $post_content, $username, $user_firstname, $user_lastname);
                            $stmt = $stmt2;
                        }

                        //$select_all_posts_query = mysqli_query($connection, $query);
                        //confirmQuery($select_all_posts_query);

                        //if(mysqli_num_rows($select_all_posts_query) == 0){
                        mysqli_stmt_store_result($stmt);
                        if(mysqli_stmt_num_rows($stmt) == 0){
                            echo "<h1 class='text-center'>It doesn't exist any posts in this category</h1>";
                        } else {
                            while(mysqli_stmt_fetch($stmt)){
                                if(strlen($post_content) >= 100){
                                    $post_content = substr($post_content, 0, 100) . "...";
                                }
        
                                ?>

                                <h2>
                                    <a href="/cms/post/<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
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
                                <a href="/cms/post/<?php echo $post_id; ?>"><img class="img-responsive" src="/cms/images/<?php echo $post_image; ?>" alt=""></a>
                                <hr>
                                <p><?php echo $post_content;?></p>
                                <a class="btn btn-primary" href="/cms/post/<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                                <hr>

                                <?php
                            }
                            mysqli_stmt_close($stmt);
                        }
                    } else {
                        header("Location: index.php");
                    }

                    
                ?>

                <!-- First Blog Post -->
                <!-- <h2>
                    <a href="#">Blog Post Title</a>
                </h2>
                <p class="lead">
                    by <a href="index.php">Start Bootstrap</a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on August 28, 2013 at 10:00 PM</p>
                <hr>
                <img class="img-responsive" src="http://placehold.it/900x300" alt="">
                <hr>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore, veritatis, tempora, necessitatibus inventore nisi quam quia repellat ut tempore laborum possimus eum dicta id animi corrupti debitis ipsum officiis rerum.</p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr> -->

                

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php";?>

        </div>
        <!-- /.row -->

        <hr>

<?php include "includes/footer.php";?>