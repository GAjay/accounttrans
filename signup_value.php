<?php
	include('configure/config.php');
if($_SERVER['REQUEST_METHOD']=='POST'){
	$permission = null;	
	$name = $_POST['name'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$address = $_POST['address'];
	$marka = $_POST['marka'];
	foreach($_POST['permission'] as $selected) {
		if($permission==null){
			$permission = $selected;
		}
		else{
			$permission = $permission.",".$selected;
		}
	}
	$password = md5($password);
	echo $sql = ("INSERT INTO `users` (`username`, `password`, `access`, `marka`, `partyname`, `address`) VALUES ('$username', '$password', '$permission', '$marka', '$name', '$address')");
	$result = $db->query($sql) or die("Sql Error :" . $db->error);
	if($result){
		header('Location: index.php?create=1');
    }
	
}
?>