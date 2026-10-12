<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
	<title>Sign Up</title>
	<link rel = "icon" href ="/img/goldchest_2.png" type ="image/x-icon">
	<link rel="stylesheet" href="/css/bootstrap.min.css" />
	<link rel="stylesheet" href="/css/floating-labels.css" />
	</head>
	<body>
		<form class="form-signin" id="user_psi_create_form" name="user_psi_create_form">
		  <div class="text-center mb-4">
		    <img class="mb-4" src="/img/goldchest_2.png" alt="" width="72" height="72">
		    <h1 class="h3 mb-3 font-weight-normal">Sign Up</h1>

			<div id="user_psi_form_msg"></div>

		  </div>

		  <div class="form-label-group">
		    <input type="text" name="user_psi_name" id="user_psi_name" class="form-control" placeholder="Email" required autofocus>
		    <label for="user_psi_name">Name</label>
		  </div>

		  <div class="form-label-group">
		    <input type="text" name="user_psi_email" id="user_psi_email" class="form-control" placeholder="Email" required>
		    <label for="user_psi_email">Email</label>
		  </div>

		  <div class="form-label-group">
		    <input type="password" name="user_psi_password" id="user_psi_password" class="form-control" placeholder="Password" required>
		    <label for="user_psi_password">Password</label>
		  </div>

		  <div class="form-label-group">
		    <input type="password" name="user_psi_password_confirm" id="user_psi_password_confirm" class="form-control" placeholder="Confirm Password" required>
		    <label for="user_psi_password_confirm">Confirm Password</label>
		  </div>

		  <div class="form-label-group">
		    <input type="text" name="user_psi_telephone" id="user_psi_telephone" class="form-control" placeholder="Telephone" required>
		    <label for="user_psi_telephone">Telephone</label>
		  </div>

		  <button class="btn btn-lg btn-primary btn-block" id="user_psi_save_btn" name="user_psi_save_btn">Sign Up</button>
		  <div class="checkbox mb-3">
		  	<p>Already Have An Account? <a href='/login.php'>Sign In</a></p>
		    <!--<label>
		      <input type="checkbox" value="remember-me"> Remember me
		    </label>-->
		  </div>
          <?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
		</form>
		<?php include($_SERVER['DOCUMENT_ROOT'].'/includes/scripts_main.php');?>
	</body>
</html>