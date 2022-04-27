<div class="container" style="background-color: rgb(170 0 0); margin:0px; max-width:none">
    <div class="container">
        
    <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container" style="padding: 0">
        <a class="navbar-brand" href="/cms/index">
            <img src="/cms/images/moustache.png" alt="" width="50" height="50">
            <img src="/cms/images/Novo Projeto1.png" alt="" width="90">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto">
            <?php
                $pageName = basename($_SERVER['PHP_SELF']);
                $login_class = '';
                $contacts_class = '';
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
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="admin/posts.php?source=edit_post&edit=<?php echo $p_id; ?>">Edit post</a>
                            </li>
                        <?php
                    }
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/cms/admin">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/cms/includes/logout.php">Logout</a>
                    </li>
                    <?php
                } else {
                    ?>
                    <li class="nav-item dropdown login-desktop">
                        <a class="nav-link" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Login
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end p-2" aria-labelledby="navbarScrollingDropdown" style="width: 240px">
                            <form action="login.php" method="post">
                                <div class="form-group" style="margin-bottom: 10px;">
                                    <label for="usernamelogin">Username</label>
                                    <input id="usernamelogin" name="username" type="text" class="form-control" placeholder="Enter username">
                                </div>
                                <div class="form-group"  style="margin-bottom: 10px;">
                                    <label for="passwordlogin">Password</label>
                                    <input id="usernamelogin" name="password" type="password" class="form-control" placeholder="Enter password">
                                </div>
                                <button class="btn btn-danger" name="login" type="submit" style="width: 100%;">Submit</button>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/cms/registration">New around here? Sign up</a>
                                <a class="dropdown-item" href="forgot.php?forgot=<?php echo uniqid(true); ?>">Forgot Password?</a>
                            </form>
                        </ul>
                    </li>
                    <li class="nav-item login-mobile <?php echo $login_class ?>">
                        <a class="nav-link" aria-current="page" href="/cms/login">Login</a>
                    </li>
                    <?php
                }
                ?>
                <li class="nav-item <?php echo $contacts_class ?>">
                    <a class="nav-link" aria-current="page" href="/cms/contact">Contacts</a>
                </li>
                <?php
            ?>
        </ul>
        </div>
    </div>
    </nav>
    </div>
    <?php 
        $pageName = basename($_SERVER['PHP_SELF']); 
        if($pageName == 'index.php'){?>
            <div class="container" style="display: flex; height: 200px; flex-direction: column; justify-content: flex-end; align-items: flex-start;">
                <label for="searchBat" style="margin-bottom: 20px; font-size: 40px; font-family:fantasy; color:white">Welcome to Moustache Forum</label>        
                <form action="search.php" method="post" style="width: 100%">
                    <div class="input-group mb-3">
                        <span class="input-group-btn" id="basic-addon1" style="border-top-right-radius: 0;border-bottom-right-radius: 0;background-color: #e9ecef;border: 1px solid #ced4da;border-top-left-radius: 0.25rem;;border-bottom-left-radius: 0.25rem;">
                                <button name="submit" class="btn btn-default" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path>
                                </svg>
                                </button>
                        </span>
                        <input name="search" type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
                    </div>
                </form>
            </div>
        <?php }
    ?>
</div>