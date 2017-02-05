<?php
	$user = $_GET['user'];
	$perm = $_GET['perm'];
	include('../../configure/config.php');
	$sql;
	if($_POST['party']!=''){
		$p=null;
		$party=explode(',',$_POST['party']);
		foreach($party as $p){
		if($_POST['grn']!=''){
			$grn=$_POST['grn'];
			$sql = "SELECT *, `challan`.`ID`, `challan`.`particular` AS `particular`, `party`.`name`, DATE_FORMAT(`challan`.`dateofdeparture`,'%d-%m-%Y') as `dateofdeparture` FROM `challan` INNER JOIN `party` ON `party`.`ID`=`challan`.`partyname` AND `challan`.`partyname`='$p' AND `challan`.`is_pakka`=0 AND `challan`.`paid`=0 AND `challan`.`G.R.No`='$grn' AND `challan`.`is_due`=0";
		}
		else{
			
			$grn=$_POST['grn'];
			$sql = "SELECT *, `challan`.`ID`, `challan`.`particular` AS `particular`, `party`.`name`, DATE_FORMAT(`challan`.`dateofdeparture`,'%d-%m-%Y') as `dateofdeparture` FROM `challan` INNER JOIN `party` ON `party`.`ID`=`challan`.`partyname` AND `challan`.`partyname`='$p' AND `challan`.`is_pakka`=0 AND `challan`.`paid`=0 AND `challan`.`is_due`=0";
		}
		$sum=0;
		$result = $db->query($sql) or die('sql Error: '.$db->error);
		$count = mysqli_num_rows($result);
		if($count>0){
		echo '<div align="center"><h7>!! Jai Baba Ramdev Ji !!</h7></div><br><label id="'.$p.'_pn"></label><br><br><table id="'.$p.'" style="page-break-after:always">';
				
		?>
		
			<thead>
			<tr>
				<th>Date of Departure</th>
				<th>Gr.No</th>
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
						if($i==1){
							echo '<script>$("#'.$p.'_pn").html("Party Name: '.$row['name'].'");</script>';
						}
						echo '<tr>
							<td>'.$row['dateofdeparture'].'</td>
							<td>'.$row['G.R.No'].'</td>
							<td>'.$row['marka'].'</td>
							<td>'.$row['particular'].'</td>
							<td>'.$row['nag'].'</td>
							<td>'.$row['weight'].'</td>
							<td>'.$row['freight'].'</td>
						</tr>';
						if($row['is_roundof']==1){
							$sum = $sum-$row['freight'];
						}
						else{
							$sum = $sum+$row['freight'];
						}
						if($i == 10){
							echo '<tr><td></td><td></td><td></td><td></td><td></td><td></td><td>continue..</td></tr></tbody></table>
							<div align="center" ><h7>!! Jai Baba Ramdev Ji !!</h7></div><br><label>Party Name: '.$row['name'].'</label>
							<br><br><table id="'.$p.'" style="page-break-after:always">
							<thead>
							<tr>
								<th>Date of Departure</th>
								<th>Gr.No</th>
								<th>Marka</th>
								<th>Particular</th>
								<th>Nag</th>
								<th>Weight</th>
								<th>Freight</th>
							</tr>
							</thead>
							<tbody>
							';$i=0;
						}
					}
					echo '<tr><td></td><td></td><td></td><td></td><td></td><td>Total: </td><td>'.$sum.'</td></tr>';
				?>
			</tbody>
		</table>
		
		<?php
	}
		}
	}
?>
<script>
	$(document).ready(function(){
			var divContents = $("#report").html();
			var printWindow = window.open('', '', 'height=600px,width=600px');
			printWindow.document.write('<html><head>');
			printWindow.document.write('<style>  @page {size: 8.3in 5.3in;} @media print{ body{margin:0 auto;width:90%;}table {cell-padding:2px;width:100%;}table,thead tr{border: 1px solid black;    border-collapse: collapse;}th, td {    padding: 5px;    text-align: left;}table tr:nth-child(even) {    background-color: #eee;}table tr:nth-child(odd) {    background-color:#fff;}table th {    background-color: White;    color: Black; font-width:bold;}}</style>');
			printWindow.document.write('</head><body>');
			printWindow.document.write(divContents);
			printWindow.document.write('</body></html>');
			printWindow.document.close();
			printWindow.print();
		});
</script>