<?php
	$user = $_GET['user'];
	$perm = $_GET['perm'];
	$ptrn_update = "/3/";
	$ptrn_paid = "/2/";
	$ptrn_add = "/1/";
	$count = 0;
	include('../../configure/config.php');
	if(isset($_POST['address'])){
		$address = '^'.$_POST['address'];
		$sql="SELECT * FROM `party` WHERE (`address/mobile` REGEXP '$address')";
		$result=$db->query($sql);
		while($row=mysqli_fetch_array($result)){
			$sum=0;
			$p=$row['ID'];
			$sql_due = "SELECT * FROM `challan` WHERE `partyname`='$p' AND `is_pakka`=0 AND `paid`=0 AND `is_due`=0";
			$result_due=$db->query($sql_due);
			while($row_due=mysqli_fetch_array($result_due)){
				if($row_due['is_roundof']==1){
					$sum = $sum-$row_due['freight'];
				}
				else{
					$sum = $sum+$row_due['freight'];
				}
			}
			$count++;
			echo '<tr class="r">
				<td><label><input type="checkbox" value="'.$row['ID'].'"> '.$count.'</label></td>
				<td>'.$row['name'].'</td>
				<td>'.$row['particular'].'</td>
				<td>'.$row['address/mobile'].'</td>
				<td>'.$sum.'</td>
			</tr>';
		}
	}
?>
<script>
		$('#c_d input').click(function() { 
			allVals=[];
			$('.r :checked').each(function() {
				allVals.push($(this).val());
			});
		});
</script>