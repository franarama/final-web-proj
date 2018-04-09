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
			if (!is_valid($_POST['username'], $_POST['password'])) {
				$_SESSION['error'] = "Invalid username or password";
               			 include('login2.php');
	     		}
	     		else {
				$_SESSION['signedin'] = 'YES';
                		$_SESSION['username'] = $_POST['username'];
			        $_SESSION['userid'] = get_userid($_POST['username']);
				$_SESSION['display_type'] = 'signed-in';
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
					$_SESSION['userid'] = get_userid($_POST['username']);
					$_SESSION['display_type'] = "set-radius";
					$_SESSION['radius'] = 50;
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

else if ($_POST['page'] == 'MainPage') {
	$command = $_POST['command'];
	switch($command) {
		case 'add-room':
			if (insert_new_room($_SESSION['username'], NULL, NULL, $_POST['title'])) {
				$_SESSION['display_type'] = 'signed-in';
				include('mainpage.php');
			}
			else {
				$_SESSION['add-error'] = "An error occured";
				$_SESSION['display_type'] = 'add-room';
				include('mainpage.php');
			}
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
		case 'list-rooms':
			$r = list_rooms();
			$str = json_encode($r);
			echo $str;
	}
}

?>
