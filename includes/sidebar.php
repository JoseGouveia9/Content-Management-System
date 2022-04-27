<div class="col-md-3 me-auto categories-sidebar">

    <!-- Blog Categories Well -->
    <div class="well">
        <div class="row">
            <h4>Categories</h4>
        </div>
        <div class="row">
            <div class="col-lg-12" style="padding:0px">
                <ul class="list-unstyled" style="margin: 0px">
                    <?php
                        $query = "SELECT * FROM categories";
                        $select_all_categories_query = mysqli_query($connection, $query);

                        while($row = mysqli_fetch_assoc($select_all_categories_query)){
                            $cat_id = $row['cat_id'];
                            $cat_title = $row['cat_title'];
                            echo "<a href='category.php?category=$cat_id'><li>{$cat_title}</li></a>";
                        }
                    ?>
                    <!-- <li><a href="#">Category Name</a>
                    </li>
                    <li><a href="#">Category Name</a>
                    </li>
                    <li><a href="#">Category Name</a>
                    </li>
                    <li><a href="#">Category Name</a>
                    </li>
                </ul> -->
            </div>
            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
    </div>
</div>