<?php
	include('../../configure/config.php');
	$challan=null;
	if(isset($_POST['challanNo'])&&!isset($_POST['grn'])){
		$challan=$_POST['challanNo'];
		$sql = "SELECT `G.R.No` FROM `challan` WHERE `challanNo`='$challan'";
		$result = $db->query($sql) or die("Sql Error :" . $db->error);
		while($row = mysqli_fetch_array($result)){
			echo '<option>'.$row['G.R.No'].'</option>';
		}
	}
	else if(isset($_POST['challanNo'])&&isset($_POST['grn'])){
		$challan=$_POST['challanNo'];
		$grn=$_POST['grn'];
		$sql = "SELECT * FROM `challan` WHERE `challanNo`='$challan' AND `G.R.No`='$grn'";?>
		<table>
		<tr>
			<th>Created Date</th>
			<th>Challan No</th>
			<th>G.R.No</th>
			<th>Marka</th>
			<th>Nag</th>
			<th>weight</th>
			<th>freight</th>
			<th>Paid Amount</th>
			<th>Adjustment</th>
			<th>partyname</th>
			<th>dateofarrival</th>
			<th>truckno</th>
		</tr><?php
		$result = $db->query($sql) or die("Sql Error :" . $db->error);
		while($row = mysqli_fetch_array($result)){
			echo '<tr>
				<td>'.$row['created_at'].'</td>
				<td>'.$row['challanNo'].'</td>
				<td>'.$row['G.R.No'].'</td>
				<td>'.$row['marka'].'</td>
				<td>'.$row['nag'].'</td>
				<td>'.$row['weight'].'</td>
				<td>'.$row['freight'].'</td>
				<td>'.$row['paidamount'].'</td>';
				$adjustment = $row['freight'] - $row['paidamount'];
				echo '<td>'.$adjustment.'</td>
				<td>'.$row['partyname'].'</td>
				<td>'.$row['dateofarrival'].'</td>
				<td>'.$row['truckno'].'</td>
			</tr>';
		}
		echo'</table>';
	}
?>
