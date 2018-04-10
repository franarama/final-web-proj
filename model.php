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

function insert_new_room($username, $longitude, $latitude, $title) {
	global $conn;

	$uid = get_userid($username);
	$date = date('Y-m-d H:i:s');
	$sql = "insert into Rooms_Proj values(NULL, 50.6887252, -120.3603799, '$date', $uid, '$title')";
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
?>
