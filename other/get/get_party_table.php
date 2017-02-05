<?php
	include('../../configure/config.php');
	$try=false;
	if(isset($_POST['partyname'])){
		$party = $_POST['partyname'];
		$paid_at = $_POST['paid_at'];
		$p_sql = "SELECT * FROM `party` WHERE `ID`='$party'";
		$p_result = $db->query($p_sql) or die("Sql Error :" . $db->error);
		$p_row = mysqli_fetch_array($p_result);
		$sql = "SELECT *, DATE_FORMAT(`dateofdeparture`,'%d-%m-%Y') as `dateofdeparture` FROM `challan` WHERE `partyname`='$party' AND (`paid`=1 OR (`paid`=0 AND `is_full`=0 AND `is_due`=1)) AND `is_pakka`=0 AND `paid_at`='$paid_at'";
		$result = $db->query($sql) or Die('sql Error:'.$db->error);
		echo '<h3>Party: '.$p_row['name'].'</h3>';
		?>
		<table>
			<tr class="mh">
				<th>Challan No</th>
				<th>G.R.No</th>
				<th>Marka</th>
				<th>Nag</th>
				<th>Particular</th>
				<th>Weight</th>
				<th>Freight</th>
				<th>Adjustment</th>
				<th>Paid</th>
				<th>dateofdeparture</th>
				<th>truckno</th>
			</tr>
<?php		
		while($row = mysqli_fetch_array($result)){
			echo '<tr class="j">
				<td>'.$row['challanNo'].'</td>
				<td>'.$row['G.R.No'].'</td>
				<td>'.$row['marka'].'</td>
				<td>'.$row['nag'].'</td>
				<td>'.$row['particular'].'</td>
				<td>'.$row['weight'].'</td>
				<td>'.$row['freight'].'</td>
				<td>'.$row['adjustment'].'</td>
				<td>'.($row['freight']-$row['adjustment']).'</td>
				<td>'.$row['dateofdeparture'].'</td>
				<td>'.$row['truckno'].'</td>
			</tr>';
		}
		echo '</table>';	
	}
?>