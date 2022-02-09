<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">CMS</a>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <!-- <li><a href=""><i class="fa fa-fw fa-users"></i>Users Online: 
        <?php //echo users_online()?>
        </a></li> -->
        <li><a href="javascript:;"><i class="fa fa-fw fa-users"></i> Users Online: <span class="useronline"></span></a></li>
        <li><a href="../index.php"><i class="fa fa-fw fa-home"></i> Home</a></li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['firstname'] . " " .  $_SESSION['lastname']; ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <?php
            $pageName = basename($_SERVER['PHP_SELF']);
            $dashboard_class = '';
            $mydata_class = '';
            $posts_class = '';
            $categories_class = '';
            $comments_class = '';
            $users_class = '';
            $profile_class = '';
            $posts_dropdown = 'collapse';
            $users_dropdown = 'collapse';
            $comments_dropdown = 'collapse';
            if($pageName == 'index.php'){
                $mydata_class = 'active';
            }
            if($pageName == 'dashboard.php'){
                $dashboard_class = 'active';
            }
            if($pageName == 'posts.php'){
                $posts_class = 'active';
                $posts_dropdown = 'collapse in';
            }
            if($pageName == 'categories.php'){
                $categories_class = 'active';
            }
            if($pageName == 'comments.php'){
                $comments_class = 'active';
                $comments_dropdown = 'collapse in';
            }
            if($pageName == 'users.php'){
                $users_class = 'active';
                $users_dropdown = 'collapse in';
            }
            if($pageName == 'profile.php'){
                $profile_class = 'active';
            }?>
            <li class='<?php echo $mydata_class; ?>'>
                <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> My Data</a>
            </li>

            <?php if(is_admin()){?>
                <li class='<?php echo $dashboard_class; ?>'>
                    <a href="dashboard.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                </li>
            <?php
            } ?>            
            <?php if(is_admin()){ ?>
                <li class='<?php echo $posts_class; ?>'>
                    <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-file-text"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="posts_dropdown" class='<?php echo $posts_dropdown; ?>'>
                        <li>
                            <a href="./posts.php">My Posts</a>
                        </li>
                        <li>
                            <a href="./posts.php?source=all">View All Posts</a>
                        </li>
                        <li>
                            <a href="./posts.php?source=add_post">Add Posts</a>
                        </li>
                    </ul>
                </li>
            <?php } else { ?>
                <li class='<?php echo $posts_class; ?>'>
                    <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-file-text"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="posts_dropdown" class='<?php echo $posts_dropdown; ?>'>
                        <li>
                            <a href="./posts.php">My Posts</a>
                        </li>
                        <li>
                            <a href="./posts.php?source=add_post">Add Posts</a>
                        </li>
                    </ul>
                </li>
            </li>
            <?php } ?>
            <?php if(is_admin()){?>
                <li class='<?php echo $categories_class; ?>'>
                    <a href="./categories.php"><i class="fa fa-fw fa-list"></i> Categories</a>
                </li>
            <?php
            } ?> 
            <?php if(is_admin()){ ?>
                <li class='<?php echo $comments_class; ?>'>
                <a href="javascript:;" data-toggle="collapse" data-target="#comments_dropdown"><i class="fa fa-fw fa-comments"></i> Comments <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="comments_dropdown" class='<?php echo $comments_dropdown; ?>'>
                    <li>
                        <a href="./comments.php">View All Comments</a>
                    </li>
                    <li>
                        <a href="./comments.php?source=my_comments">My Comments</a>
                    </li>
                </ul>
            </li>
            <?php } else { ?>
                <li class='<?php echo $comments_class; ?>'>
                <a href="./comments.php?source=my_comments"><i class="fa fa-fw fa-comments"></i> Comments</a>
            </li>
            <?php } ?>
            <?php if(is_admin()){?>
                <li class='<?php echo $users_class; ?>'>
                    <a href="javascript:;" data-toggle="collapse" data-target="#users_dropdown"><i class="fa fa-fw fa-users"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="users_dropdown" class='<?php echo $users_dropdown; ?>'>
                        <li>
                            <a href="./users.php">View All Users</a>
                        </li>
                        <li>
                            <a href="./users.php?source=add_user">Add User</a>
                        </li>
                    </ul>
                </li>
            <?php
            } ?>
            <li class='<?php echo $profile_class; ?>'>
                <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
            </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>