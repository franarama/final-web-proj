<?php
	session_unset();
	session_destroy();
	header("location:login2.php");
	exit();
?>
