<?php include "includes/db.php";?>
<?php include "includes/header.php";?>
<?php
    if(isset($_GET['author'])){
        $author = $_GET['author'];
        $author = mysqli_real_escape_string($connection,$author); 
    }
?>

    <!-- Navigation -->
    <?php include "includes/navigation.php";?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <h1 class="page-header">
                    Author
                    <small><?php echo $author;?></small>
                </h1>

                <?php
                    if($_SESSION['user_role'] == 'admin'){
                        $query = "SELECT * FROM posts, users WHERE post_user = user_id AND post_user = $author";
                    } else {
                        $query = "SELECT * FROM posts, users WHERE post_user = user_id AND post_user = $author AND post_status = 'published'";
                    }
                    $search_query = mysqli_query($connection, $query);
                    if(!$search_query){
                        die("Query failed" . mysqli_error($connection));
                    }
                    $count = mysqli_num_rows($search_query);
                    if($count == 0){
                        echo "<h2>No Results</h2>";
                    } else {
                        while($row = mysqli_fetch_assoc($search_query)){
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
                                <a href="/cms/post/<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                            </h2>

                            <?php
                                if(!empty($user_firstname) && !empty($user_lastname)){
                                    ?>
                                        <p class="lead">
                                            by <?php echo $user_firstname . " " . $user_lastname; ?>
                                        </p>
                                    <?php
                                } else {
                                    ?>
                                        <p class="lead">
                                            by <?php echo $username; ?>
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