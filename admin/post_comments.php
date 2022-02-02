<?php include "includes/admin_header.php"; ?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/admin_navigation.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Comments
                        </h1>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Author</th>
                                    <th>Content</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>In Response to</th>
                                    <th>Date</th>
                                    <th>Approve</th>
                                    <th>Unapprove</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(isset($_GET['id'])){
                                        $post_id = escape($_GET['id']);

                                        $query = "SELECT comment_id, post_id, post_title, comment_author, comment_email, comment_content, comment_status, comment_date FROM posts, comments WHERE comment_post_id = post_id && post_id = $post_id";
                                        $select_all_comments_query = mysqli_query($connection,$query);
                                        if(!$select_all_comments_query){
                                            die("Query failed" . mysqli_error($connection));
                                        } else {
                                            while($row = mysqli_fetch_assoc($select_all_comments_query)){
                                                $comment_id = $row['comment_id'];
                                                $comment_author = $row['comment_author'];
                                                $comment_content = $row['comment_content'];
                                                $comment_email = $row['comment_email'];
                                                $comment_status = $row['comment_status'];
                                                $post_id = $row['post_id'];
                                                $post_title = $row['post_title'];
                                                $comment_date = $row['comment_date'];

                                                echo "<tr>";
                                                echo "<td>{$comment_id}</td>";
                                                echo "<td>{$comment_author}</td>";
                                                echo "<td>{$comment_content}</td>";
                                                echo "<td>{$comment_email}</td>";
                                                echo "<td>{$comment_status}</td>";
                                                echo "<td><a href='../post.php?p_id=$post_id'>{$post_title}</td></a>";
                                                echo "<td>{$comment_date}</td>";
                                                if($comment_status == "approved"){
                                                    echo "<td></td>";
                                                    echo "<td><a href='comments.php?unapprove={$comment_id}&p_id={$post_id}'>Unapprove</a></td>";
                                                } else {
                                                    echo "<td><a href='comments.php?approve={$comment_id}&p_id={$post_id}'>Approve</a></td>";
                                                    echo "<td></td>";
                                                }
                                                // echo "<td><a href='comments.php?approve={$comment_id}'>Approve</a></td>";
                                                // echo "<td><a href='comments.php?unapprove={$comment_id}'>Unapprove</a></td>";
                                                echo "<td><a href='comments.php?delete={$comment_id}&p_id={$post_id}'>Delete</a></td>";
                                                echo "</tr>";
                                            }
                                        }

                                        approve_comment();
                                        unapprove_comment();
                                        delete_comment();
                                    }
                                ?>
                                <!-- <tr>
                                    <td>10</td>
                                    <td>Edwin Diaz</td>
                                    <td>Bootstrap framework</td>
                                    <td>Bootstrap</td>
                                    <td>Status</td>
                                    <td>Image</td>
                                    <td>Tags</td>
                                    <td>Comments</td>
                                    <td>Date</td>
                                </tr> -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php include "includes/admin_footer.php"; ?>