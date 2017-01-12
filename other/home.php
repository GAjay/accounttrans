<?php
	include('../configure/config.php');
	$user = $_GET['user'];
	$perm = $_GET['perm'];
	if(isset($_GET['update'])){
		echo '<h3 style="color:Black;">Updated your profile</h3>';
	}
	if(isset($_GET['msg'])){
		echo '<h3 style="color:Black;">'.$_GET['msg'].'</h3>';
	}
	$ptrn_update = "/3/";
	$ptrn_paid = "/2/";
	$ptrn_add = "/1/";
	$readonly = null;
	if(!preg_match($ptrn_update,$perm)){$readonly = 'readonly';}
	
?>
<html>
	<head>
		<link rel="stylesheet" href="../css/main.css">
		<script type="text/javascript" src="../js/jquery-1.4.1.min.js"></script>
		<script> var user = "<?php echo $user;?>";var perm = "<?php echo $perm;?>";</script>
	</head>
	<body style="padding:2%"><br><BR>
		<?phpdate( 'Y-m-d H:i:s') ?>
		
		<div align="center">
		<form action="push/home_value.php?user=<?php echo $user;?>&perm=<?php echo $perm;?>" method="post">
			<table id="main_table">
				<tr class="mh">
					<?php
						if(preg_match($ptrn_update,$perm)||preg_match($ptrn_paid,$perm)){
							echo '<th></th>';
						}
					?>
					<th>G.R.No</th>
					<th>Marka</th>
					<th>Nag</th>
					<th>particular</th>
					<th>weight</th>
					<th>freight</th>
					<th>addedby</th>
					<th>dateofarrival</th>
					<th>truckno</th>
					<th>drivername</th>
					<th>partyname</th>
					<th>created_at</th>
					<th>updated_at</th>
				</tr>
				<tr class="fl">
					<?php
						if(preg_match($ptrn_update,$perm)||preg_match($ptrn_paid,$perm)){
							echo '<th></th>';
						}
					?>
					<th><input type="number" id="grn" list="grn_li"></th>
					<?php
						$sql = ("SELECT `G.R.No` FROM `challan` WHERE `paid`=0 group by `G.R.No`");
						$result = $db->query($sql) or die("Sql Error :" . $db->error);
						echo '<datalist id="grn_li"><select>';
						while($row = mysqli_fetch_array($result)){
							echo '<option>'.$row['G.R.No'].'</option>';
						}
						echo '</select></datalist>';
					?>
					<th><input type="text" id="mrk" list="mrk_li"></th>
					<datalist id="mrk_li"><select id="mrk_li_option">
						<?php
							$sql = ("SELECT `marka` FROM `challan` WHERE `paid`=0 group by marka");
							$result = $db->query($sql) or die("Sql Error :" . $db->error);
							while($row = mysqli_fetch_array($result)){
								echo '<option>'.$row['marka'].'</option>';
							}
						?>
					</select></datalist>
					<th></th>
					<th></th>
					<th></th>
					<th><input type="text" id="frght"></th>
					<th></th>
					<th><input type="date" id="doa"></th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
				<?php
					$sql = ("SELECT * FROM `challan` WHERE `paid`=0");
					$result = $db->query($sql) or die("Sql Error :" . $db->error);
					$count = 0;
					while($row = mysqli_fetch_array($result)){
						echo '<tr class="j">';
							$count++;
							if(preg_match($ptrn_update,$perm)||preg_match($ptrn_paid,$perm)){
								echo '<td><input type="checkbox" name="count[]" value="'.$count.'" ></td>';
							}
							echo '
							<td><input type="number" name="'.$count.'_g_r_no" value="'.$row['G.R.No'].'" '.$readonly.'></td>
							<td><input type="text" name="'.$count.'_marka" value="'.$row['marka'].'" '.$readonly.'></td>
							<td><input type="number" name="'.$count.'_nag" value="'.$row['nag'].'" '.$readonly.'></td>
							<td><input type="text" name="'.$count.'_particular" value="'.$row['particular'].'" '.$readonly.'></td>
							<td><input type="text" name="'.$count.'_weight" value="'.$row['weight'].'" '.$readonly.'></td>
							<td><input type="text" name="'.$count.'_freight" value="'.$row['freight'].'" '.$readonly.'></td>
							<td><input type="text" name="'.$count.'_addedby" value="'.$row['addedby'].'" readonly></td>
							<td><input type="" name="'.$count.'_dateofarrival" value="'.$row['dateofarrival'].'" '.$readonly.'></td>
							<td><input type="text" name="'.$count.'_truckno" value="'.$row['truckno'].'" '.$readonly.'></td>
							<td><input type="text" name="'.$count.'_drivername" value="'.$row['drivername'].'" '.$readonly.'></td>
							<td><input type="text" name="'.$count.'_partyname" value="'.$row['partyname'].'" '.$readonly.'></td>
							<td><input type="" name="'.$count.'_created_at" value="'.$row['created_at'].'" readonly></td>
							<td><input type="" name="'.$count.'_updated_at" value="'.$row['updated_at'].'" readonly.></thd>
						</tr>';
					}
				?>
			</table>
			<img align="center" src="../img/loading.gif" id="loading" height="90px">
			<script type="text/javascript" src="../js/home.js"></script>
			
			<br><br><br>
			<input id="fn" type="hidden" name="fn">
			<?php
				if($readonly != "readonly"){
					echo '<button id="update" onclick="update_fn()" type="submit">Update Challan</button> ';
				}
				if(preg_match($ptrn_paid,$perm)||preg_match($ptrn_update,$perm)){
					echo ' <button id="paid" onclick="paid_fn()" type="submit">Paid</button>';
				}
			?>
			<input type="hidden" id="upload_record" name="upload_record">
			<div id="upload_record_fild"></div>
		</form>
		</div>
		
		<?php
			if(preg_match($ptrn_add,$perm)||preg_match($ptrn_update,$perm)){
				echo '<button id="add" type="submit">Add Challan</button>';
			}
		?><div id="cancel_fild"></div>
		</body>
</html>
<script>
	function update_fn(){
		$('#fn').val('update_record');
	};
	function paid_fn(){
		$('#fn').val('paid_record');
	};
</script>