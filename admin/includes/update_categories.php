<?php
    //Feito por mim
    /* //Update query
    if(isset($_POST['update_category'])){
        $the_cat_title = $_POST['cat_title'];

        if($the_cat_title == "" || empty($the_cat_title)){
            echo "This field should not be empty";
        } else {
            $query = "UPDATE categories SET cat_title = '$the_cat_title' WHERE cat_id = $_GET[edit]";
            $update_query = mysqli_query($connection,$query);
            
            if(!$update_query){
                die("Query failed" . mysqli_error($connection));
            } else {
                header("Location: categories.php");
            }
        }
    }


    //Edit selected category
    if(isset($_GET['edit'])){
        $cat_id = $_GET['edit'];

        $query = "SELECT * FROM categories WHERE cat_id = $cat_id";
        $select_categories_id = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($select_categories_id)){
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="cat-title">Edit Category</label>
                    <input value="<?php if(isset($cat_title)){echo $cat_title;} ?>" class="form-control" type="text" name="cat_title">
                </div>
                <div class="form-group">
                    <input class = "btn btn-primary" type="submit" name="update_category" value="Update Category">
                </div>
            </form>
            <?php
        }
    } */
?>

<?php
    //Update query
    if(isset($_POST['update_category'])){
        $the_cat_title = $_POST['cat_title'];

        if($the_cat_title == "" || empty($the_cat_title)){
            echo "This field should not be empty";
        } else {
            $stmt = mysqli_prepare($connection, "UPDATE categories SET cat_title = ? WHERE cat_id = ?");
            $the_cat_id = $_GET['edit'];
            mysqli_stmt_bind_param($stmt, "si", $the_cat_title, $the_cat_id); //"i" if it's a interger, "is" if it's a interger and string
            mysqli_stmt_execute($stmt);
            confirmQuery($stmt);

            mysqli_stmt_close($stmt);
            // $query = "UPDATE categories SET cat_title = '$the_cat_title' WHERE cat_id = $_GET[edit]";
            // $update_query = mysqli_query($connection,$query);
            // confirmQuery($update_query);
            
            echo "<p class='bg-success'>Category Updated!</p>";
        }
    }
?>

<form action="" method="post">
    <div class="form-group">
        <label for="cat-title">Edit Category</label>

        <?php
            //Edit selected category
            if(isset($_GET['edit'])){
                $cat_id = escape($_GET['edit']);

                $query = "SELECT * FROM categories WHERE cat_id = $cat_id";
                $select_categories_id = mysqli_query($connection, $query);

                while($row = mysqli_fetch_assoc($select_categories_id)){
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];?>
                        <input value="<?php if(isset($cat_title)){echo $cat_title;} ?>" class="form-control" type="text" name="cat_title"> 
                    <?php
                }
            }
        ?>

        
        
    </div>
    <div class="form-group">
        <input class = "btn btn-primary" type="submit" name="update_category" value="Update Category">
    </div>
</form>