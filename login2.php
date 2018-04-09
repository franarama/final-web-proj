<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>WhatsUp? Login</title>
  <link rel="stylesheet" href="css/login.css">
  <link rel="stylesheet" href="css/main.css">
    <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  
  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  
  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
  
  <nav class="navbar navbar-inverse navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
				<li><a class="navbar-brand">Whatsup?</a></li>
			</ul>
        </div>
    </div>
  </nav>
  
  <div class="container-fluid" id="blanket">
  
  <div class="container-fluid">
	  <div class="login-page">
		<div class="form">
			<form class="register-form" method="post" action="controller.php">
				<p class="error"><?php if (isset($_SESSION['error'])) echo $_SESSION['error'];?></p>
				<input type='hidden' name='page' value='StartPage'></input>
        <input type='hidden' name='command' value='Join'></input>
				<label><input type="text" placeholder="username" name="username" required="required"/></label>
				<label><input type="password" placeholder="password" name="password" required="required"/></label>
				<label><input type="text" placeholder="email address" name="email" required="required"/></label>
				<label><button type="submit" class="btn btn-primary" id="submit-btn-2">Create</button></label>
				<br>
				<label><p class="message">Already registered?<button type="button" class="btn btn-primary" id="showLogin">Sign In</button></p></label>
			</form>
			
			<form class="login-form" method="post" action="controller.php">
				<p class="error"><?php if (isset($_SESSION['error'])) echo $_SESSION['error'];?></p>
				<input type='hidden' name='page' value='StartPage'></input>
        <input type='hidden' name='command' value='Login'></input>
				<label><input type="text" placeholder="username" name="username" required="required"/></label>
				<label><input type="password" placeholder="password" name="password" required="required"/></label>
				<button type="submit" class="btn btn-primary" id="submit-btn">Login</button>
				<br>
				<p class="message">Not registered?<button type="button" class="btn btn-primary" id="showReg">Create an account</button></p>
			</form>
		</div>
	  </div>
  </div>
  </div>
  
  <script>
	$(document).ready(function() {
		
		<?php
		if (isset($_SESSION['display_type'])) {
			if ($_SESSION['display_type'] == 'signin') {
					echo "$('.register-form').hide();";
					echo "$('.login-form').show();";
			}
			else if ($_SESSION['display_type'] == 'join') {
					echo "$('.register-form').show();";
					echo "$('.login-form').hide();";
			}
		}
		else {
			echo "$('.register-form').hide();";
			echo "$('.login-form').show();";
		}
		?>
		
	});
	
	$('#showReg').click(function() {

		$('.login-form').hide();
		$('.register-form').show();
		$('.error').text("");
	});
	
	$('#showLogin').click(function() {

		
		$('.register-form').hide();
		$('.login-form').show();
		$('.error').text("");
	});
  </script>
</body>

</html>