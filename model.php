<?php
$conn = mysqli_connect('localhost', 'framunnow7', 'framunnow7424', 'COMP3540_framunno');

function insert_new_user($username, $password, $email) {
    global $conn;
    
    if (does_exist($username))
        return false;
    else {
        $sql = "insert into Users_Proj values (NULL, '$username', '$password', '$email', NULL)";
        $result = mysqli_query($conn, $sql);
        return $result;
    }
}

function insert_new_room($username, $latitude, $longitude, $title) {
	global $conn;

	$uid = get_userid($username);
	$date = date('Y-m-d H:i:s');
	$sql = "insert into Rooms_Proj values(NULL, '$longitude', '$latitude', '$date', $uid, '$title')";
	$result = mysqli_query($conn, $sql);
	return $result;

}


function get_userid($username) { 

    global $conn;

    $sql = "select * from Users_Proj where (username = '$username')";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        return $row['user_id'];
    }
    else
        return -1;
}

function get_security_q($username) {
	global $conn;
	$userid = get_userid($username);
	$sql = "select * from security_questions sq left join Users_Proj up ON sq.id=up.question_id where up.user_id='$userid'";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_array($result);
		return $row['question'];
	}
        else return -1;
}

function get_security_answer($username) {
	global $conn;
        $userid = get_userid($username);
        $sql = "select * from security_questions sq left join Users_Proj up ON sq.id=up.question_id where up.user_id='$userid'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);
                return $row['question_answer'];
        }
        else return -1;
}

function update_password($username, $password) {
	global $conn;
	$userid = get_userid($username);
	$sql = "update Users_Proj set password='$password' where user_id='$userid'";
	$result = mysqli_query($conn, $sql);
	return $result;
}

function get_radius($username) {
	global $conn;
	$sql = "select * from Users_Proj where (username = '$username')";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_array($result);
		return $row['radius'];
	}
	else {
		return 50;
	}
}

function is_valid($username, $password) {
    global $conn;
    
    $sql = "select * from Users_Proj where (username = '$username' and password = '$password')";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
        return true;
    else
        return false;
}

function does_exist($username) {
    global $conn;
    
    $sql = "select * from Users_Proj where (username = '$username')";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
        return true;
    else
        return false;
}

function update_radius($radius, $username) {
	global $conn;
	$sql = "update Users_Proj set radius=$radius WHERE username='$username'";
	$result = mysqli_query($conn, $sql);
	return $result;
}
function list_rooms() {
	global $conn;
	
	$sql = "select * from Rooms_Proj";
	$result = mysqli_query($conn, $sql);
	$data = array();
	$i = 0;
	while($row = mysqli_fetch_assoc($result)) 
		$data[$i++] = $row;
	return $data;
}
function get_options() {
	global $conn;
	$sql = "select question from security_questions";
	$result = mysqli_query($conn, $sql);
	$data = array();
	$i = 0;
	while ($row = mysqli_fetch_assoc($result))
		$data[$i++] = $row;
	return $data;
}
?>
