<?php
	include('../configure/config.php');
if($_SERVER['REQUEST_METHOD']=='POST'){
	$check=false;
	$u_name = $_POST['u_name'];
	$name = $_POST['name'];
	$address = $_POST['address'];
	$sql = ("UPDATE `users` SET `partyname`='$name',`address`='$address' WHERE `username`='$u_name'");
	if($_POST['check']==1){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$password = md5($password);
		$check = true;
		if(($username!=$u_name)&&($_POST['password']!='')){
			$sql = ("UPDATE `users` SET `username`='$username', `password`='$password', `partyname`='$name',`address`='$address' WHERE `username`='$u_name'");
		}
		else if(($username!=$u_name)&&($_POST['password']=='')){
			$sql = ("UPDATE `users` SET `username`='$username', `partyname`='$name',`address`='$address' WHERE `username`='$u_name'");
		}
		else if(($username==$u_name)&&($_POST['password']!='')){
			$sql = ("UPDATE `users` SET `password`='$password', `partyname`='$name',`address`='$address' WHERE `username`='$u_name'");
		}
	}
	$result = $db->query($sql) or die("Sql Error :" . $db->error);
	if($result&&!$check){
		header('Location: home.php?user='.$user.'&perm='.$perm.'&update=true');
    }
	else if($result&&$check){
		header('Location: ../configure/logout.php?updated=updated');
    }
}
?>