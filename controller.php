<?php
session_start();

if (empty($_POST['page'])) {  
    $_SESSION['display_type'] = 'no-signin';  
    include ('login2.php');
    exit();
}

require('model.php');  // This file includes some routines to use DB.

// When commands come from StartPage
if ($_POST['page'] == 'StartPage') {
	$command = $_POST['command'];
	switch($command) {
		case 'Login':
			//            if (there is an error in username and password) {
            if (!is_valid($_POST['username'], $_POST['password'])) {
				$_SESSION['error'] = "Invalid username or password";
				$_SESSION['display_type'] = "signin";
                include('login2.php');
			}
			else {
				$_SESSION['signedin'] = 'YES';
                $_SESSION['username'] = $_POST['username'];
                
                include ('mainpage.php');
			}
			exit();
			
		case 'Join':
			
            if (does_exist($_POST['username'])) {
				$_SESSION['error'] = "Username exists";
				$_SESSION['display_type'] = "join";
				include('login2.php');
            }
			else {
				
                if (insert_new_user($_POST['username'], $_POST['password'], $_POST['email'])) {
					$_SESSION['signedin'] = 'YES';
					$_SESSION['username'] = $_POST['username'];
                    include('mainpage.php');
                }
				
				else {
					$_SESSION['error'] = "An error occured";
					$_SESSION['display_type'] = "join";
					include('login2.php');
                }
            }
			
            exit();
	}
}

?>