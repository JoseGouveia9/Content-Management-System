<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<?php
    if(isset($_GET['lang']) && !empty($_GET['lang'])){
        $_SESSION['lang'] = $_GET['lang'];

        if(isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']){
            echo "<script 'text'/javascript>location.reload();</script>";
        }

        if(isset($_SESSION['lang'])){
            include "includes/languages/" . $_SESSION['lang'] . ".php";
        } else {
            include "includes/languages/en.php";
        }
    } else {
        include "includes/languages/en.php";
    }




    // if(isset($_POST['register'])){
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $error = [
            'username' => '',
            'email' => '',
            'password' => ''
        ];

        if(strlen($username) < 4){
            $error['username'] = 'Username needs to be longer';
        }

        if(empty($username)){
            $error['username'] = 'Username cannot be empty';
        }

        if(username_exists($username)){
            $error['username'] = "This username already exists, pick another one";
        }

        if(empty($email)){
            $error['email'] = 'Email cannot be empty';
        }

        if(email_exists($email)){
            $error['email'] = "This email already exists, please <a href ='index.php'>login</a>";
        }

        if(empty($password)){
            $error['password'] = 'Password cannot be empty';
        }

        foreach($error as $key => $value){
            if(empty($value)){
                unset($error[$key]);
            }
        }

        if(empty($error)){
            register_user($username, $email, $password);
            login_user($username, $password);
        }
    }
?>


    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <form method="get" class="navbar-form navbar-right" action="" id="language_form">
            <div class="form-group col-md-2 ms-auto" style="margin-top:20px">
                <select class="form-select" name="lang" onchange="changeLanguage()">
                    <option value="en" <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'en'){ echo "selected"; }?>>English</option>
                    <option value="pt" <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'pt'){ echo "selected"; }?>>Português</option>
                </select>
            </div>
        </form>
        <div class="row">
            <div class="col-xs-6 me-auto ms-auto">
                <div class="form-wrap">
                <h2 style="color:white; margin-bottom: 30px"><?php echo _REGISTER ?></h2>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <div class="form-group" style="margin-bottom: 10px;">
                            <label for="username" class="sr-only" style="color:white;">Username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="<?php echo _USERNAME ?>" 
                            autocomplete="on"
                            value="<?php echo isset($username) ? $username : '' ?>"
                            >
                            <p><?php echo isset($error['username']) ? $error['username'] : '' ?></p>
                        </div>
                         <div class="form-group" style="margin-bottom: 10px;">
                            <label for="email" class="sr-only" style="color:white;">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="<?php echo _EMAIL ?>"
                            autocomplete="on"
                            value="<?php echo isset($email) ? $email : '' ?>">
                            <p><?php echo isset($error['email']) ? $error['email'] : '' ?></p>
                        </div>
                         <div class="form-group" style="margin-bottom: 10px;">
                            <label for="password" class="sr-only" style="color:white;">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="<?php echo _PASSWORD ?>">
                            <p><?php echo isset($error['password']) ? $error['password'] : '' ?></p>
                        </div>
                
                        <input type="submit" name="register" id="btn-login" class="btn btn-danger btn-lg btn-block" value="Register" style="width: 100%;">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>

<script>
    function changeLanguage(){
        document.getElementById('language_form').submit();
    }
</script>



<?php include "includes/footer.php";?>
