<?php
	include('../../configure/config.php');
	if($_SERVER['REQUEST_METHOD']=="POST"){
		if($_POST['check1']=='upd'){
			$id = $_POST['id'];
			$name=$_POST['name'];
			$marka=$_POST['marka'];
			$particular=$_POST['particular'];
			$addmobile=$_POST['address/mobile'];
			$sql="UPDATE `party` SET `name`='$name',`particular`='$particular',`address/mobile`='$addmobile',`marka`='$marka' WHERE `ID`='$id'";
			$result = $db->query($sql) or die('sql Error: '.$db->error);
			if($result){
				echo '<h3 id="u">Selected party updated successfully</h3><button type="submit" onclick="window.location=\'../party.php\';">Back</button>';
			}
		}
		else if($_POST['check1']=='upload_record'){
			$i=$_POST['upload_record'];
			$result;
			while($i>0){
				$name=$_POST[$i.'_name'];
				$marka=$_POST[$i.'_marka'];
				$particular=$_POST[$i.'_particular'];
				$addmobile=$_POST[$i.'_address/mobile'];
				$sql="INSERT INTO `party`(`name`, `particular`, `address/mobile`, `marka`) VALUES ('$name', '$particular', '$addmobile', '$marka')";
				$result = $db->query($sql) or die('sql Error: '.$db->error);
				$i--;
			}
			if($result){
				echo '<h3 id="u">Party information uploaded successfully</h3><button type="submit" onclick="window.location=\'../party.php\';">Back</button>';
			}
		}
		else{
			header('Location: ../party.php');
		}
	}
	
?>