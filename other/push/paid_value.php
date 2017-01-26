<?php
	include('../../configure/config.php');
	$user = $_GET['user'];
	$perm = $_GET['perm'];
	$msg=null;
	$sql=null;
	if($_SERVER['REQUEST_METHOD']=='POST'){
		if($_POST['fn']=='update_record'){
			if(isset($_POST['count'])){
			foreach($_POST['count'] as $upload_record){
				$id = $_POST[$upload_record.'_id_value'];
				$freight = $_POST[$upload_record.'_freight'];
				$paid = $_POST[$upload_record.'_paidamount'];
				$updated_at = date( 'Y-m-d');
				$sql = ("UPDATE `challan` SET `freight`='$freight', `updated_at`='$updated_at', `paidamount`='$paid' WHERE `ID`='$id'");
			$result = $db->query($sql) or die("Sql Error :" . $db->error);}
			$msg = 'Selected Challan updated successfully';}
			else{
				$msg = 'Please Select atleast one row';
			}
		}
		else if($_POST['fn']=='paid_record'){
			if(isset($_POST['count'])){
			foreach($_POST['count'] as $upload_record){
				$id = $_POST[$upload_record.'_id_value'];
				$updated_at = date( 'Y-m-d');
				$sql = ("UPDATE `challan` SET `paid`='1', `paid_at`='$updated_at'
				WHERE `ID`='$id'");
				$result = $db->query($sql) or die("Sql Error :" . $db->error);
				$msg = 'Selected Challan uploaded on paid record successfully';
			}}
			else{
				$msg = 'Please Select atleast one row';
			}
		}
		header('Location: ../paid.php?user='.$user.'&perm='.$perm.'&msg='.$msg);
	}
?>