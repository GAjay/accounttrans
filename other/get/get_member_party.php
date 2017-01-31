<?php
	include('../../configure/config.php');
	if(isset($_POST['member'])){
		$member = $_POST['member'];
		$sql = "SELECT `connected_parties` FROM `users` WHERE `partyname`='$member'";
		$result = $db->query($sql) or Die('sql Error:'.$db->error);
		$row = mysqli_fetch_array($result);
		$parties = explode(', ',$row['connected_parties']);
		echo '<option>Select: </option>';
		foreach($parties as $i){
			echo '<option>'.$i.'</option>';
		}
	}
	if(isset($_POST['partyname'])){
		$p_sum = 0;
		$f_sum = 0;
		$partyname = $_POST['partyname'];
		$sql = "SELECT * FROM `challan` WHERE `partyname`='$partyname' ORDER BY `created_at` ASC";
		$result = $db->query($sql) or Die('sql Error:'.$db->error);?>
		<table>
		<tr class="mh">
			<th>Created Date</th>
			<th>Paid Date</th>
			<th>Challan No</th>
			<th>G.R.No</th>
			<th>Nag</th>
			<th>freight</th>
			<th>Paid Amount</th>
			<th>Adjustment</th>
			<th>partyname</th>
			<th>dateofarrival</th>
			<th>truckno</th>
		</tr>
	
<?php	while($row = mysqli_fetch_array($result)){
			$p_sum += $row['paidamount'];
			$f_sum += $row['freight'];
			$adjust = $row['freight']-$row['paidamount'];
			echo '<tr class="j">
				<td>'.$row['created_at'].'</td>
				<td>';
				if($row['paid']==1){
					$paid = $row['paid_at'];
				}
				else{
					$paid = 'Not paid';
				}
				echo $paid.'</td>
				<td>'.$row['challanNo'].'</td>
				<td>'.$row['G.R.No'].'</td>
				<td>'.$row['nag'].'</td>
				<td>'.$row['freight'].'</td>
				<td>'.$row['paidamount'].'</td>
				<td>'.$adjust.'</td>
				<td>'.$row['partyname'].'</td> 
				<td>'.$row['dateofarrival'].'</td>
				<td>'.$row['truckno'].'</td>
			</tr>';
		}
		echo '</table><br><Br>
		<label>Total Freight: '.$f_sum.'</label><br><br><label>Total Paid: '.$p_sum.'</label>
		';
	}
?>