<?php
	include('../configure/config.php');
	include('../configure/session.php');
	$user = $_SESSION['login_user'];
	$perm = $_SESSION['permission'];
	$last_paid_date = $_SESSION['last_paid_date'];
	$member_id = $_SESSION['ID'];
	$ptrn_update = "/3/";
	$ptrn_paid = "/2/";
	$ptrn_add = "/1/";
	$readonly = 'readonly';
	if($_SERVER['REQUEST_METHOD']=="POST"){
		$id = $_POST['party'];
		$d = explode('-',$_POST['paid_at']);
		$i=0;$n;
		foreach($d as $p){
			$n[$i]=$p;
			$i++;
		}
		$paid_at = '20'.$n[2].'-'.$n[1].'-'.$n[0];
		$paid_at = Date($paid_at);
		$amount = $_POST['amount'];
		$particular = 'Round of Amount';
		$total_amount = $_POST['total_amount'];
		$created_at = date( 'Y-m-d');
		$updated_at = date( 'Y-m-d');
		$sql_type = "SELECT `type` FROM `party` WHERE `ID`='$id'";
		$result_type=$db->query($sql_type);
		$row=mysqli_fetch_array($result_type);
		$type=$row['type'];
		$sql1 = "INSERT INTO `challan`(`challanNo`, `particular`, `freight`, `paid_at`,`dateofdeparture`, `addedby`, `partyname`, `created_at`, `updated_at`, `is_roundof`, `is_pakka`) VALUES (0, '$particular', '$amount', '$paid_at', '$paid_at', '$member_id', '$id', '$created_at', '$updated_at', '1', '$type')";
		$sql2 = "UPDATE `party` SET `round_of_amount`='$total_amount' WHERE `ID`='$id'";
		$result1=$db->query($sql1);$result2=$db->query($sql2);
		echo '<h2>Selected row updated successfully</h2>';
	}
?>
<html>
	<head>
		<link rel="stylesheet" href="../css/main.css">
		<script type="text/javascript" src="../js/jquery-1.4.1.min.js"></script>
		<script> var user = "<?php echo $user;?>";var perm = "<?php echo $perm;?>";var $round_of = []; var last_paid_date = new Date("<?php echo $last_paid_date;?>");</script>
		
	</head>
	<body>
		<h2 class="heading">Roundof Payment</h2>
	<div class="content">
			<form action="" method="POST" onkeypress="return event.keyCode != 13;">
			<label>Party Name: <select name="party" id="party">
				<option value="">--select--</option>
				<?php
					$sql="SELECT * FROM `party`";
					$result=$db->query($sql);
					while($row=mysqli_fetch_array($result)){
						echo '<option value="'.$row['ID'].'">'.$row['name'].'</option><script>$round_of['.$row['ID'].']='.$row['round_of_amount'].';</script>';
					}
				?>
			</select></label>
			<label>Paid Date: <input type="text" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{2}" placeholder="dd-mm-yy" id="paid_at" name="paid_at" required></label>
			<label>In Account: <input type="text" id="in_acc" name="in_acc" value=0 readonly></label>
			<label>Paid Amount: <input type="text" id="amount" name="amount" value=0 required></label>
			<label>Total Amount: <input type="text" id="total_amount" name="total_amount" readonly></label>
			
			<div class="center_button"><button class="button button2"type="submit">Update Roundof Payment</button></div>
			<h4 id="error">You can't paid on that date</h4>
			</form>
			
		</div>
	</body>
</html>
<script>$('#error').hide();
	$('#party').change(function(){
		party_id = $(this).val();
		in_acc_amount = +$round_of[party_id];
		$('#in_acc').val(in_acc_amount);
		total = in_acc_amount+(+$('#amount').val());
		$('#total_amount').val(total);
	});
	$('#amount').bind('keyup change',function(){
		in_acc = +$('#in_acc').val();
		amount = +$('#amount').val();
		$('#total_amount').val(in_acc+amount);
	});
	$('#paid_at').change(function(){
		var paid_at;
		if($(this).val()!=''){
			paid_at = new Date("20"+$(this).val().substring(6,8)+"-"+$(this).val().substring(3,5)+"-"+$(this).val().substring(0,2));
		}
		else{
			paid_at = '';
		}
		if(+paid_at<+last_paid_date){
			$('button').hide();$('#error').show();
		}
		else{
			$('button').show();$('#error').hide();
		}
	});
</script>
