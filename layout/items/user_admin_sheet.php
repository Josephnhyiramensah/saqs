<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
	<title>Login</title>
	<link rel = "icon" href ="/img/goldchest_2.png" type ="image/x-icon">
	<link rel="stylesheet" href="/css/bootstrap.min.css" />
	<link rel="stylesheet" href="/css/floating-labels.css" />
	</head>
	<body>
		<form class="form-signin" id="user_admin_create_form" name="user_admin_create_form">
		  <div class="text-center mb-4">
		    <img class="mb-4" src="/img/goldchest_2.png" alt="" width="72" height="72">
		    <h1 class="h3 mb-3 font-weight-normal">Sign Up</h1>

			<div id="user_admin_form_msg"></div>

		  </div>

		  <div class="form-label-group">
		    <input type="text" name="user_admin_name" id="user_admin_name" class="form-control" placeholder="Email" required autofocus>
		    <label for="user_admin_name">Name</label>
		  </div>

		  <div class="form-label-group">
		    <input type="text" name="user_admin_email" id="user_admin_email" class="form-control" placeholder="Email" required>
		    <label for="user_admin_email">Email</label>
		  </div>

		  <div class="form-label-group">
		    <input type="password" name="user_admin_password" id="user_admin_password" class="form-control" placeholder="Password" required>
		    <label for="user_admin_password">Password</label>
		  </div>

		  <div class="form-label-group">
		    <input type="password" name="user_admin_password_confirm" id="user_admin_password_confirm" class="form-control" placeholder="Confirm Password" required>
		    <label for="user_admin_password_confirm">Confirm Password</label>
		  </div>

		  <div class="form-label-group">
		    <input type="text" name="user_admin_telephone" id="user_admin_telephone" class="form-control" placeholder="Telephone" required>
		    <label for="user_admin_telephone">Telephone</label>
		  </div>

		  <button class="btn btn-lg btn-primary btn-block" id="user_admin_save_btn" name="user_admin_save_btn">Sign Up</button>
		  <div class="checkbox mb-3">
		  	<p>Already Have An Account? <a href='/login.php'>Sign In</a></p>
		    <!--<label>
		      <input type="checkbox" value="remember-me"> Remember me
		    </label>-->
		  </div>
		  <p class="mt-5 mb-3 text-muted text-center">Copyright &copy; Goldchest <?php echo date("Y");?></p>
		</form>


		<?php include($_SERVER['DOCUMENT_ROOT'].'/includes/scripts_main.php');?>
	</body>
</html>