<?php
if (session_id() == '') session_start();

$conn = mysqli_connect('localhost', 'framunnow7', 'framunnow7424', 'COMP3540_framunno');
if (isset($_GET['text'])) {
	$text = $_GET['text'];
	$username = $_SESSION['username'];
        $room_id = $_SESSION['room_id'];
	$query = "insert into chat(username, text, room_id) values('$username', '$text', '$room_id')";
	$result = mysqli_query($conn, $query);
}
$conn->close();
?>
