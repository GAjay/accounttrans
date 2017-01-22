<?php
	include('../configure/config.php');
	include('../configure/session.php');
	$user = $_SESSION['login_user'];
	$perm = $_SESSION['permission'];
	if(isset($_GET['create'])){
		echo '<h3 style="color:Black;">Create Member Successfully</h3>';
	}
	if(isset($_GET['update'])){
		echo '<h3 style="color:Black;">Updated your profile</h3>';
	}
	if(isset($_GET['msg'])){
		echo '<h3 style="color:Black;">'.$_GET['msg'].'</h3>';
	}
	$ptrn_update = "/3/";
	$ptrn_paid = "/2/";
	$ptrn_add = "/1/";
	$readonly = 'readonly';//null;
	if(!preg_match($ptrn_update,$perm)){$readonly = 'readonly';}
	
?>
<html>
	<head>
		<link rel="stylesheet" href="../css/main.css">
		<script type="text/javascript" src="../js/jquery-1.4.1.min.js"></script>
		<script> var user = "<?php echo $user;?>";var perm = "<?php echo $perm;?>";</script>
		<style>
			input[type="text"],input[type="number"],input[type="date"]{
				width:130px;
			}
		</style>
	</head>
	<body style="padding:2%"><br><BR>
		
		<div align="center">
		<?php
			if(preg_match($ptrn_add,$perm)||preg_match($ptrn_update,$perm)){
				echo '<div align="left"><button id="add" type="submit">Add Challan</button>&nbsp;&nbsp;<button id="remove" type="submit">Remove Row</button></div>';
			}
		?><div id="cancel_fild"></div><br><br>
		
		
		
		<form action="push/home_value.php?user=<?php echo $user;?>&perm=<?php echo $perm;?>" method="post" onkeypress="return event.keyCode != 13;">
		<?php
				if(preg_match($ptrn_update,$perm)){
					echo '<button id="update" onclick="update_fn()" type="submit">Update Challan</button> ';
				}
				if(preg_match($ptrn_paid,$perm)||preg_match($ptrn_update,$perm)){
					echo ' <button id="paid" onclick="paid_fn()" type="submit">Paid</button>';
				}
			?>
			<input type="hidden" id="upload_record" name="upload_record">
			<div id="upload_record_fild"></div>
		<br><BR><br><div id="same" align="lef"t"></div><script id="scr"></script>
			<table id="main_table">
				<tr class="mh">
					<?php
						if(preg_match($ptrn_update,$perm)||preg_match($ptrn_paid,$perm)){
							echo '<th></th>';
						}
					?>
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
				<tr class="fl">
					<?php
						if(preg_match($ptrn_update,$perm)||preg_match($ptrn_paid,$perm)){
							echo '<th><input type="checkbox" id="all_select" ></th>';
						}
					?>
					<th></th>
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
					<th><input type="text" id="frght"></th>
					<th></th>
					<th><input type="date" id="doa"></th>
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
								echo '<td><input type="checkbox" id="'.$count.'" name="count[]" value="'.$count.'" >
								<input type="hidden" name="'.$count.'_id_value" value="'.$row['ID'].'"></td>';
							}
							echo '
							<td>'.$row['challanNo'].'</td>
							<td>'.$row['G.R.No'].'</td>
							<td>'.$row['marka'].'</td>
							<td>'.$row['nag'].'</td>
							<td><input class="'.$count.'_read" type="text" name="'.$count.'_weight" value="'.$row['weight'].'" '.$readonly.'></td>
							<td><input class="'.$count.'_read" type="text" name="'.$count.'_freight" value="'.$row['freight'].'" '.$readonly.'></td>
							<td><input class="'.$count.'_read" type="text" name="'.$count.'_partyname" value="'.$row['partyname'].'" '.$readonly.' list="party_list">
								<datalist id="party_list">
								<select>';
									$sql1="SELECT `name` FROM `party`";
									$result1 = $db->query($sql1) or die("Sql Error :" . $db->error);
									while($row1 = mysqli_fetch_array($result1)){
										echo '<option>'.$row1['name'].'</option>';
									}
								
								echo '</select>
								</datalist>
							</td>
							<td>'.$row['dateofarrival'].'</td>
							<td>'.$row['truckno'].'</td>
						</tr>';
					}
				?>
			</table>
			<img align="center" src="../img/loading.gif" id="loading" height="90px">
			<script type="text/javascript" src="../js/home.js"></script>
			
			<br><br><br>
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
	function paid_fn(){
		$('#fn').val('paid_record');
	};
	<?php $j=$count;
		if(preg_match($ptrn_update,$perm)){
		while($count>0){
			echo '$("#'.$count.'").click(function(){
				if($(this).is(":checked")){
					$(".'.$count.'_read").attr("readonly",false);
				}
				else{
					$(".'.$count.'_read").attr("readonly",true);
				}
			});';
			$count--;
		}
		}
	?>
	$("#all_select").click(function(){
		$('input:checkbox').not(this).attr('checked', this.checked);
		<?php
			if(preg_match($ptrn_update,$perm)){
			while($j>0){echo '
				if($(this).is(":checked")){
					$(".'.$j.'_read").attr("readonly",false);
				}
				else{
					$(".'.$j.'_read").attr("readonly",true);
				}';
				$j--;
			}
			}
		?>
	});
	$('#add').click(function(){
		$('h3').remove();
		$('#loading').show();
		var scr;
		if(count == 0){
			var new_doa = null;
			$('#update').remove();
			$('#paid').remove();
			$('#fn').remove();
			$('#main_table').find('tr').remove();
			scr="$('#dateofarrival').change(function(){$('#1_dateofarrival').val($(this).val());});";
			same='<label>Truck No: </label><input type="text" name="truckno" required>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>Challan No: </label><input type="number" name="challan" required><br><br><label>Date of Arrival: </label><input type="date" id="dateofarrival" name="dateofarrival" required><br><br>';
			html = '<tr><th>G.R.No</th><th>Marka</th><th>Nag</th><th>Particular</th><th>Weight</th><th>Freight</th><th>Party Name</th><th>Date of Arrival</th></tr>';
			$('#same').html(same);
			$('#main_table').append(html);
		}
		else{
			new_doa = $('#dateofarrival').val();
		}
			count++;
		html = '<tr class="'+count+'">'+
				'<td><input type="number" name="'+count+'_g_r_no" ></td>'+
				'<td><input type="text" name="'+count+'_marka"></td>'+
				'<td><input type="number" name="'+count+'_nag"></td>'+
				'<td><input type="text" name="'+count+'_particular"></td>'+
				'<td><input type="text" name="'+count+'_weight"></td>'+
				'<td><input type="text" name="'+count+'_freight"></td>'+
				'<td id="'+count+'_apnd"><input type="text" name="'+count+'_partyname" list="party_list"><datalist id="party_list"><select>'+
				'<?php	
					$sql1="SELECT `name` FROM `party`"; 
					$result1 = $db->query($sql1) or die("Sql Error :" . $db->error); 
					while($row1 = mysqli_fetch_array($result1)){ 
					echo "<option>".$row1['name']."</option>"; 
					} 
				?>'+
				'</select></datalist></td>'+
				'<td><input type="date" id="'+count+'_dateofarrival" name="'+count+'_dateofarrival"></td>'+
				'</tr>';
		$('#main_table').append(html);
		if(count-1==0){
			$('#scr').append(scr);
		}
		if(new_doa != null){
			$('#'+count+'_dateofarrival').val(new_doa);
		}
		else{
			$("#add").html('Add Row');
			$('#remove').show();
			$("#upload_record_fild").html('<button id="upload_record_btn" type="submit">Upload Record</button>');
			$("#cancel_fild").html('<button id="cancel_btn" type="submit">Cancel</button>');
		}
		$('#loading').hide();
		$('#upload_record').val(count);
	});
	$('#remove').click(function(){
		$('.'+count).remove();
		if(count>0){
		count--;
		}
		$('#upload_record').val(count);
	});
	$("#cancel_fild").click(function(){
		window.location.href = 'home.php?user='+user+'&perm='+perm;
	});
</script>