<?php
    if(isset($_POST['checkBoxArray'])){
        foreach($_POST['checkBoxArray'] as $postValueId){
            $postValueId = escape($postValueId);
            $bulk_options = $_POST['bulk_options'];
            switch($bulk_options){
                case 'approved':
                    $query = "UPDATE comments SET comment_status = '{$bulk_options}' WHERE comment_id = {$postValueId}";
                    $update_to_approved_status = mysqli_query($connection, $query);
                    confirmQuery($update_to_approved_status);
                    header("Location: comments.php");

                    break;

                case 'unapproved':
                    $query = "UPDATE comments SET comment_status = '{$bulk_options}' WHERE comment_id = {$postValueId}";
                    $update_to_unapproved_status = mysqli_query($connection, $query);
                    confirmQuery($update_to_unapproved_status);
                    header("Location: comments.php");

                    break;

                case 'delete':
                    $query = "DELETE FROM comments WHERE comment_id = {$postValueId}";
                    $delete_comment = mysqli_query($connection, $query);
                    confirmQuery($delete_comment);
                    header("Location: comments.php");

                    break;
            }
        }
    }
?>
<form action="" method="post">
    <table class="table table-bordered table-hover">
        <div id="bulkOptionContainer" class="col-xs-4">
            <select class="form-control" name="bulk_options" id="bulk_options">
                <option value="">Select Options</option>
                <option value="approved">Approved</option>
                <option value="unapproved">Unapproved</option>
                <option value="delete">Delete</option>
            </select>
        </div>
        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
        </div>
        <br><br>
        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox"></th>
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
                $query = "SELECT c.comment_id, p.post_id, p.post_title, c.comment_author, c.comment_email, c.comment_content, c.comment_status, c.comment_date FROM posts p, comments c WHERE c.comment_post_id = p.post_id";
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
                        ?>
                            <td><input class="checkBoxes" type="checkbox" name="checkBoxArray[]" value = "<?php echo $comment_id; ?>"></td>
                        <?php
                        echo "<td>{$comment_id}</td>";
                        echo "<td>{$comment_author}</td>";
                        echo "<td>{$comment_content}</td>";
                        echo "<td>{$comment_email}</td>";
                        echo "<td>{$comment_status}</td>";
                        echo "<td><a href='../post.php?p_id=$post_id'>{$post_title}</td></a>";
                        echo "<td>{$comment_date}</td>";
                        if($comment_status == "approved"){
                            echo "<td></td>";
                            echo "<td><a href='comments.php?unapprove={$comment_id}'>Unapprove</a></td>";
                        } else {
                            echo "<td><a href='comments.php?approve={$comment_id}'>Approve</a></td>";
                            echo "<td></td>";
                        }
                        // echo "<td><a href='comments.php?approve={$comment_id}'>Approve</a></td>";
                        // echo "<td><a href='comments.php?unapprove={$comment_id}'>Unapprove</a></td>";
                        echo "<td><a href='comments.php?delete={$comment_id}'>Delete</a></td>";
                        echo "</tr>";
                    }
                }

                approve_comment();
                unapprove_comment();
                delete_comment();
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
</form>