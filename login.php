<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link rel = "icon" href ="/img/logo_2.png" type ="image/x-icon">
		<link rel="stylesheet" href="/css/bootstrap.min.css" />
		<link rel="stylesheet" href="/css/floating-labels.css" />
	</head>
	<body>
		<form class="form-signin" id="user_sign_in_form" action="" method="post" name="user_sign_in_form">
		  <div class="text-center mb-4">
		    <img class="mb-4" src="/img/logo_2.png" alt="" width="100" height="100">
		    <h1 class="h3 mb-3 font-weight-normal">Login</h1>
		  </div>

		  <div id="user_sign_in_msg"></div>

		  <div class="form-label-group">
		    <input type="text" name="user_email" id="user_email" class="form-control" placeholder="Email" required autofocus>
		    <label for="user_email">Username</label>
		  </div>

		  <div class="form-label-group">
		    <input type="password" name="user_password" id="user_password" class="form-control" placeholder="Password" required>
		    <label for="user_password">Password</label>
		  </div>

		  <button class="btn btn-lg btn-primary btn-block" id="user_sign_in" name="submit" type="submit">Sign in</button>
		  <div class="checkbox mb-3">
		  	<!--<p>Do Not Have An Account? <a href='/layout/items/user_admin_sheet.php'>New Facility</a>, <a href='#' id='sign_in_help'>Click for help</a></p>
		  	<label>
		      <input type="checkbox" value="remember-me"> Remember me
		    </label>-->
		  </div>
		  <p class="mt-5 mb-3 text-muted text-center">Copyright &copy; HealthNotes <?php echo date("Y");?></p>
		</form>
		<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>
	</body>
</html>