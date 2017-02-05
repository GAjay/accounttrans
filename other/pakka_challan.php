<?php
	include('../configure/config.php');
	include('../configure/session.php');
	$user = $_SESSION['login_user'];
	$perm = $_SESSION['permission'];
	$ptrn_update = "/3/";
	$ptrn_paid = "/2/";
	$ptrn_add = "/1/";
	if(isset($_GET['msg'])){
		echo '<h3 style="color:Black;">'.$_GET['msg'].'</h3>';
	}
	$readonly = 'readonly';
	
?>
<html>
	<head>
		<link rel="stylesheet" href="../css/main.css">
		<script type="text/javascript" src="../js/jquery-1.4.1.min.js"></script>
		<script> var user = "<?php echo $user;?>";var perm = "<?php echo $perm;?>";var pakka=1;</script>
		
	</head>
	<body style="padding:2%">
	<h1 class="heading">Pakka Challan</h1>
		<?php
			if(preg_match('/8,9,1,2,3/',$perm)){
				echo '<button class="button button5" id="all_edit_btn">All Field Editable</button>';
			}
		?>
		<?php
				if(preg_match($ptrn_update,$perm)){
					echo '<button class="button button2"form="pakka_update" id="update" onclick="update_fn()" type="submit">Update Challan</button> ';
				}
			?>
		
		<form id="pakka_update" action="push/home_value.php?user=<?php echo $user;?>&perm=<?php echo $perm;?>&pakka=challan" method="post" onkeypress="return event.keyCode != 13;">
			

			<table id="main_table">
				<tr class="mh">
					<th>#</th>
					<th>Challan No</th>
					<th>G.R.No</th>
					<th>Marka</th>
					<th>Nag</th>
					<th>particular</th>
					<th>weight</th>
					<th>freight</th>
					<th>partyname</th>
					<th>dateofdeparture</th>
					<th>truckno</th>
					<th></th>
				</tr>
				<tr class="fl">
					<th>
					<?php
						if(preg_match($ptrn_update,$perm)){
							echo '<input type="checkbox" id="all_select" >';
						}
					?>
					</th>
					<th></th>
					<th><input type="number" id="grn" list="grn_li"></th>
					<?php
						$sql = ("SELECT `G.R.No` FROM `challan` WHERE `paid`=0 AND `is_pakka`=1 group by `G.R.No`");
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
							$sql = ("SELECT `marka` FROM `challan` WHERE `paid`=0 AND `is_pakka`=1 group by marka");
							$result = $db->query($sql) or die("Sql Error :" . $db->error);
							while($row = mysqli_fetch_array($result)){
								echo '<option>'.$row['marka'].'</option>';
							}
						?>
					</select></datalist>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th><select id="party_search">
						<option value="">--select--</option>
								<?php	$sql1="SELECT * FROM `party` WHERE `type`=1";
									$result1 = $db->query($sql1) or die("Sql Error :" . $db->error);
									while($row1 = mysqli_fetch_array($result1)){
										echo '<option value="'.$row1['ID'].'">'.$row1['name'].'</option>';
									}
								?>
								</select></th>
					<th><input type="text" id="dod" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{2}" placeholder="dd-mm-yy"></th>
					<th></th>
					<th></th>
				</tr>
				<tr class="j">
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td><h2>Please Select Party First</h2></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</table>
			<img align="center" src="../img/loading.gif" id="loading" height="90px">
			<script type="text/javascript" src="../js/home.js"></script>
			
			<input id="fn" type="hidden" name="fn">
	
		</form>
		</div>
		
		
		</body>
</html>



<script>
	var count = 0;
	$('#remove').hide();
	function update_fn(){
		$('#fn').val('update_record');
	};
</script>
