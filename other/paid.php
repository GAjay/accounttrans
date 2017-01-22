<?PHP
	include('../configure/config.php');
	$user = $_GET['user'];
	$perm = $_GET['perm'];
	$ptrn = "/3/";
	$readonly = null;
	if(!preg_match($ptrn,$perm)){$readonly = 'readonly';}
	$j=0;
	$change=array();
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$result;
		if($_POST['i_change']!='-1'){
			$i_change = $_POST['i_change'];
			$s = explode(",",$i_change);
			foreach($s as $i){
				$id = $_POST[$i.'_id_value'];
				$weight = $_POST[$i.'_weight'];
				$freight = $_POST[$i.'_freight'];
				$sql = ("UPDATE `challan` SET 
				`weight`='$weight',`freight`='$freight', `updated_at` = '".date( 'Y-m-d H:i:s')."'
				WHERE `ID`='$id'");
				$result = $db->query($sql) or die("Sql Error :" . $db->error);
			}	
			if($result){
					echo '<h2>Updated Data</h2>';
				}
		}
	}
?>
<html>
	<head>
	<link rel="stylesheet" href="../css/main.css">
	<script type="text/javascript" src="../js/jquery-1.4.1.min.js"></script>
	</head>
	<body style="padding:2%;" align="center">
		<br><br><h3 >Paid Challan</h3>
		<form action="" method="post">
			<table>
				<tr>
					<th>Challan No</th>
					<th>G.R.No</th>
					<th>Marka</th>
					<th>Nag</th>
					<th>weight</th>
					<th>freight</th>
					<th>partyname</th>
					<th>dateofarrival</th>
					<th>truckno</th>
				</tr>
				<?php
					$sql = ("SELECT * FROM `challan` WHERE `paid`=1");
					$result = $db->query($sql) or die("Sql Error :" . $db->error);
					$weight = 0;
					$freight = 0;
					$i=1;
					while($row = mysqli_fetch_array($result)){
						echo '<tr>
							<td>'.$row['challanNo'].'</td>
							<td><input type="hidden" name="'.$i.'_id_value" value="'.$row['ID'].'">'.$row['G.R.No'].'</td>
							<td>'.$row['marka'].'</td>
							<td>'.$row['nag'].'</td>
							<td><input type="text" name="'.$i.'_weight" id="'.$i.'_weight" value="'.$row['weight'].'" '.$readonly.'></td>
							<td><input type="text" name="'.$i.'_freight" id="'.$i.'_freight" value="'.$row['freight'].'" '.$readonly.'></td>
							<td>'.$row['partyname'].'</td>
							<td>'.$row['dateofarrival'].'</td>
							<td>'.$row['truckno'].'</td>
						</tr>';
						$i++;
					}
					echo '<input type="hidden" id="i" value="'.$i.'"><input type="hidden" id="i_change" name="i_change" value="-1">';
					$j=$i-1;
				?>
			</table><br><br>
			<label>Total Weight:</label><input type="text" id="total_weight" readonly><br>
			<label>Total Freight:</label><input type="text" id="total_freight" readonly><br><br>
			<?php 
				if($readonly != 'readonly'){
					echo '<button id="update" type="submit">Update</button>';
				}
			?>
		</form>
	</body>
</html>
<script>
	$(document).ready(function(){
		var i = $('#i').val()-1;
		var i_change = [];
		var total_weight=0;
		var total_freight=0;
		while(i>0){
			total_freight = total_freight+(+$('#'+i+'_freight').val());
			total_weight = total_weight+(+$('#'+i+'_weight').val());
			i--;
		}
		$('#total_freight').val(total_freight);
		$('#total_weight').val(total_weight);
		<?php
		while($j>0){
		echo "$('#".$j."_weight').bind('keyup change', function(){
			total_weight=0;
			i = $('#i').val()-1;
			while(i>0){
				total_weight = total_weight+(+$('#'+i+'_weight').val());
				i--;
			}
			$('#total_weight').val(total_weight);
			i_change.push(".$j.");
			$('#i_change').val(i_change);
		});
		$('#".$j."_freight').bind('keyup change', function(){
			total_freight=0;
			i = $('#i').val()-1;
			while(i>0){
				total_freight = total_freight+(+$('#'+i+'_freight').val());
				i--;
			}
			$('#total_freight').val(total_freight);
			i_change.push(".$j.");
			$('#i_change').val(i_change);
		});";$j--;}
		?>
	});
</script>