<?php
if (session_id() == '')  session_start();

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
			if (!is_valid($_POST['username'], $_POST['password'])) {
				$_SESSION['error'] = "Invalid username or password";
				$_SESSION['display_type'] = "signin";
               			 include('login2.php');
	     		}
	     		else {
				$_SESSION['signedin'] = 'YES';
                		$_SESSION['username'] = $_POST['username'];
			        $_SESSION['userid'] = get_userid($_POST['username']);
				$_SESSION['radius'] = get_radius($_POST['username']);
				$_SESSION['display_type'] = 'set-radius';
				include ('mainpage.php');
	     		}
	     		break;

	     	case 'Join':
			
            		if (does_exist($_POST['username'])) {
				$_SESSION['error'] = "Username exists";
				$_SESSION['display_type'] = "join";
				include('login2.php');
            		}
			else {
				
                		if (insert_new_user($_POST['username'], $_POST['password'], $_POST['email'], $_POST['security-question'], $_POST['security-answer'])) {
					$_SESSION['signedin'] = 'YES';
					$_SESSION['username'] = $_POST['username'];
					$_SESSION['userid'] = get_userid($_POST['username']);
					$_SESSION['display_type'] = "set-radius";
					$_SESSION['radius'] = get_radius($_POST['username']);
					$_SESSION['error'] = "";
                    			include('mainpage.php');
                		}
				
				else {
					$_SESSION['error'] = "An error occured";
					$_SESSION['display_type'] = "join";
					include('login2.php');
                		}
            		}
			
            		break;

		case 'forgot-pw':
			if(!does_exist($_POST['username'])) {
				$_SESSION['error'] = "Username does not exist";
				$_SESSION['display_type'] = "forgot-pw";
				include('login2.php');
			}
			else {
				$_SESSION['username'] = $_POST['username'];
				$_SESSION['error'] = "";
				$_SESSION['option'] = get_security_q($_POST['username']);
				$_SESSION['display_type'] = "security-questions";
				include('login2.php');
			}
			break;
		case 'check-security':
			if ($_POST['answer'] == get_security_answer($_SESSION['username'])) {
				$_SESSION['display_type'] = 'set-password';
				$_SESSION['error'] = "";
				include('login2.php');
			}
			else {
				$_SESSION['error'] = "Incorrect answer";
				$_SESSION['display_type'] = "security-questions";
				include('login2.php');
			}
			break;
		case 'set-password':
			if (update_password($_SESSION['username'], $_POST['password'])) {
				$_SESSION['error'] = "Password changed. Please login";
				$_SESSION['display_type'] = "signin";
				include('login2.php');
			}
			else {
				$_SESSION['error'] = "An error occured";
				$_SESSION['display_type'] = "set-password";
				include("login2.php");
			}
	}
}

else if ($_POST['page'] == 'MainPage') {
	$command = $_POST['command'];
	switch($command) {
		case 'add-room':
			if (insert_new_room($_SESSION['username'], $_SESSION['latitude'], $_SESSION['longitude'], $_POST['title'])) {
				$_SESSION['display_type'] = 'signed-in';
				include('mainpage.php');
			}
			else {
				$_SESSION['add-error'] = "An error occured";
				$_SESSION['display_type'] = 'add-room';
				include('mainpage.php');
			}
			break;
		case 'set-radius':
			if (update_radius($_POST['radius'], $_SESSION['username'])) {
				$_SESSION['display_type'] = "signed-in";
				include('mainpage.php');
			}
			else {
				$_SESSION['display_type'] = 'set-radius';
				$_SESSION['update-error'] = "An error occured";
				include('mainpage.php');
			}
			break;

		case 'list-rooms':
			$r = list_rooms();
			$str = json_encode($r);
			echo $str;
			break;
	}
}


?>
