<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php 
    use PHPMailer\PHPMailer\PHPMailer;

    //Load Composer's autoloader
    require 'vendor/autoload.php';

    // require 'vendor/phpmailer/phpmailer/src/Exception.php'; 
    // require 'vendor/phpmailer/phpmailer/src/PHPMailer.php'; 
    // require 'vendor/phpmailer/phpmailer/src/SMTP.php';
?>
<?php
    if(isset($_POST['submit'])){
        $to = "support@josegouveia.epizy.com";
        //$header = "From: " . $_POST['email'];  Não funciona devido ao host
        //https://forum.infinityfree.net/docs?topic=49242
        $header = escape($_POST['email']);
        $subject = escape(wordwrap($_POST['subject'], 70));
        $body = escape($_POST['body']); 

        if(!empty($header) && !empty($subject) && !empty($body)){

        //mail($to, $subject, $body, $header); Não funciona devido ao host
        //https://forum.infinityfree.net/docs?topic=49242
 
        //Created an objecto of PHPMailer
        $mail = new PHPMailer; 

        $mail->isSMTP();                      // Set mailer to use SMTP 
        $mail->Host = 'smtp.mailtrap.io';      // Specify main and backup SMTP servers 
        $mail->SMTPAuth = true;               // Enable SMTP authentication 
        $mail->Username = 'fff82afd7c11f7';   // SMTP username 
        $mail->Password = '479b04b24b09e4';   // SMTP password 
        $mail->SMTPSecure = 'tls';            // Enable TLS encryption, `ssl` also accepted 
        $mail->Port = 2525;                    // TCP port to connect to 
        
        // Sender info 
        $mail->setFrom($header); 
        //$mail->addReplyTo('reply@gmail.com'); 
        
        // Add a recipient 
        $mail->addAddress($to); 
        
        //$mail->addCC('cc@example.com'); 
        //$mail->addBCC('bcc@example.com'); 
        
        // Set email format to HTML 
        $mail->isHTML(true); 
        
        // Mail subject 
        $mail->Subject = $subject; 
        
        // Mail body content 
        $mail->Body = $body; 
        
        // Send email 
        if(!$mail->send()) { 
            $message = 'Your Contact Form could not be sent. Mailer Error: '.$mail->ErrorInfo; 
        } else { 
            $message = 'Your Contact Form has been submitted.'; 
        } 
    } else {
        $message = "Fields cannot be empty";
    }
} else {
    $message = "";
}
?>


    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 me-auto ms-auto" style="margin-top: 20px;">
                <div class="form-wrap">
                <h2 style="color:white; margin-bottom: 30px">Contact</h2>
                    <form role="form" action="contact.php" method="post" id="login-form" autocomplete="off">
                        <h6 class="text-center"><?php echo $message;?></h6>
                         <div class="form-group" style="margin-bottom: 10px;">
                            <label for="email" class="sr-only" style="color:white;">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your Email">
                        </div>
                        <div class="form-group" style="margin-bottom: 10px;">
                            <label for="subject" class="sr-only" style="color:white;">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter your Subject">
                        </div>
                        <div class="form-group" style="margin-bottom: 10px;">
                           <textarea class="form-control" name="body" id="body" cols="50" rows="10"></textarea>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-danger btn-lg btn-block" value="Submit" style="width: 100%;">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
