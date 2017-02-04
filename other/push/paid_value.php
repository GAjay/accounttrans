<?php
	include('../../configure/config.php');
	$user = $_GET['user'];
	$perm = $_GET['perm'];
	$msg=null;
	$sql=null;$try=false;
	if($_SERVER['REQUEST_METHOD']=='POST'){echo 'asdds<br>';
		$d = explode('-',$_POST['paid_at']);
		$i=0;$n;
		foreach($d as $p){
			$n[$i]=$p;
			$i++;
		}
		$party_id = $_POST['party_id'];
		$paid_at = '20'.$n[2].'-'.$n[1].'-'.$n[0];
		$paid_at = Date($paid_at);
		$full=$_POST['full'];
		$total_paid=$_POST['total_paid'];
		if($_POST['roundof']>0){
			echo $roundof=$_POST['roundof'];
			if($roundof-$total_paid<0){
				$try=true;
			}
			else{
				$try=false;
				$roundof=$roundof-$total_paid.'<br>';
				$r_sql = "UPDATE `party` SET `round_of_amount`='$roundof' WHERE `ID`='$party_id'";
				$r_result = $db->query($r_sql);
			}
		}
		if(!$try){
			$l_sql = "SELECT `last_paid_date` FROM `users` WHERE `partyname`='$user' AND `access`='$perm'";
			$l_result = $db->query($l_sql) or die("Sql Error :" . $db->error);
			$row = mysqli_fetch_array($l_result);
			if($paid_at<$row['last_paid_date']){
				$msg = 'You cant paid on that Date';
			}
			else{
				if(isset($_POST['count'])){
					foreach($_POST['count'] as $upload_record){
						$id = $_POST[$upload_record.'_id_value'];
						$paid = $_POST[$upload_record.'_adjustment'];
						$updated_at = date( 'Y-m-d');
						$sql = ("UPDATE `challan` SET  `updated_at`='$updated_at', `is_full`='$full', `adjustment`='$paid', `paid_at`='$paid_at', `paid`=1 WHERE `ID`='$id'");
						$result = $db->query($sql) or die("Sql Error :" . $db->error);
						$l_sql = "UPDATE `users` SET `last_paid_date`='$paid_at' WHERE `partyname`='$user' AND `access`='$perm'";
						$l_result = $db->query($l_sql) or die("Sql Error :" . $db->error);
					}
					$msg = 'Selected Challan updated successfully';
				}
				else{
					$msg = 'Please Select atleast one row';
				}
			}
		}
		else{
			$msg = 'First clear the round of amount';
		}
		header('Location: ../paid.php?user='.$user.'&perm='.$perm.'&msg='.$msg);
	}
?>