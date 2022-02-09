<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/cms/index">CMS Front</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php
                    $query = "SELECT * FROM categories";
                    $select_all_categories_query = mysqli_query($connection, $query);

                    while($row = mysqli_fetch_assoc($select_all_categories_query)){
                        $cat_id = $row['cat_id'];
                        $cat_title = $row['cat_title'];

                        $category_class = '';

                        if(isset($_GET['category']) && $_GET['category'] == $cat_id){
                            $category_class = 'active';
                        } 
                        echo "<li class='$category_class'><a href='/cms/category/$cat_id'>{$cat_title}</a></li>";
                    }
                ?>
            </ul>
            <ul class="nav navbar-right navbar-nav">
                <?php
                    $pageName = basename($_SERVER['PHP_SELF']);
                    $registration_class = '';
                    $contacts_class = '';
                    $registration_class = '';
                    if($pageName == 'registration.php'){
                        $registration_class = 'active';
                    }
                    if($pageName == 'contact.php'){
                        $contacts_class = 'active';
                    }
                    
                    if($pageName == 'login.php'){
                        $login_class = 'active';
                    }
                    if(isLoggedIn()){
                        if(isset($_GET['p_id'])){
                            $p_id = $_GET['p_id'];
                            ?>
                                <li>
                                    <a href="admin/posts.php?source=edit_post&edit=<?php echo $p_id; ?>">Edit post</a>
                                </li>
                            <?php
                        }
                        if(is_admin($_SESSION['username'])){
                            ?>
                            <li>
                                <a href="/cms/admin">Admin</a>
                            </li>
                            <?php
                        }
                        ?>
                        <li>
                            
                            <a href="../includes/logout.php">Logout</a>
                        </li>
                        <?php
                    } else {
                        ?>
                        <li class='<?php echo $login_class ?>'>
                            <a href="/cms/login">Login</a>
                        </li>
                        <li class='<?php echo $registration_class ?>'>
                            <a href="/cms/registration">Registration</a>
                        </li>
                        <?php
                    }
                    ?>
                    <li class='<?php echo $contacts_class ?>'>
                        <a href="/cms/contact">Contacts</a>
                    </li>
                    <?php
                ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>