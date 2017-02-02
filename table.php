<?PHP
	include('configure/config.php');
?>
	<head>
	<style>
	table {
		width:100%;
	}
	table, th, td {
		border-color: #0056ff;
		box-shadow: 0px 0px 8px 3px black;
		font-weight:bold;
	}
	th, td {
		padding: 5px;
		text-align: left;
	}
	table tr:nth-child(even) {
		background-color: #eee;
	}
	table tr:nth-child(odd) {
		background-color:#fff;
	}
	table th {
		background-color: black;
		color: white;
	}
	</style>
	</head>
	<body style="margin:40px;padding:10px;background-color: rgba(19, 46, 119, 0.85);">
	<table>
	<tr>
		<th>G.R.No</th>
		<th>Marka</th>
		<th>Nag</th>
		<th>particular</th>
		<th>weight</th>
		<th>freight</th>
		<th>addedby</th>
		<th>paid</th>
		<th>dateofarrival</th>
		<th>truckno</th>
		<th>drivername</th>
		<th>partyname</th>
		<th>created_at</th>
		<th>updated_at</th>
	</tr>
	<?php
		$sql = ("SELECT * FROM `challan`");
		$result = $db->query($sql) or die("Sql Error :" . $db->error);
		while($row = mysqli_fetch_array($result)){
			echo '<tr>		
		<td><input type="number" value="'.$row['challanNo'].'"></td>
		<td><input type="number" value="'.$row['G.R.No'].'"></td>
		<td><input type="number" value="'.$row['Marka'].'"></td>
		<td><input type="number" value="'.$row['Nag'].'"></td>
		<td><input type="number" value="'.$row['particular'].'"></td>
		<td><input type="number" value="'.$row['weight'].'"></td>
		<td><input type="number" value="'.$row['freight'].'"></td>
		<td><input type="number" value="'.$row['addedby'].'"></td>
		<td><input type="number" value="'.$row['paid'].'"></td>
		<td><input type="number" value="'.$row['dateofarrival'].'"></td>
		<td><input type="number" value="'.$row['truckno'].'"></td>
		<td><input type="number" value="'.$row['partyname'].'"></td>
		<td><input type="number" value="'.$row['created_at'].'"></td>
		<td><input type="number" value="'.$row['updated_at'].'"></thd>
			</tr>';
		}
	?>
	</table><br><br>
	
</table>