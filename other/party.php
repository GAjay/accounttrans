<?php
	include('../configure/config.php');
	include('../configure/session.php');
	$user = $_SESSION['login_user'];
	$perm = $_SESSION['permission'];
?>
<html>
	<head>
		<link rel="stylesheet" href="../css/main.css">
		<script type="text/javascript" src="../js/jquery-1.4.1.min.js"></script>
		<script> var user = "<?php echo $user;?>";var perm = "<?php echo $perm;?>";var name1=[];</script>
		<style>
			input[type="text"],input[type="number"],input[type="date"]{
				width:130px;
			}
			#t01{
				width:70%;
			}
			body{
				padding:2%;
			}
		</style>
	</head>
	<body>
		<?php
			if($_SERVER['REQUEST_METHOD']=="POST"){
				if(isset($_POST['id'])){
					$id = $_POST['id'];
					if($_POST['check']=='remove'){
						$sql = "DELETE FROM `party` WHERE `ID`='$id'";
						$result = $db->query($sql) or die('sql Error: '.$db->error);
						if($result){
							echo '<h3>Delete Selected party</h3>';
						}
					}
					else if($_POST['check']=='update'){
						echo "<script>$(document).ready(function(){
							$('#n').remove();
							$('#upbtn').click(function(){
								$('#check1').val('upd');
							});
						});
						</script>";
						$sql = "SELECT * FROM `party` WHERE `ID`='$id'";
						$result = $db->query($sql) or die('sql Error: '.$db->error);
						$row = mysqli_fetch_array($result);
						echo '<div style="padding:10px;"><br><Br>
						<form action="push/update_party.php" method="POST" onkeypress="return event.keyCode != 13;">
							<h1  align="center">Update '.$row['name'].'\'s Information</h1>
							<label>Party Type: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="type">';
							if($row["type"]==0){
								echo '<option value=0 selected>Kachcha</option><option vlaue=1>Pakka</option>';
							}
							else{
								echo '<option value=0>Kachcha</option><option vlaue=1 selected>Pakka</option>';
							}
							echo '</select> </label><br><br>
							<label>Party Name: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="name" name="name" value="'.$row["name"].'" list="party_name_list" required></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<h3 id="error">Please use other name</h3><br><br>
							<label>Particular: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="particular" value="'.$row["particular"].'"></label><br><br>
							<label>Add/Mobile No: <input type="text" name="address/mobile" list="address" value="'.$row["address/mobile"].'" required></label><br><br><br>
							<input type="hidden" value="'.$row['ID'].'" name="id"><input type="hidden" value="" id="check1" name="check1">
							<button id="upbtn" type="submit">Update</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" on click="window.location=\'party.php\';" id="cancle1">Cancel</button>
						</form>
						</div>';
					}
				}
				else{
					echo "<h3>Please select atleast one row</h3>";
				}
			}
		?>
		<div id="n" align="center">
			<h1>Parties Information</h2>
		<button id="add_party">Add Party</button><br><br><br>
		<form action="" method="POST" onkeypress="return event.keyCode != 13;">
		<button class="update">Update Party info</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="remove">Remove Party</button><br><br><BR>
			<table id="t01">
				<thead>
				<tr>
					<th>#</th>
					<th>Party Name</th>
					<th>Particular</th>
					<th>Address or Mobile No</th>
					<th>Type</th>
				</tr>
				</thead>
				<tbody>
					<?php
						$i=1;
						$sql = "SELECT * FROM `party` WHERE `ID`!=1";
						$result = $db->query($sql) or die('Sql Error: '.$db->error);
						while($row=mysqli_fetch_array($result)){
							echo '<tr id='.$i.'>
								<td><label><input type="radio" name="id" value="'.$row['ID'].'"> '.$i.'</label></td>
								<td>'.$row['name'].'<script>name1.push("'.$row['name'].'");</script></td>
								<td>'.$row['particular'].'</td>
								<td>'.$row['address/mobile'].'</td>
								<td>';
								if($row['type']==0){
									echo 'Kachcha Type';
								}
								else{
									echo 'Pakka Type';
								}
							echo '</td>
							</tr>';
							$i++;	
						}
					?>
				</tbody>
			</table><br><br><BR>
			<button class="update">Update Party info</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<button class="remove">Remove Party</button>
			<input type="hidden" value="" id="check" name="check">
		</form>
		</div>
		<div id="add_div">
		<button class="add" type="submit">Add Row</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="remove_row">Remove Row</button>
		<br><br><div align="center">
			<button  form="party_add" id="party_btn" type="submit">Upload Record</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<button type="submit" onclick="window.location='party.php';">Cancel</button>
		</div><br><br>
		<form  id="party_add" action="push/update_party.php" method="POST" onkeypress="return event.keyCode != 13;">
			<table id="m">
			<thead>
			<tr>
				<th>Sr No</th>
				<th>Party Name</th>
				<th>Particular</th>
				<th>Address or Mobile No</th>
				<th>Type</th>
			</tr>
			</thead>
			<tbody>
			<tr id='1'>
				<td>1</td>
				<td><input type="text" name="1_name" list="party_name_list" required></td>
				<td><input type="text" name="1_particular"></td>
				<td><input type="text" name="1_address/mobile" list="address" required></td>
				<td><input type="checkbox" name="1_type"></td>
			</tr>
			</tbody>
			</table><br><br>
			<input type="hidden" id="chk" name="check1">
			<input type="hidden" id="upload_record" name="upload_record" value="1">
		</form><br><br><br>
		<button class="add" type="submit">Add Row</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="remove_row">Remove Row</button>
		<br><br><br>
		</div>		
	</body>
	<datalist id="party_name_list">
		<select>
			<?php
				$sql = "SELECT `name` FROM `party`";
				$result_p = $db->query($sql) or die('sql Error: '.$db->error);
				while($row_p=mysqli_fetch_array($result_p)){
					echo '<option>'.$row_p['name'].'<option>';
				}
			?>
		</select>
	</datalist>
	<datalist id="address">
		<select>
			<?php
				$sql = "SELECT `address/mobile` FROM `party` GROUP BY `address/mobile`";
				$result_p = $db->query($sql) or die('sql Error: '.$db->error);
				while($row_p=mysqli_fetch_array($result_p)){
					echo '<option>'.$row_p['address/mobile'].'<option>';
				}
			?>
		</select>
	</datalist>
</html>
<script>
	var count=1;
	$('#error').hide();
	$('#name').change(function(){
		if(name1.includes($(this).val())){
			$('#error').show();
			$('#upbtn').hide();
		}
		else{
			$('#error').hide();
			$('#upbtn').show();
		}
	});
	$('#add_div').hide();
	$('.update').click(function(){
		$('#check').val('update');
	});
	$('.remove').click(function(){
		$('#check').val('remove');
	});
	$('#add_party').click(function(){
		$('#n').remove();
		$('#add_div').show();
	});
	$('.add').click(function(){
		count++;
		html = '<tr id="'+count+'">'+
			'<td>'+count+'</td>'+
			'<td><input type="text" name="'+count+'_name" list="party_name_list" required></td>'+
			'<td><input type="text" name="'+count+'_particular"></td>'+
			'<td><input type="text" name="'+count+'_address/mobile" list="address" required></td>'+
			'<td><input type="checkbox" name="'+count+'_type"></td>'+
		'</tr>';
		$('#m').append(html);
		$('#upload_record').val(count);
	});
	$('.remove_row').click(function(){
		$('#'+count).remove();
		count--;
		$('#upload_record').val(count);
	});
	$('#party_btn').click(function(){
		$('#chk').val('upload_record');
	});
</script>
