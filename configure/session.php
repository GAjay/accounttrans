<?php
	include('config.php');
	session_start();
	$check_user = $_SESSION['login_user'];
	$result = mysqli_query($db,"SELECT `username` FROM `users` WHERE `USERNAME`='$check_user'");
	$row = @mysqli_fetch_array($result,MYSQLI_ASSOC);
	$login_session = $row['username'];
	if(!isset($_SESSION['login_user'])){
		header("location:index.php?session");
	}
?>