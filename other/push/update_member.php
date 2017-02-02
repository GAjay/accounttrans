<?php
	include('../../configure/config.php');
	if($_SERVER['REQUEST_METHOD']=="POST"){
		$permission = null;
		$ingredients = null;
		if($_POST['check1']=='upd'){
			$id = $_POST['id'];
			$name=$_POST['name'];
			$address = $_POST['address'];
			foreach($_POST['permission'] as $selected) {
				if($permission==null){
					$permission = $selected;
				}
				else{
					$permission = $permission.",".$selected;
				}
			}
			foreach($_POST['ingredients'] as $selected) {
				if($ingredients==null){
					$ingredients = $selected;
				}
				else{
					$ingredients = $ingredients.", ".$selected;
				}
			}
			$sql="UPDATE `users` SET `access`='$permission',`partyname`='$name', `connected_parties`='$ingredients', `address`='$address' WHERE `ID`='$id'";
			$result = $db->query($sql) or die('sql Error: '.$db->error);
			if($result){
				header('Location: ../member.php?add=true'); 
			}
		}
		else{
			header('Location: ../member.php');
		}
	}
	
?>