<?php include "delete_modal.php"; ?>
<?php
    if(isset($_POST['checkBoxArray'])){
        foreach($_POST['checkBoxArray'] as $postValueId){
            $postValueId = escape($postValueId);
            $bulk_options = $_POST['bulk_options'];
            switch($bulk_options){
                case 'delete':
                    $query = "DELETE FROM posts WHERE post_id = {$postValueId}";
                    $delete_post = mysqli_query($connection, $query);
                    confirmQuery($delete_post);
                    header("Location: posts.php");

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
                <option value="delete">Delete</option>
            </select>
        </div>
        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
        </div>
        <br><br>
        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox"></th>
                <th>ID</th>
                <th>Author</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>Views</th>
                <th>View Post</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
                //Se existir parametros iguais é necessario atribuir uma identificador a cada tabela, por exemplo: posts p, 
                //depois é necessário chamar o parametro assim, p.post_id
                $user_id = $_SESSION['user_id'];
                $query = "SELECT posts.post_id, posts.post_user, posts.post_title, categories.cat_title, posts.post_status, posts.post_image, posts.post_tags, posts.post_comment_count, ";
                $query .= "posts.post_date, posts.post_views_count ";
                $query .= "FROM posts ";
                $query .= "LEFT JOIN categories ON posts.post_category_id = categories.cat_id ";
                //Utilizar para a dashboard users
                $query .= "WHERE posts.post_user = " . $_SESSION['user_id'] . " ";
                $query .= "ORDER BY posts.post_id DESC";
                $select_all_posts_query = mysqli_query($connection,$query);
                confirmQuery($select_all_posts_query);
                
                while($row = mysqli_fetch_assoc($select_all_posts_query)){
                    $post_id = escape($row['post_id']);
                    $post_title = escape($row['post_title']);
                    $cat_title = escape($row['cat_title']);
                    $post_user = escape($row['post_user']);
                    $post_date = escape($row['post_date']);
                    $post_image = escape($row['post_image']);
                    // $post_content = $row['post_content'];
                    $post_tags = escape($row['post_tags']);
                    $post_status = escape($row['post_status']);
                    $post_views_count = escape($row['post_views_count']);

                    echo "<tr>";
                    ?>
                        <td><input class="checkBoxes" type="checkbox" name="checkBoxArray[]" value = "<?php echo $post_id; ?>"></td>
                    <?php
                    echo "<td>{$post_id}</td>";

                    $query = "SELECT username, user_firstname, user_lastname FROM users, posts WHERE post_user = user_id && post_user = $post_user";
                    $select_user = mysqli_query($connection,$query);
                    confirmQuery($select_user);
                    $row = mysqli_fetch_assoc($select_user);
                    $username = $row['username'];
                    $user_firstname = $row['user_firstname'];
                    $user_lastname = $row['user_lastname'];
                    if(!empty($user_firstname) && !empty($user_lastname)){
                        echo "<td>" . $user_firstname . " " . $user_lastname . "</td>";
                    } else {
                        echo "<td>{$username}</td>";
                    }

                    echo "<td>{$post_title}</td>";
                    echo "<td>{$cat_title}</td>";
                    echo "<td>{$post_status}</td>";
                    echo "<td width = 100px><img class='img-responsive' src='../images/" . imagePlaceholder($post_image) . "' alt=''></td>";
                    echo "<td>{$post_tags}</td>";

                    $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                    $send_comment_query = mysqli_query($connection, $query);
                    confirmQuery($send_comment_query);
                    $count_comments = mysqli_num_rows($send_comment_query);
                    echo "<td><a href='post_comments.php?id={$post_id}'>{$count_comments}</a></td>";

                    echo "<td>{$post_date}</td>";
                    echo "<td>{$post_views_count}</td>";
                    echo "<td><a href='../post.php?p_id={$post_id}'>View Post</a></td>";
                    echo "<td><a href='posts.php?source=edit_post&edit={$post_id}'>Edit</a></td>";
                    //echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?') \" href='posts.php?delete={$post_id}'>Delete</a></td>";
                    echo "<td><a rel='{$post_id}' class='btn btn-danger delete_link' href='javascript:void(0)'>Delete</a></td>";
                    echo "</tr>";
                }

                reset_views();
                delete_post();
            ?>
        </tbody>
    </table>
</form>

<script>
    $(document).ready(function() {
        $(".delete_link").on('click', function(){
            var id = $(this).attr("rel");
            // var delete_url = "posts.php?delete=" + id + " ";
            // $(".modal_delete_link").attr("href", delete_url);
            $(".modal_delete_link").attr("value", id);
            $("#myModal").modal('show');
        });
    });
</script>