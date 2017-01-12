<?php
	include('../../configure/config.php');
	echo $user = $_GET['user'];
	echo $perm = $_GET['perm'];
	$msg=null;
	$sql=null;
	if($_SERVER['REQUEST_METHOD']=='POST'){
		if($_POST['upload_record']!=""){
			$upload_record = $_POST['upload_record'];
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
				$truckno = $_POST[$upload_record.'_truckno'];
				$drivername = $_POST[$upload_record.'_drivername'];
				$partyname = $_POST[$upload_record.'_partyname'];
				$created_at = date( 'Y-m-d H:i:s');
				$updated_at = date( 'Y-m-d H:i:s');
				echo $sql = ("INSERT INTO `challan`(`G.R.No`, `marka`, `nag`, `particular`, `weight`, `freight`, `addedby`, `paid`, `dateofarrival`, `truckno`, `drivername`, `partyname`, `created_at`, `updated_at`) VALUES ('$GRNo', '$marka', '$nag', '$particular', '$weight', '$freight', '$addedby', '$paid', '$dateofarrival', '$truckno', '$drivername', '$partyname', '$created_at', '$updated_at')");
				$result = $db->query($sql) or die("Sql Error :" . $db->error);
				$upload_record--;
			}
			$msg = 'New Challan uploaded successfully';
		}
		else{echo'else';
			if($_POST['fn']=='update_record'){
				if(isset($_POST['count'])){
				/*foreach($_POST['count'] as $upload_record){
					$GRNo = $_POST[$upload_record.'_g_r_no'];
					$marka = $_POST[$upload_record.'_marka'];
					$nag = $_POST[$upload_record.'_nag'];
					$particular = $_POST[$upload_record.'_particular'];
					$weight = $_POST[$upload_record.'_weight'];
					$freight = $_POST[$upload_record.'_freight'];
					$paid = 0;
					$dateofarrival = $_POST[$upload_record.'_dateofarrival'];
					$truckno = $_POST[$upload_record.'_truckno'];
					$drivername = $_POST[$upload_record.'_drivername'];
					$partyname = $_POST[$upload_record.'_partyname'];
					$updated_at = date( 'Y-m-d H:i:s');
					$sql = ("UPDATE `challan` SET `G.R.No`=[value-1],`marka`=[value-2],`nag`=[value-3],`particular`=[value-4],`weight`=[value-5],`freight`=[value-6],`addedby`=[value-7],`paid`=[value-8],`dateofarrival`=[value-9],`truckno`=[value-10],`drivername`=[value-11],`partyname`=[value-12],`created_at`=[value-13],`updated_at`=[value-14] WHERE 1 `challan` (`G.R.No`, `marka`, `nag`, `particular`, `weight`, `freight`, `paid`, `dateofarrival`, `truckno`, `drivername`, `partyname`, `created_at`, `updated_at`) VALUES ('$GRNo', '$marka', '$nag', '$particular', '$weight', '$freight', '$paid', '$dateofarrival', '$truckno', '$drivername', '$partyname', '$updated_at')");
				$result = $db->query($sql) or die("Sql Error :" . $db->error);}
				$msg = 'Selected Challan updated successfully';*/}
				else{
					$msg = 'Please Select atleast one row';
				}
			}
			else if($_POST['fn']=='paid_record'){
				if(isset($_POST['count'])){
				foreach($_POST['count'] as $upload_record){
					$GRNo = $_POST[$upload_record.'_g_r_no'];
					$marka = $_POST[$upload_record.'_marka'];
					$nag = $_POST[$upload_record.'_nag'];
					$particular = $_POST[$upload_record.'_particular'];
					$weight = $_POST[$upload_record.'_weight'];
					$freight = $_POST[$upload_record.'_freight'];
					$addedby = $user;
					$paid = 0;
					$dateofarrival = $_POST[$upload_record.'_dateofarrival'];
					$truckno = $_POST[$upload_record.'_truckno'];
					$drivername = $_POST[$upload_record.'_drivername'];
					$partyname = $_POST[$upload_record.'_partyname'];
					$created_at = date( 'Y-m-d H:i:s');
					$updated_at = date( 'Y-m-d H:i:s');
					$sql = ("UPDATE `challan` SET `paid`='1'
					WHERE `G.R.No`='$GRNo' AND `marka`='$marka' AND `nag`='$nag' AND `dateofarrival`='$dateofarrival' AND `truckno`='$truckno'");
					$result = $db->query($sql) or die("Sql Error :" . $db->error);
					$msg = 'Selected Challan uploaded on paid record successfully';
				}}
				else{
					$msg = 'Please Select atleast one row';
				}
			}
		}
			header('Location: ../home.php?user='.$user.'&perm='.$perm.'&msg='.$msg);
	}
?>