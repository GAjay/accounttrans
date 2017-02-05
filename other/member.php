<?php
	include('../configure/config.php');
	include('../configure/session.php');
	$user = $_SESSION['login_user'];
	$perm = $_SESSION['permission'];
	$ptrn_update = "/3/";
	$ptrn_paid = "/2/";
	$ptrn_add = "/1/";
	if(isset($_GET['add'])){
		echo '<h3 id="u">Selected member\'s information updated successfully</h3>';
	}
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
			table{
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
				echo "<script>$(document).ready(function(){
					$('#u').remove();
				});
				</script>";
				if(isset($_POST['id'])){
					$id = $_POST['id'];
					if($_POST['check']=='remove'){
						$sql = "DELETE FROM `users` WHERE `ID`='$id'";
						$result = $db->query($sql) or die('sql Error: '.$db->error);
						if($result){
							echo '<h3>Delete Selected Member</h3>';
						}
					}
					else if($_POST['check']=='update'){
						echo "<script>$(document).ready(function(){
					$('#u').remove();
					$('#n').remove();
					$('#upbtn').click(function(){
						$('#check1').val('upd');
					});
				});</script>";
						$sql = "SELECT * FROM `users` WHERE `access`!='8,9,1,2,3' AND `ID`='$id'";
						$result = $db->query($sql) or die('sql Error: '.$db->error);
						$row = mysqli_fetch_array($result);
						echo '<div style="padding:10px;">
						<form action="push/update_member.php" method="POST" onkeypress="return event.keyCode != 13;">
							<h1  align="center">Update '.$row['partyname'].'\'s Information</h1>
							<label>Name: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="name" value="'.$row["partyname"].'"></label><br><br>
							Permissions:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<label><input type="checkbox" id="1" name="permission[]" value="1"';
							$prem2=$row['access'];
							if(preg_match($ptrn_add,$prem2)){echo 'checked';}
							echo'> Add</label>
							<label><input type="checkbox" id="2" name="permission[]" value="2"';
							if(preg_match($ptrn_paid,$prem2)){echo 'checked';}
							echo'> Paid</label>
							<label><input type="checkbox" id="3" name="permission[]" value="3"';
							if(preg_match($ptrn_update,$prem2)){echo 'checked';}
							echo'> All</label>
							
							<br><br>
							<div style="border:3px solid black"><label>Connected Parties: ';
								
									$parties = explode(', ',$row['connected_parties']);
									echo '<ul>';
									if($row['connected_parties']!=''){
									foreach($parties as $i){
										echo '<li onclick="this.parentNode.removeChild(this);">
											<input type="hidden" name="ingredients[]" value="'.$i.'" />
											'.$i.'
										</li>';
									}
									}echo '</ul>';
								echo '<select onchange="selectParty(this);">';
									$sql1 = ("SELECT * FROM `party` GROUP BY `address/mobile`");
										$result1 = $db->query($sql1) or die("Sql Error :" . $db->error);
										while($row1 = mysqli_fetch_array($result1)){
											echo '<option>'.$row1['address/mobile'].'</option>';
										}
								echo '</select></label>
							</div><br><BR>
							
							<label>Add/Mobile No: <textarea name="address">'.$row["address"].'</textarea></label><br><br><br>
							<input type="hidden" value="'.$row['ID'].'" name="id"><input type="hidden" value="" id="check1" name="check1">
							<button id="upbtn" type="submit">Update</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" onclick="window.location=\'member.php\';" id="cancle1">Cancel</button>
						</form>
						</div>';
					}
				}
				else{
					echo "<h3>Please select atleast one row</h3>";
				}
			}
		?>
		<div id="n">
			<h1 align="center">Members Information</h1>
			<button class="create_members">Create Members</button><br><br><br>
		<form action="" method="POST" onkeypress="return event.keyCode != 13;">
			<table id="t01">
				<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Username</th>
					<th>Access</th>
					<th>Connected Parties</th>
					<th>Address or Mobile No</th>
				</tr>
				</thead>
				<tbody>
					<?php
						$i=1;
						$admin='8[,0-9,]*';
						$sql = "SELECT * FROM `users` WHERE NOT(`access` REGEXP '$admin')";/*!='8,9,1,2,3'";*/
						$result = $db->query($sql) or die('Sql Error: '.$db->error);
						while($row=mysqli_fetch_array($result)){
							echo '<tr id='.$i.'>
								<td><label><input type="radio" name="id" value="'.$row['ID'].'">'.$i.'</label></td>
								<td>'.$row['partyname'].'</td>
								<td>'.$row['username'].'</td>
								<td>';
								$perm1=$row['access'];
								if(preg_match($ptrn_update,$perm1)){echo 'All&nbsp;&nbsp;&nbsp;';}
								if(preg_match($ptrn_paid,$perm1)){echo 'Paid&nbsp;&nbsp;&nbsp;';}
								if(preg_match($ptrn_add,$perm1)){echo 'Add';}echo '</td><td>';
								$p_id = explode(', ',$row['connected_parties']);
								foreach($p_id as $add){
									echo $add.'<br>';
								}
								
								echo '</td>
								<td><textarea readonly>'.$row['address'].'</textarea></td>
							</tr>';
							$i++;	
						}
					?>
				</tbody>
			</table><br><br><BR>
			<button id="update">Update Member's info</button>&nbsp;&nbsp;&nbsp;&nbsp;<button id="remove">Remove Member</button>
			<input type="hidden" value="" id="check" name="check">
		</form>
		<br><Br><button class="create_members">Create Members</button>
		</div>
		
	</body>
</html>
<script>
	$('#update').click(function(){
		$('#check').val('update');
	});
	$('#remove').click(function(){
		$('#check').val('remove');
	});
	$("#3").click(function(){
		$('input:checkbox').not(this).attr('checked', this.checked);
	});
	$(".create_members").click(function(){
		window.location.href='../signup.php';
	});
</script>
<script>
	function selectParty(select)
{
  var option = select.options[select.selectedIndex];
  var ul = select.parentNode.getElementsByTagName('ul')[0];
     
  var choices = ul.getElementsByTagName('input');
  for (var i = 0; i < choices.length; i++)
    if (choices[i].value == option.value)
      return;
     
  var li = document.createElement('li');
  var input = document.createElement('input');
  var text = document.createTextNode(option.firstChild.data);
     
  input.type = 'hidden';
  input.name = 'ingredients[]';
  input.value = option.value;

  li.appendChild(input);
  li.appendChild(text);
  li.setAttribute('onclick', 'this.parentNode.removeChild(this);');     
    
  ul.appendChild(li);
}



function selectParty(select)
{
  var $ul = $(select).prev('ul');
  if ($ul.find('input[value=' + $(select).val() + ']').length == 0)
    $ul.append('<li onclick="$(this).remove();">' +
      '<input type="hidden" name="ingredients[]" value="' + 
      $(select).val() + '" /> ' +
      $(select).find('option[selected]').text() + '</li>');
}
</script>