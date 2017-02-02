<?php
	$user = $_GET['user'];
	$perm = $_GET['perm'];
	$ptrn_update = "/3/";
	$ptrn_paid = "/2/";
	$ptrn_add = "/1/";
	include('../../configure/config.php');
	if(isset($_POST['month'])){
		$month=$_POST['month'];
		$sql = "SELECT `paid_at`, sum(`freight`) - sum(`adjustment`) as `total amount` FROM `challan` WHERE Month(`paid_at`)='$month' AND `paid`=1 AND `is_pakka`=0 group by `paid_at`";
		$result = $db->query($sql) or die('sql Error: '.$db->error);
		$count = 0;
		$count_row = mysqli_num_rows($result);
		if($count_row >0){
		echo '<table style="width:70%;">
			<thead><tr>
				<th>#</th>
				<th>Paid Date</th>
				<th>Total Collection</th>
			</tr></thead><tbody>';
			while($row = mysqli_fetch_array($result)){
				$count++;
				echo '<tr class="tr">
					<td>'.$count.'</td>
					<td>'.$row['paid_at'].'</td>
					<td>'.$row['total amount'].'</td>
				</tr>';
			}
		echo '</tbody></table>';
		}
		else{
			echo '<h2>No Statement</h2>';
		}
	}
?>