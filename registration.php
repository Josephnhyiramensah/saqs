<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Registration</title>
		<link rel = "icon" href ="img/popular_requests.png" type ="image/x-icon">
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/floating-labels.css" />
	</head>
	<body>
		<?php
		require('includes/db.php');
		// If form submitted, insert values into the database.
		if (isset($_REQUEST['username'])){
		        // removes backslashes
		 $username = stripslashes($_REQUEST['username']);
		        //escapes special characters in a string
		 $username = mysqli_real_escape_string($con,$username); 
		 $email = stripslashes($_REQUEST['email']);
		 $email = mysqli_real_escape_string($con,$email);
		 $password = stripslashes($_REQUEST['password']);
		 $password = mysqli_real_escape_string($con,$password);
		 $trn_date = date("Y-m-d H:i:s");
		        $query = "INSERT into `users` (username, password, email, trn_date)
		VALUES ('$username', '".md5($password)."', '$email', '$trn_date')";
		        $result = mysqli_query($con,$query);
		        if($result){
		            echo "<div class='form'>
						<h3>You are registered successfully.</h3>
						<br/>Click here to <a href='login.php'>Login</a>
						</div>";
		        }
		    }else{
		?>
		
			<form class="form-signin" action="" method="post" name="login">
			  <div class="text-center mb-4">
			    <img class="mb-4" src="img/popular_requests.png" alt="" width="72" height="72">
			    <h1 class="h3 mb-3 font-weight-normal">Registration</h1>
			  </div>

			  <div class="form-label-group">
			    <input type="text" name="username" id="inputUsername" class="form-control" placeholder="Username" required autofocus>
			    <label for="inputUsername">Username</label>
			  </div>

			<div class="form-label-group">
			    <input type="text" name="email" id="inputEmail" class="form-control" placeholder="Email" required autofocus>
			    <label for="inputEmail">Email</label>
			  </div>

			  <div class="form-label-group">
			    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
			    <label for="inputPassword">Password</label>
			  </div>
			  <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">Register</button>
			  <div class="checkbox mb-3">
			  	<!--<p>Not registered yet? <a href='registration.php'>Register Here</a></p>
			    <label>
			      <input type="checkbox" value="remember-me"> Remember me
			    </label>-->
			  </div>
			  <p class="mt-5 mb-3 text-muted text-center">Copyright &copy; HealthNotes <?php echo date("Y");?></p>
			</form>
		
		<?php } ?>
		<script src="js/bootstrap.js"></script>
	</body>
</html>