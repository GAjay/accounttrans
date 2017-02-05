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
	$readonly = 'readonly';
	
?>
<html>
	<head>
		<link rel="stylesheet" href="../css/main.css">
		<script type="text/javascript" src="../js/jquery-1.4.1.min.js"></script>
		<script> var user = "<?php echo $user;?>";var perm = "<?php echo $perm;?>";var pakka=0;</script>
		
	</head>
	<body class="content">
	<h1 class="heading">Challan</h1>
		
		<div class="button_left">
		<?php
			if(preg_match($ptrn_add,$perm)||preg_match($ptrn_update,$perm)){
		echo '<button class="button button2 add"  type="submit">Add Challan</button><button class="remove button button3" type="submit">Remove Row</button>';
			}
		?></div>
<div class="button_right">
		<span id="cancel_fild"></span>
		<span id="upload_record_fild"></span></div>

		
		<?php
			if(preg_match($ptrn_update,$perm)){
					echo '<button class="button button1" form="update_challan_home" id="update" onclick="update_fn()" type="submit">Update Challan</button> ';
				}
			if(preg_match('/8,9,1,2,3/',$perm)){
				echo '<button class="button button2" id="all_edit_btn">All Field Editable</button>';
			}
		?>
<div class="clearfix"></div>
		<form id="update_challan_home" action="push/home_value.php?user=<?php echo $user;?>&perm=<?php echo $perm;?>" method="post" onkeypress="return event.keyCode != 13;">
			<?php
				
			?>
			<input type="hidden" id="upload_record" name="upload_record">
			
		<div id="same" align="lef"t"></div><script id="scr"></script>
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
					<th>D.O.B</th>
					<th>truckno</th>
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
						$sql = ("SELECT `G.R.No` FROM `challan` WHERE `paid`=0 AND `is_pakka`=0 AND `is_roundof`=0 AND `is_due`=0 group by `G.R.No`");
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
							$sql = ("SELECT `marka` FROM `challan` WHERE `paid`=0 AND `is_pakka`=0 AND `is_roundof`=0 AND `is_due`=0 group by marka");
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
						<?php	$sql1="SELECT * FROM `party` WHERE `type`=0";
							$result1 = $db->query($sql1) or die("Sql Error :" . $db->error);
							while($row1 = mysqli_fetch_array($result1)){
								if($row1['name']=='Default'){
									echo '<option value="'.$row1['ID'].'" selected>'.$row1['name'].'</option>';
								}
								else{
									echo '<option value="'.$row1['ID'].'">'.$row1['name'].'</option>';
								}
							}
						?>
					</select></th>
					<th><input type="text" id="dod" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{2}" placeholder="dd-mm-yy"></th>
					<th></th>
				</tr>
				<?php
					$sql = ("SELECT *, DATE_FORMAT(`dateofdeparture`,'%d-%m-%Y') as `dateofdeparture` FROM `challan` WHERE `paid`=0 AND partyname='1' AND `is_pakka`=0 AND `is_roundof`=0 AND `is_due`=0");
					$result = $db->query($sql) or die("Sql Error :" . $db->error);
					$count = 0;
					while($row = mysqli_fetch_array($result)){
						echo '<tr class="j">';
							$count++;
							echo '<td><label>';
							if(preg_match($ptrn_update,$perm)){
								echo '<input type="checkbox" id="'.$count.'" name="count[]" value="'.$count.'" >
								<input type="hidden" name="'.$count.'_id_value" value="'.$row['ID'].'">';
							}
							echo $count.'</label></td>
							<td>'.$row['challanNo'].'</td>
							<td>'.$row['G.R.No'].'</td>
							<td>'.$row['marka'].'</td>
							<td>'.$row['nag'].'</td>
							<td>'.$row['particular'].'</td>
							<td>'.$row['weight'].'</td>
							<td><input class="'.$count.'_read" type="text" name="'.$count.'_freight" value="'.$row['freight'].'" '.$readonly.'></td>';
							$p_id = $row['partyname'];
							echo '<td>
								<select name="'.$count.'_partyname">';
									$sql2="SELECT * FROM `party`";
									$result2 = $db->query($sql2) or die("Sql Error :" . $db->error);
									while($row2 = mysqli_fetch_array($result2)){
										if($row2['ID']==$p_id){
											echo '<option value="'.$row2['ID'].'" selected>'.$row2['name'].'</option>';
										}
										else{
											echo '<option value="'.$row2['ID'].'">'.$row2['name'].'</option>';
										}
									}
								
								echo '</select>
							</td>
							<td>'.$row['dateofdeparture'].'</td>
							<td>'.$row['truckno'].'</td>
						</tr>';
					}
				?>
			</table>
			<img align="center" src="../img/loading.gif" id="loading" height="90px">
			<script type="text/javascript" src="../js/home.js"></script>
			
			<input id="fn" type="hidden" name="fn">
	
		</form>
		<?php
			if(preg_match($ptrn_add,$perm)||preg_match($ptrn_update,$perm)){
				echo '<button class="add button button2" id="2add" type="submit">Add Challan</button><button class="remove button button3" type="submit">Remove Row</button>';
			}
		?>
		
		</body>
</html>



<script>
	var count = 0;
	$('.remove').hide();
	$('#2add').hide();		//After Table Add Challan Button Hide 
	function update_fn(){
		$('#fn').val('update_record');
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
	$('.add').click(function(){
		$('.heading').text("Add Challan");
		$('#2add').show();		//After Table Add Row Button Show
		$('#all_edit_btn').hide();
		$('h3').remove();
		$('#loading').show();
		var scr;
		if(count == 0){
			var new_dod = null;
			$('#update').remove();
			$('#paid').remove();
			$('#fn').remove();
			$('#main_table').find('tr').remove();
			scr="/*$('#all_dateofdeparture').change(function(){$('.dateofdeparture').val($(this).val());});*/";
			same='<div class="center_home"><label>Truck No: </label><input type="text" name="truckno" required><label>Challan No: </label><input type="number" name="challan" required><label>Date of Departure: </label><input type="text" required="" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{2}" placeholder="dd-mm-yy" id="all_dateofdeparture" name="dateofdeparture" required></div>';
			html = '<tr><th>#</th><th>G.R.No</th><th>Marka</th><th>Nag</th><th>Particular</th><th>Weight</th><th>Freight</th><th>Party Name</th><th>Date of Departure</th></tr>';
			$('#same').html(same);
			$('#main_table').append(html);
		}
		else{
			new_dod = $('#all_dateofdeparture').val();
		}
			count++;
		html = '<tr class="'+count+'">'+
				'<td>'+count+'</td>'+
				'<td><input type="number" name="'+count+'_g_r_no" required></td>'+
				'<td><input type="text" name="'+count+'_marka" required></td>'+
				'<td><input type="number" name="'+count+'_nag" required></td>'+
				'<td><input type="text" name="'+count+'_particular" required></td>'+
				'<td><input type="text" name="'+count+'_weight" required></td>'+
				'<td><input type="text" name="'+count+'_freight"></td>'+
				'<td id="'+count+'_apnd"><select name="'+count+'_partyname">'+
				'<?php	
					$sql1="SELECT * FROM `party`"; 
					$result1 = $db->query($sql1) or die("Sql Error :" . $db->error); 
					echo "<option value=".null .">--select--</option>";
					while($row1 = mysqli_fetch_array($result1)){ 
					echo "<option value=\'".$row1['ID']."\'>".$row1['name']."</option>"; 
					} 
				?>'+
				'</select></td>'+
				'<td><input type="text" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{2}" placeholder="dd-mm-yy" class="dateofdeparture" id="'+count+'_dateofdeparture" name="'+count+'_dateofdeparture"></td>'+
				'</tr>';
		$('#main_table').append(html);
		if(count-1==0){
			$('#scr').append(scr);
		}
		if(new_dod == null){
			$(".add").html('Add Row');
			$('.remove').show();
			$("#upload_record_fild").html('<button class="add button button2" form="update_challan_home" id="upload_record_btn" type="submit">Upload Record</button>');
			$("#cancel_fild").html('<button class="add button button5" id="cancel_btn" type="submit">Cancel</button>');
		}
		$('#loading').hide();
		$('#upload_record').val(count);
	});
	
	$('.remove').click(function(){
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
