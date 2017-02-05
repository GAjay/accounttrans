<?php
	include('../../configure/config.php');
	include('../../configure/session.php');
	$user = $_SESSION['login_user'];
	$perm = $_SESSION['permission'];
	$last_paid_date = $_SESSION['last_paid_date'];
	$member_id = $_SESSION['ID'];
	$msg=null;
	$t_a=0;
	$t_f=0;
	$t_r=0;
	$particular='';
	$paid =1;$is_due=0;
	$created_at = date( 'Y-m-d');
	$updated_at = date( 'Y-m-d');
	if($_SERVER['REQUEST_METHOD']=='POST'){
		if(isset($_POST['count'])){
			$t_a = $_POST['totaladjustment'];
			$t_f = $_POST['totalfreight'];
			$t_r = $_POST['totalroundof'];
			$party_id = $_POST['party_id'];
			$d = explode('-',$_POST['paid_at']);
			$i=0;$n;
			foreach($d as $p){
				$n[$i]=$p;
				$i++;
			}
			$paid_at = '20'.$n[2].'-'.$n[1].'-'.$n[0];
			$paid_at = Date($paid_at);
//-------------------------------------last paid date update------------------------------------------------
			$l_sql = "UPDATE `users` SET `last_paid_date`='$paid_at' WHERE `ID`='$member_id'"; 
			$l_result = $db->query($l_sql) or die("Sql Error :" . $db->error);
			
			$full=$_POST['full'];
//-------------------------------------due payment entry---------------------------------------------------------
			if($full==0){
				$particular = ' (Net Due)';
				$paid = 0;
				$is_due = 1;
				$freight = $t_f-$t_a-$t_r;
				$sql = "INSERT INTO `challan`(`marka`, `particular`, `freight`, `addedby`, `paid`, `partyname`, `created_at`, `updated_at`, `is_pakka`, `is_full`, `is_roundof`, `is_due`) VALUES ('$particular', '$particular', '$freight', '$member_id', '0', '$party_id', '$created_at', '$updated_at', '0', '$full', '0', '$0')"; 
				$result = $db->query($sql) or die("Sql Error :" . $db->error);
			}
//-------------------------------------------draft challan---------------------------------------------------------
			if($t_f-$t_a-$t_r<0){
				$particular = ' (Debit)';
				$freight = $t_f-$t_a-$t_r;
				$paid=1;
				$sql = "INSERT INTO `challan`(`marka`, `particular`, `freight`, `addedby`, `paid`, `partyname`, `created_at`, `updated_at`, `is_pakka`, `is_full`, `is_roundof`, `is_due`) VALUES ('$particular', '$particular', '$freight', '$member_id', '0', '$party_id', '$created_at', '$updated_at', '0', '0', '0', '$is_due')"; 
				$result = $db->query($sql) or die("Sql Error :" . $db->error);
			}
//---------------------------------------------------------------------------------------------------------------
			foreach($_POST['count'] as $upload_record){
				$id = $_POST[$upload_record.'_id_value'];
				$adjustment = $_POST[$upload_record.'_adjustment'];
				$sql = ("UPDATE `challan` SET  `updated_at`='$updated_at', `is_full`='$full', `adjustment`='$adjustment', `paid_at`='$paid_at', `paid`='$paid', `particular`=CONCAT(`particular`,' $particular'), `is_due`='$is_due' WHERE `ID`='$id'"); 
				$result = $db->query($sql) or die("Sql Error :" . $db->error);
			}
//---------------------------------round of calculation-----------------------------------------------------------------			
			$r_sql = "UPDATE `party` SET `round_of_amount`=`round_of_amount`-'$t_r' WHERE `ID`='$party_id'"; 
			$r_result = $db->query($r_sql) or die("Sql Error :" . $db->error);
			
			$msg = 'Selected Challan updated successfully';
		}
		else{
			$msg = 'Please Select atleast one row';
		}
		header('Location: ../paid.php?user='.$user.'&perm='.$perm.'&msg='.$msg);
	}
?>