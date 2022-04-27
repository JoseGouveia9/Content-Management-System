<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<?php  
    checkIfUserIsLoggedInAndRedirect('/cms/index');

    if(ifItIsMethod('post')){
        if(isset($_POST['login'])){
            login_user($_POST['username'],$_POST['password']);
        } else {
            redirect('/cms/login');
        }
    }
?>

<!-- Navigation -->

<?php  include "includes/navigation.php"; ?>


<!-- Page Content -->
<div class="container">

	<div class="form-gap"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-4 me-auto ms-auto" style="margin-top: 20px;">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="text-center">

							<h2 class="text-center" style="color:white; margin-bottom: 30px">Login</h2>
							<div class="panel-body">


								<form id="login-form" role="form" autocomplete="off" class="form" method="post">

									<div class="form-group" style="margin-bottom: 10px;">
										<div class="input-group">
											<span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>

											<input name="username" type="text" class="form-control" placeholder="Enter Username">
										</div>
									</div>

									<div class="form-group" style="margin-bottom: 10px;">
										<div class="input-group">
											<span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
											<input name="password" type="password" class="form-control" placeholder="Enter Password">
										</div>
									</div>

									<div class="form-group">
										<input name="login" class="btn btn-lg btn-danger btn-block" value="Login" type="submit" style="width: 100%;">
									</div>


								</form>

							</div><!-- Body-->

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<hr>

	<?php include "includes/footer.php";?>

</div> <!-- /.container -->
