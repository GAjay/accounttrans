<?php
	include('../configure/config.php');
	include('../configure/session.php');
	$user = $_SESSION['login_user'];
	$perm = $_SESSION['permission'];
	$ptrn_update = "/3/";
	$ptrn_paid = "/2/";
	$ptrn_add = "/1/";
	$readonly = 'readonly';
	$party=null;
	if($user!='Admin'){
		$sql = "SELECT `connected_parties` FROM `users` WHERE `partyname`='$user' AND `access`='$perm'";
		$result=$db->query($sql);
		$row=mysqli_fetch_array($result);
		$party=$row['connected_parties'];
	}
	else{
		$sql = "SELECT `ID` FROM `party`";
		$result=$db->query($sql);
		while($row=mysqli_fetch_array($result)){
			if($party==null){
				$party=$row['ID'];
			}
			else{
				$party=$party.', '.$row['ID'];
			}
		}
	}
	if($_SERVER['REQUEST_METHOD']=="POST"){
		if(isset($_POST['count'])){
		foreach($_POST['count'] as $u){
			$id = $_POST[$u.'_id_value'];
			$d = explode('-',$_POST[$u.'_paid_at']);
			$i=0;$n;
			foreach($d as $p){
				$n[$i]=$p;
				$i++;
			}
			$paid_at = '20'.$n[2].'-'.$n[1].'-'.$n[0];
			$paid_at = Date($paid_at);
			$amount = $_POST[$u.'_amount'];
			$particular = $_POST[$u.'_particular'];
			$total_amount = $_POST[$u.'_total_amount'];
			$sql1 = "INSERT INTO `round_of`(`party_id`, `paid_at`, `amount`, `particular`) VALUES ('$id', '$paid_at', '$amount', '$particular')";
			$sql2 = "UPDATE `party` SET `round_of_amount`='$total_amount' WHERE `ID`='$id'";
			$result1=$db->query($sql1);$result2=$db->query($sql2);
		}
			echo '<h2>Selected row updated successfully</h2>';
		}
		else{
			echo '<h2>Please select atleast one row</h2>';
		}
	}
?>
<html>
	<head>
		<link rel="stylesheet" href="../css/main.css">
		<script type="text/javascript" src="../js/jquery-1.4.1.min.js"></script>
		<script> var user = "<?php echo $user;?>";var perm = "<?php echo $perm;?>";var pakka=1;</script>
		<style>
			table{
				width:90%;
			}
			body{
				padding:2%;
			}
			input[type="text"],input[type="number"],input[type="date"]{
				width:130px;
			}
		</style>
	</head>
	<body>
		<h2 align="center">Roundof Payment</h2>
		<div id="amount" align="center">
			<form action="" method="POST" onkeypress="return event.keyCode != 13;">
			<table>
			<thead>
			<tr>
				<th><label><input type="checkbox" id="all_select" > #</label></th>
				<th>Party Name</th>
				<th>Paid Date</th>
				<th>In Account</th>
				<th>Paid Amount</th>
				<th>Total Amount</th>
				<th>Particular</th>
			</tr>
			</thead>
			<tbody>
			<?php
				$count=0;
				$part=explode(', ', $party);
				foreach($part as $id){
					$count++;
					$sql="SELECT * FROM `party` WHERE `ID`='$id'";
					$result=$db->query($sql);
					$row=mysqli_fetch_array($result);
					echo '<tr>
						<td><label><input type="checkbox" id="'.$count.'" name="count[]" value="'.$count.'" >
							<input type="hidden" name="'.$count.'_id_value" value="'.$row['ID'].'"> '.$count.'</label>
						</td>
						<td>'.$row['name'].'</td>
						<td><input type="text" class="'.$count.'_read" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{2}" placeholder="dd-mm-yy" name="'.$count.'_paid_at" readonly></td>
						<td>'.$row['round_of_amount'].'<input type="hidden" id="'.$count.'_in_acc" name="'.$count.'_in_acc" value="'.$row['round_of_amount'].'"></td>
						<td><input type="text" class="'.$count.'_read" id="'.$count.'_amount" name="'.$count.'_amount" value="0" readonly></td>
						<td><label id="'.$count.'_total">'.$row['round_of_amount'].'</label><input type="hidden" id="'.$count.'_total_amount" name="'.$count.'_total_amount" value="'.$row['round_of_amount'].'"></td>
						<td><input type="text" class="'.$count.'_read" name="'.$count.'_particular" readonly></td>
					</tr>';
				}
			?>
			</tbody>
			</table><br><br><br>
			<button type="submit">Update</button>
			</form>
			<br><br><button id="payment_info">Round of Payment Info</button>
		</div>
		<div id="info" align="center">
			<label>Please Select Party: <select id="party"><option value="">--select--</option><?php 
				$part1=explode(', ', $party);
				foreach($part1 as $id){
					$sql1="SELECT * FROM `party` WHERE `ID`='$id'";
					$result1=$db->query($sql1);
					$row1=mysqli_fetch_array($result1);
					echo '<option value="'.$row1['ID'].'">'.$row1['name'].'</option>';
				}
			?></select></label><br><br>
			
			<?php 
				$part1=explode(', ', $party);
				foreach($part1 as $id){
					echo '<table class="table" id="_'.$id.'">
					<thead>
					<tr>
						<th>#</th>
						<th>Party Name</th>
						<th>Paid at</th>
						<th>Payment</th>
						<th>Particular</th>
					</tr>
					</thead>
					<tbody>';
						$sql = "SELECT party.name, round_of.* FROM `round_of` INNER JOIN `party` ON party.ID=round_of.party_id AND party.ID='$id'";
						$result = $db->query($sql);
						$k=0;
						while($row=mysqli_fetch_array($result)){
							$k++;
							echo '<tr>
								<td>'.$k.'</td>
								<td>'.$row['name'].'</td>
								<td>'.$row['paid_at'].'</td>
								<td>'.$row['amount'].'</td>
								<td>'.$row['particular'].'</td>
							</tr>';
						}
					echo '</tbody>
					</table>';
				}
			?>
			<br><br><button id="back">Back</button>
		</div>
	</body>
</html>
<script>
	$('.table').hide();$('#info').hide();
	$('#payment_info').click(function(){
		$('#info').show();
		$('#amount').hide();
	});
	$('#back').click(function(){
		$('#info').hide();
		$('#amount').show();
	});
	$('#party').change(function(){
		party_id = $(this).val();
		$('.table').hide();
		$('#_'+party_id).show();
	});
	<?php $j=$count;
		$m=$count;
		while($count>0){
			echo '$("#'.$count.'").click(function(){
				if($(this).is(":checked")){
					$(".'.$count.'_read").attr("readonly",false);
					$(".'.$count.'_read").attr("required",true);
				}
				else{
					$(".'.$count.'_read").attr("readonly",true);
					$(".'.$count.'_read").attr("required",false);
				}
			});';
			$count--;
		}
	?>
	$("#all_select").click(function(){
		$('input:checkbox').not(this).attr('checked', this.checked);
		<?php
			while($j>0){echo '
				if($(this).is(":checked")){
					$(".'.$j.'_read").attr("readonly",false);
					$(".'.$j.'_read").attr("required",true);
				}
				else{
					$(".'.$j.'_read").attr("readonly",true);
					$(".'.$j.'_read").attr("required",false);
				}';
				$j--;
			}
		?>
	});
	<?php
		while($m>0){
			echo"
			$('#".$m."_amount').bind('keyup change',function(){
				in_acc = +($('#".$m."_in_acc').val());
				paid = +($(this).val());
				$('#".$m."_total').html(in_acc+paid);
				$('#".$m."_total_amount').val(in_acc+paid);
			});
			";
			$m--;
		}
	?>
</script>