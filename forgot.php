<?php use PHPMailer\PHPMailer\PHPMailer; ?>
<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<?php 
    require 'vendor/autoload.php';

    if(!isset($_GET['forgot'])){
        redirect('index');
    }

    if(ifItIsMethod('post')){
        if(isset($_POST['email'])){
            $email = escape($_POST['email']);
            $length = 50;
            $token = bin2hex(openssl_random_pseudo_bytes($length));

            if(email_exists($email)){
                if($stmt = mysqli_prepare($connection, "UPDATE users SET token='$token' WHERE user_email = ?")){
                    mysqli_stmt_bind_param($stmt, "s", $email);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);

                    //Configure PHPMailer
                    $mail = new PHPMailer(); 

                    $mail->isSMTP();                                    // Set mailer to use SMTP 
                    $mail->Host = Config::SMTP_HOST;                    // Specify main and backup SMTP servers 
                    $mail->Username = Config::SMTP_USER;                // SMTP username 
                    $mail->Password = Config::SMTP_PASSWORD;            // SMTP password 
                    $mail->Port = Config::SMTP_PORT;                    // TCP port to connect to 
                    $mail->SMTPAuth = true;                             // Enable SMTP authentication 
                    $mail->SMTPSecure = 'tls';                          // Enable TLS encryption, `ssl` also accepted 
                    $mail->isHTML(true);
                    $mail->CharSet = 'UTF-8';                   

                    $mail->setFrom('josefgouveia9@gmail.com', 'Jose Gouveia');
                    $mail->addAddress($email);
                    
                    $mail->Subject = "This is a test email";
                    
                    $mail->Body = "<p>Please click to reset your password</p>
                    <a href='https://localhost/cms/reset.php?email=".$email."&token=".$token."'>https://localhost/cms/reset.php?email=".$email."&token=".$token."</a>
                    ";

                    if(!$mail->send()) { 
                        $message = 'Your Contact Form could not be sent. Mailer Error: '.$mail->ErrorInfo; 
                    } else { 
                        $emailSent = true;
                        $message = 'It has been sent a recovery email, please check your email.'; 
                    } 
                }
            } else {
                $message = "Your email doesn't exist in our database.";
            }
        }
    } else {
        $message = "";
    }
?>

<!-- Navigation -->
<?php include "includes/navigation.php";?>

<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 me-auto ms-auto" style="margin-top: 20px;">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
                            
                                <?php if(!isset($emailSent)):?>
                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center" style="color:white">Forgot Password?</h2>
                                <p style="color:white; margin-bottom: 30px">You can reset your password here.</p>
                                <div class="panel-body">




                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group" style="margin-bottom: 10px;">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-danger btn-block" value="Reset Password" type="submit" style="width: 100%;">
                                        </div>
                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>
                                    <h6 class="text-center"><?php echo $message;?></h6>

                                </div><!-- Body-->

                                <?php else: ?>

                                    <h2>Please check your email</h2>

                                <?php endif;?> 

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->

