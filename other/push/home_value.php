<?php
	include('../../configure/config.php');
	include('../../configure/session.php');
	$user = $_SESSION['login_user'];
	$perm = $_SESSION['permission'];
	$member_id = $_SESSION['ID'];
	$msg=null;
	$sql=null;$is_pakka=null;$dateofdeparture=null;
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
				$addedby = $member_id;
				$paid = 0;
				if($_POST[$upload_record.'_dateofdeparture'] == ''){
					$d = explode('-',$_POST['dateofdeparture']);
					$i=0;$n;
					foreach($d as $p){
						$n[$i]=$p;
						$i++;
					}
					$dateofdeparture = '20'.$n[2].'-'.$n[1].'-'.$n[0];
					$dateofdeparture = Date($dateofdeparture);
				}
				else{
					$d = explode('-',$_POST[$upload_record.'_dateofdeparture']);
					$i=0;$n;
					foreach($d as $p){
						$n[$i]=$p;
						$i++;
					}
					$dateofdeparture = '20'.$n[2].'-'.$n[1].'-'.$n[0];
					$dateofdeparture = Date($dateofdeparture);
				}
				$partyname = $_POST[$upload_record.'_partyname'];
				if($partyname==''){
					$partyname=1;
				}
				$created_at = date( 'Y-m-d');
				$updated_at = date( 'Y-m-d');
//--------------------------------------party type---------------------------------------------
				$sql_type = "SELECT `type` FROM `party` WHERE `ID`='$partyname'";
				$result_type=$db->query($sql_type);
				$row_type=mysqli_fetch_array($result_type);
				$is_pakka =$row_type['type'];
//------------------------------------------------------------------------------------------------
				echo $sql = ("INSERT INTO `challan`(`challanNo`, `G.R.No`, `marka`, `nag`, `particular`, `weight`, `freight`, `addedby`, `paid`, `dateofdeparture`, `truckno`, `partyname`, `created_at`, `updated_at`, `is_pakka`) VALUES ('$challan','$GRNo', '$marka', '$nag', '$particular', '$weight', '$freight', '$addedby', '$paid', '$dateofdeparture', '$truckno', '$partyname', '$created_at', '$updated_at', $is_pakka)");
				$result = $db->query($sql) or die("Sql Error :" . $db->error);
				$upload_record--;
			}
			$msg = 'New Challan uploaded successfully';
		}
		else{
			if($_POST['fn']=='update_record'){
				if(isset($_POST['count'])){
				foreach($_POST['count'] as $upload_record){
					$id = $_POST[$upload_record.'_id_value'];
					$freight = $_POST[$upload_record.'_freight'];
					$partyname = $_POST[$upload_record.'_partyname'];
//--------------------------------------party type---------------------------------------------
				$sql_type = "SELECT `type` FROM `party` WHERE `ID`='$partyname'";
				$result_type=$db->query($sql_type);
				$row_type=mysqli_fetch_array($result_type);
				$is_pakka =$row_type['type'];
//------------------------------------------------------------------------------------------------
					$updated_at = date( 'Y-m-d');
					if(isset($_POST[$upload_record.'_g_r_n'])&&isset($_POST[$upload_record.'_marka'])&&isset($_POST[$upload_record.'_nag'])&&isset($_POST[$upload_record.'_particular'])){
						$GRNo = $_POST[$upload_record.'_g_r_n'];
						$marka = $_POST[$upload_record.'_marka'];
						$nag = $_POST[$upload_record.'_nag'];
						$particular = $_POST[$upload_record.'_particular'];
						$weight = $_POST[$upload_record.'_weight'];
						$sql = ("UPDATE `challan` SET `G.R.No`='$GRNo',`marka`='$marka',`nag`='$nag',`particular`='$particular',`weight`='$weight',`freight`='$freight',`partyname`='$partyname',`updated_at`='$updated_at', `is_pakka`='$is_pakka' WHERE `ID`='$id'");
					}
					else{
						$sql = ("UPDATE `challan` SET `freight`='$freight', `partyname`='$partyname', `updated_at`='$updated_at', `is_pakka`='$is_pakka' WHERE `ID`='$id'");
					}
				$result = $db->query($sql) or die("Sql Error :" . $db->error);
				}
				$msg = 'Selected Challan updated successfully';}
				else{
					$msg = 'Please Select atleast one row';
				}
			}
		}
		if(isset($_GET['pakka'])){
			header('Location: ../pakka_challan.php?user='.$user.'&perm='.$perm.'&msg='.$msg);
		}
		else{
			header('Location: ../home.php?user='.$user.'&perm='.$perm.'&msg='.$msg);
		}
	}
?>