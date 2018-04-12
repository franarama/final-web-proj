<?php
if (session_id() == '') session_start();

$conn = mysqli_connect('localhost', 'framunnow7', 'framunnow7424', 'COMP3540_framunno');

$query = "select * from chat where room_id=" . $_SESSION['room_id'] . " order by id ASC";
$result = mysqli_query($conn, $query);
if ($result) {
	while ($row = mysqli_fetch_assoc($result)) {
	        $username = $row["username"];
	        $text = $row["text"];
        	$time = date('G:i', strtotime($row["time"])); //outputs date as # #Hour#:#Minute#
                echo "<p>$time | $username: $text</p>\n";
	}
}
else {
	echo "An error occured";
}
$conn->close();
?>
