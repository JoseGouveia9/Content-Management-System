<?php include "includes/db.php";?>
<?php include "includes/header.php";?>

    <!-- Navigation -->
    <?php include "includes/navigation.php";?>

    <!-- Page Content -->
    <div class="container main-container" style="margin-top: 20px;">

        <div class="row" style="padding: 0px 10px;">
        
            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php";?>

            <!-- Blog Entries Column -->
            <div class="col-md-9 parent">

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
                            $user_image = $row['user_image'];

                            ?>
                            <li class="post">
                                <div class="post-container" >
                                    <div class="post-header">
                                        <h2>
                                            <a href="post/<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                                        </h2>
                                        <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                                    </div>
                                    <div class="details-container">
                                            <img class="media-object" src="<?php if($user_image != ''){echo "/cms/images/".$user_image.""; } else { echo "/cms/images/profile.png";}?>" alt="">
                                        <?php
                                            if(!empty($user_firstname) && !empty($user_lastname)){
                                                ?>
                                                    <p class="lead">
                                                        <a href="/cms/author_posts/<?php echo $post_user; ?>"><?php echo $user_firstname . " " . $user_lastname; ?></a>
                                                    </p>
                                                <?php
                                            } else {
                                                ?>
                                                    <p class="lead">
                                                        <a href="author_posts.php?author=<?php echo $post_user; ?>"><?php echo $username; ?></a>
                                                    </p>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                            </li>
                            <?php
                        }
                    } ?>
                
                <ul class="pagination" style="margin-top:1rem; display: flex; justify-content: center;">
                    <?php
                        for($i = 1; $i <= $count; $i++){
                            if($i == $page){
                                echo "<li class='page-item active'><p class='page-link'>$i</p></li>";
                            } else {
                                echo "<li class='page-item'><a class='page-link' href='index.php?page=$i'>$i</a></li>";
                            }
                        }
                    ?>
                </ul>

            </div>

        </div>
        <!-- /.row -->

        <hr>

<?php include "includes/footer.php";?>