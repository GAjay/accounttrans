<?php
	include('../../configure/config.php');
	if($_SERVER['REQUEST_METHOD']=="POST"){
		if($_POST['check1']=='upd'){
			$id = $_POST['id'];
			$name=$_POST['name'];
			$particular=$_POST['particular'];
			$addmobile=$_POST['address/mobile'];
			$type=$_POST['type'];
			$sql="UPDATE `party` SET `name`='$name',`particular`='$particular',`address/mobile`='$addmobile', `type`='$type' WHERE `ID`='$id'";
			$result = $db->query($sql) or die('sql Error: '.$db->error);
			if($result){
				echo '<h3 id="u">Selected party updated successfully</h3><button type="submit" onclick="window.location=\'../party.php\';">Back</button>';
			}
		}
		else if($_POST['check1']=='upload_record'){
			$i=$_POST['upload_record'];
			$result=null;
			while($i>0){
				$name=$_POST[$i.'_name'];
				$particular=$_POST[$i.'_particular'];
				$addmobile=$_POST[$i.'_address/mobile'];
				$type=0;
				if(isset($_POST[$i.'_type'])){
				$type=1;
				}
				$sql="INSERT INTO `party`(`name`, `particular`, `address/mobile`, `type`) VALUES ('$name', '$particular', '$addmobile', '$type')";
				$result = $db->query($sql) or die('sql Error: '.$db->error);
				$i--;
			}
			if($result){
				echo '<h3 id="u">Party information uploaded successfully</h3>';
			}
			echo'<button type="submit" onclick="window.location=\'../party.php\';">Back</button>';
		}
		else{
			header('Location: ../party.php');
		}
	}
	
?>
