<?php
	$user = $_GET['user'];
	$perm = $_GET['perm'];
	include('../../configure/config.php');
	$sql;
	if($_POST['party']!=''){
		if($_POST['grn']!=''){
			$party=$_POST['party'];
			$grn=$_POST['grn'];
			$sql = "SELECT *, DATE_FORMAT(`dateofdeparture`,'%d-%m-%Y') as `dateofdeparture` FROM `challan` WHERE `partyname`='$party' AND `is_pakka`=0 AND `is_full`=0 AND `G.R.No`='$grn'";
		}
		else{
			$party=$_POST['party'];
			$grn=$_POST['grn'];
			$sql = "SELECT *, DATE_FORMAT(`dateofdeparture`,'%d-%m-%Y') as `dateofdeparture` FROM `challan` WHERE `partyname`='$party' AND `is_pakka`=0 AND `is_full`=0";
		}
		$result = $db->query($sql) or die('sql Error: '.$db->error);
		?>
		<table>
			<thead>
			<tr>
				<th>#</th>
				<th>Date of Departure</th>
				<th>G.R.No</th>
				<th>Marka</th>
				<th>Particular</th>
				<th>Nag</th>
				<th>Weight</th>
				<th>Freight</th>
			</tr>
			</thead>
			<tbody>
				<?php
					$i=0;
					while($row=mysqli_fetch_array($result)){
						$i++;
						echo '<tr>
							<td>'.$i.'</td>
							<td>'.$row['dateofdeparture'].'</td>
							<td>'.$row['G.R.No'].'</td>
							<td>'.$row['marka'].'</td>
							<td>'.$row['particular'].'</td>
							<td>'.$row['nag'].'</td>
							<td>'.$row['weight'].'</td>
							<td>'.$row['freight'].'</td>
						</tr>';
					}
				?>
			</tbody>
		</table>
		<?php
	}
?>