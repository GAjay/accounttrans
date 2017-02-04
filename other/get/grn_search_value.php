<?php
	include('../../configure/config.php');
	if(isset($_POST['grn'])){
		$grn=$_POST['grn'];
		$sql = "SELECT *, DATE_FORMAT(`dateofdeparture`,'%d-%m-%Y') as `dateofdeparture` FROM `challan` WHERE `G.R.No`='$grn' AND `is_pakka`=0";
		$result = $db->query($sql) or die("Sql Error :" . $db->error);
		$total_paid=0;
		$total_freight=0;
		$total_admjustment=0;
		$count = mysqli_num_rows($result);
		if($count>0){
		echo '<table>
		<tr>
			<th>Challan No</th>
			<th>G.R.No</th>
			<th>Marka</th>
			<th>Nag</th>
			<th>weight</th>
			<th>freight</th>
			<th>Adjustment</th>
			<th>Paid Amount</th>
			<th>partyname</th>
			<th>dateofdeparture</th>
			<th>truckno</th>
		</tr>';
		
		while($row = mysqli_fetch_array($result)){
			echo '<tr>
				<td>'.$row['challanNo'].'</td>
				<td>'.$row['G.R.No'].'</td>
				<td>'.$row['marka'].'</td>
				<td>'.$row['nag'].'</td>
				<td>'.$row['weight'].'</td>
				<td>'.$row['freight'].'</td>
				<td>';
				if($row['adjustment']==0){echo 'No adjustment';}else{echo $row['adjustment'];}$paid=$row['freight']-$row['adjustment'];
				$p_id=$row['partyname'];
				$p_sql = "SELECT * FROM `party` WHERE `ID`='$p_id'";
				$p_result = $db->query($p_sql) or die("Sql Error :" . $db->error);
				$p_row = mysqli_fetch_array($p_result);
				echo '</td>
				<td>'.$paid.'</td>
				<td>'.$p_row['name'].'</td>
				<td>'.$row['dateofdeparture'].'</td>
				<td>'.$row['truckno'].'</td>
			</tr>';
			$total_paid=$total_paid+$paid;
			$total_freight=$total_freight+$row['freight'];
			$total_admjustment=$total_admjustment+$row['adjustment'];
		}
		echo'<br><div align="left"><label>Total Freight: '.$total_freight.'</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>Total Adjustment: '.$total_admjustment.'</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>Total Paid: '.$total_paid.'</label></div>
		<br></table>';
		}
		else{
			echo '<h2>G.R.No is invalide</h2>';
		}
	}
?>
