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
                    if($_SESSION['user_role'] == 'admin'){
                        $post_query_count = "SELECT * FROM posts";
                    } else {
                        $post_query_count = "SELECT * FROM posts  WHERE post_status = 'published'";
                    }
                    $find_count = mysqli_query($connection, $post_query_count);
                    $count = mysqli_num_rows($find_count);

                    $per_page = 5;
                    $count = ceil($count / $per_page);

                    if(isset($_GET['page'])){
                        $page = $_GET['page'];
                    } else {
                        $page = "1";
                    }

                    if($page == "" || $page == 1 || $page > $count){
                        $page_1 = 0;
                    } else {
                        $page_1 = ($page * $per_page) - $per_page;
                    }

                    if($_SESSION['user_role'] == 'admin'){
                        $query = "SELECT * FROM users, posts WHERE post_user = user_id LIMIT $page_1, $per_page";
                    } else {
                        $query = "SELECT * FROM users, posts WHERE post_user = user_id AND post_status = 'published' LIMIT $page_1, $per_page";
                    }
                    $select_all_posts_query = mysqli_query($connection, $query);
                    
                    if(mysqli_num_rows($select_all_posts_query) == 0){
                        echo "<h1 class='text-center'>No posts here, sorry</h1>";
                    } else {
                        while($row = mysqli_fetch_assoc($select_all_posts_query)){
                            $post_id = $row['post_id'];
                            $post_title = $row['post_title'];
                            $post_user = $row['post_user'];
                            $post_date = $row['post_date'];
                            $post_image = $row['post_image'];
                            $post_content = $row['post_content'];
                            if(strlen($post_content) >= 100){
                                $post_content = substr($row['post_content'], 0, 100) . "...";
                            }

                            $username = $row['username'];
                            $user_firstname = $row['user_firstname'];
                            $user_lastname = $row['user_lastname'];

                            ?>
                            <h2>
                                <a href="post/<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
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
                                            by <a href="author_posts.php?author=<?php echo $post_user; ?>"><?php echo $username; ?></a>
                                        </p>
                                    <?php
                                }
                            ?>

                            <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                            <hr>
                            <a href="post/<?php echo $post_id; ?>"><img class="img-responsive" src="/cms/images/<?php echo $post_image; ?>" alt=""></a>
                            <hr>
                            <p><?php echo $post_content;?></p>
                            <a class="btn btn-primary" href="post/<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                            <hr>
                            
                            <?php
                        }
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

        <ul class="pager">
            <?php
                for($i = 1; $i <= $count; $i++){
                    if($i == $page){
                        echo "<li><a class='active_link' href='index.php?page=$i'>$i</a></li>";
                    } else {
                        echo "<li><a href='index.php?page=$i'>$i</a></li>";
                    }
                }
            ?>
        </ul>

<?php include "includes/footer.php";?>