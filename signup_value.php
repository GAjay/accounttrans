<?php
	include('configure/config.php');
if($_SERVER['REQUEST_METHOD']=='POST'){
	$permission = null;	
	$name = $_POST['name'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$address = $_POST['address'];
	foreach($_POST['permission'] as $selected) {
		if($permission==null){
			$permission = $selected;
		}
		else{
			$permission = $permission.",".$selected;
		}
	}
	$password = md5($password);
	echo $sql = ("INSERT INTO `users` (`username`, `password`, `access`, `partyname`, `address`) VALUES ('$username', '$password', '$permission', '$name', '$address')");
	$result = $db->query($sql) or die("Sql Error :" . $db->error);
	if($result){
		/*header('Location: index.php?create=1');*/
		header('Location: other/home.php?create=1');
    }
	
}
?>