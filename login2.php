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
				<h1 style="margin-bottom: 40px;">Register</h1>
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
				<h1 style="margin-bottom:50px;">Login</h1>
				<p class="error"><?php if (isset($_SESSION['error'])) echo $_SESSION['error'];?></p>
				<input type='hidden' name='page' value='StartPage'></input>
        			<input type='hidden' name='command' value='Login'></input>
				<label><input type="text" placeholder="username" name="username" required="required"/></label>
				<label><input type="password" placeholder="password" name="password" required="required"/></label>
				<button type="submit" class="btn btn-primary" id="submit-btn">Login</button>
				<br>
				<label><p class="message">Forgot password? <button type="button" class="btn btn-primary" id="forgot-password">Click here</button></p></label><br>
				<p class="message">Not registered?<button type="button" class="btn btn-primary" id="showReg">Create an account</button></p>
			</form>

			<form class="forgot-pw-form" method="post" action="controller.php">
				<h1 style="margin-bottom: 50px;">Forgot Password</h1>
				<p class="error"><?php if (isset($_SESSION['error'])) echo $_SESSION['error'];?></p>
				<input type="hidden" name="page" value="StartPage"></input>
				<input type="hidden" name="command" value="forgot-pw"></input>
				<label><input type="text" placeholder="Enter your username" name="username" required="required"/></label>
				<label><button type="submit" class="btn btn-primary" id="submit-btn">Continue</button>
				<button type="button" style="margin-top:40px;" class="btn btn-primary" id="cancel-forgot-pw">Cancel</button></label>
			</form>

			<form class="security-form" method="post" action="controller.php">
				<h1 style="margin-bottom:40px;">Answer the following security question</h1>
				<p class="error"><?php if (isset($_SESSION['error'])) echo $_SESSION['error'];?></p>
				<input type="hidden" name="page" value="StartPage"></input>
				<input type="hidden" name="command" value="check-security"></input>
				<div class="form-group">
					<select class="form-control" id="sel1">
						<?php echo "<option>" . $_SESSION['option'] . "</option>";?>
					</select>
				</div> 
				<input type="text" name="answer" placeholder="Your answer"></input>
				<label><button type="submit" style="margin-top: 40px;" class="btn btn-primary" id="submit-security">Continue</button>
				<button type="button" style="margin-top:40px" class="btn btn-primary" id="cancel-security">Cancel</button></label>
			</form>

			<form class="set-pw-form" method="post" action="controller.php">
				<p class="error"><?php if (isset($_SESSION['error'])) echo $_SESSION['error']; ?></p>
				<input type="hidden" name="page" value="StartPage"></input>
				<input type="hidden" name="command" value="set-password"></input>
				<h1 style="margin-bottom:50px;">Set your new password</h1>
				<input type="password" name="password" placeholder="Enter new password"></input>
				<label><button type="submit" style="margin-top:40px;" class="btn btn-primary">Continue</button>
				<button type="button" style="margin-top:40px;" class="btn btn-primary" id="cancel-set-pw">Cancel</button></label>
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
					echo "$('.forgot-pw-form').hide();";
					echo "$('.security-form').hide();";
					echo "$('.set-pw-form').hide()";
			}
			else if ($_SESSION['display_type'] == 'join') {
					echo "$('.register-form').show();";
					echo "$('.login-form').hide();";
					echo "$('.forgot-pw-form').hide();";
					echo "$('.security-form').hide();";
					echo "$('.set-pw-form').hide()";

			}
			else if ($_SESSION['display_type'] == 'forgot-pw') {
					echo "$('.register-form').hide();";
					echo "$('.login-form').hide();";
					echo "$('.forgot-pw-form').show();";
					echo "$('.security-form').hide();";
					echo "$('.set-pw-form').hide()";
			}
			else if ($_SESSION['display_type'] == "security-questions") {
				        echo "$('.register-form').hide();";
                                        echo "$('.login-form').hide();";
					echo "$('.forgot-pw-form').hide();";
					echo "$('.security-form').show();";
					echo "$('.set-pw-form').hide()";
			}
			else if ($_SESSION['display_type'] == 'set-password') {
			                echo "$('.register-form').hide();";
                                        echo "$('.login-form').hide();";
                                        echo "$('.forgot-pw-form').hide();";
                                        echo "$('.security-form').hide();";
                                        echo "$('.set-pw-form').show()";

			}
		}
		else {
			echo "$('.register-form').hide();";
			echo "$('.login-form').show();";
			echo "$('.forgot-pw-form').hide();";
			echo "$('.security-form').hide();";
			echo "$('.set-pw-form').hide()";
		}
		?>
		
	});
	
	$('#showReg').click(function() {
		$('.set-pw-form').hide();
		$('.login-form').hide();
		$('.register-form').show();
		$('.forgot-pw-form').hide();
		$('.security-form').hide();
		$('.error').text("");
	});
	
	$('#showLogin').click(function() {
		$('.set-pw-form').hide();
		$('.register-form').hide();
		$('.forgot-pw-form').hide();
		$('.login-form').show();
		$('.security-form').hide();
		$('.error').text("");
	});

	$('#forgot-password').click(function() {
		$('.register-form').hide();
		$('.forgot-pw-form').show();
		$('.login-form').hide();
		$('.set-pw-form').hide();
		$('.security-form').hide();
		$('.error').text("");
	});
	$('#cancel-forgot-pw').click(function() {
		$('.register-form').hide();
                $('.forgot-pw-form').hide();
                $('.login-form').show();
		$('.set-pw-form').hide();
		$('.security-form').hide();
                $('.error').text("");

	});
	$('#cancel-security').click(function() {
	        $('.register-form').hide();
                $('.forgot-pw-form').hide();
                $('.login-form').show();
                $('.set-pw-form').hide();
		$('.security-form').hide();
                $('.error').text("");

	});
	$('#cancel-set-pw').click(function() {
		$('.register-form').hide();
                $('.forgot-pw-form').hide();
                $('.login-form').show();
		$('.security-form').hide();
                $('.error').text("");
		$('.set-pw-form').hide();
	});
  </script>
</body>

</html>
