<?php
	include('../../configure/config.php');
	echo $user = $_GET['user'];
	echo $perm = $_GET['perm'];
	$msg=null;
	$sql=null;
	if($_SERVER['REQUEST_METHOD']=='POST'){
		if($_POST['upload_record']!=""){
			$upload_record = $_POST['upload_record'];
			$challan = $_POST['challan'];
			$truckno = $_POST['truckno'];
			while($upload_record > 0){
				$GRNo = $_POST[$upload_record.'_g_r_no'];
				$marka = $_POST[$upload_record.'_marka'];
				$nag = $_POST[$upload_record.'_nag'];
				$particular = $_POST[$upload_record.'_particular'];
				$weight = $_POST[$upload_record.'_weight'];
				$freight = $_POST[$upload_record.'_freight'];
				$addedby = $user;
				$paid = 0;
				$dateofarrival = $_POST[$upload_record.'_dateofarrival'];
				$drivername = $_POST[$upload_record.'_drivername'];
				$partyname = $_POST[$upload_record.'_partyname'];
				if($partyname==''){
					$partyname='Default';
				}
				$created_at = date( 'Y-m-d');
				$updated_at = date( 'Y-m-d');
				if($GRNo!=''){
				$sql = ("INSERT INTO `challan`(`challanNo`, `G.R.No`, `marka`, `nag`, `particular`, `weight`, `freight`, `addedby`, `paid`, `dateofarrival`, `truckno`, `partyname`, `created_at`, `updated_at`) VALUES ('$challan','$GRNo', '$marka', '$nag', '$particular', '$weight', '$freight', '$addedby', '$paid', '$dateofarrival', '$truckno', '$partyname', '$created_at', '$updated_at')");
				$result = $db->query($sql) or die("Sql Error :" . $db->error);
				}
				$upload_record--;
			}
			$msg = 'New Challan uploaded successfully';
		}
		else{echo'else';
			if($_POST['fn']=='update_record'){
				if(isset($_POST['count'])){
				foreach($_POST['count'] as $upload_record){
					$id = $_POST[$upload_record.'_id_value'];
					$weight = $_POST[$upload_record.'_weight'];
					$freight = $_POST[$upload_record.'_freight'];
					$partyname = $_POST[$upload_record.'_partyname'];
					$updated_at = date( 'Y-m-d');
					$sql = ("UPDATE `challan` SET `weight`='$weight', `freight`='$freight', `partyname`='$partyname', `updated_at`='$updated_at' WHERE `ID`='$id'");
				$result = $db->query($sql) or die("Sql Error :" . $db->error);}
				$msg = 'Selected Challan updated successfully';}
				else{
					$msg = 'Please Select atleast one row';
				}
			}
		}
			header('Location: ../home.php?user='.$user.'&perm='.$perm.'&msg='.$msg);
	}
?>