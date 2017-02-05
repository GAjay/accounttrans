<?php
	include('../../configure/config.php');
	if($_SERVER["REQUEST_METHOD"] == "POST") {

		$username = $_POST['new_name'];

		$sql = "SELECT `username` FROM users WHERE username = '$username'";
		$result = mysqli_query($db,$sql);
		$row = mysqli_fetch_array($result);

		$count = mysqli_num_rows($result);
		
		echo $count;
	}
?>