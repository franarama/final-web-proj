<?php
$conn = mysqli_connect("localhost", "framunnow7", "framunnow7424", "COMP3540_framunno");
if (isset($_GET['page']) && isset($_GET['command'])) {
	if ($_GET['page'] == 'MainPage' && $_GET['command'] == 'delete-room') {
		delete_room($_GET['room_id']);
		$_SESSION['userid'] = $_GET['uid'];
		$_SESSION['username'] = get_username($_GET['uid']);
		$_SESSION['display_type'] = 'signed-in';
		include('mainpage.php');
	}
}
function delete_account($user_id) {
	global $conn;
	$sql = 'delete from Users_Proj where user_id=' . $user_id;
	$result = mysqli_query($conn, $sql);
	include('logout.php');
	return $result;
}
function delete_room($room_id) {
	global $conn;
	$sql = 'delete from Rooms_Proj where room_id=' . $room_id;
	$result = mysqli_query($conn, $sql);
	return $result;
}
function get_username($userid) {
	global $conn;
	$sql = 'select * from Users_Proj where user_id=' . $userid;
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		return $row['username'];
	}
	else return -1;
}
?>
