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
                            Categories
                        </h1>

                        <div class="col-xs-6">

                            <?php insert_categories();?>

                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="cat-title">Add Category</label>
                                    <input class = "form-control" type="text" name="cat_title">
                                </div>
                                <div class="form-group">
                                    <input class = "btn btn-primary" type="submit" name="submit" value="Add Category">
                                </div>
                            </form>
                            <br><br>
                            <?php //Update and include query
                                if(isset($_GET['edit'])){
                                    $cat_id = $_GET['edit']; //Necessario?? Visto que já está presente no update_categories.php

                                    include "includes/update_categories.php";
                                }
                            ?>

                        </div>

                        <div class="col-xs-6">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Category Title</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php findAllCategories();?>

                                    <?php deleteCategories();?>
                                </tbody>
                            </table>
                        </div>

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
