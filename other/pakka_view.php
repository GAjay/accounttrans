<?php
	include('../configure/config.php');
	include('../configure/session.php');
	$user = $_SESSION['login_user'];
	$perm = $_SESSION['permission'];
	$ptrn_update = "/3/";
	$ptrn_paid = "/2/";
	$ptrn_add = "/1/";
	$readonly=null;
	$challan_id=null;
	$show=0;
	$created_at=date('y-m-d');
	if(isset($_GET['challan_id'])){
		$challan_id=$_GET['challan_id'];
		$sql_pre="SELECT * FROM `challan` INNER JOIN `party` ON `challan`.`partyname`=`party`.`ID` AND `challan`.`ID`='$challan_id'";
		$result_pre = $db->query($sql_pre) or die('Pre Insert sql Error: '.$db->error);
		$row_pre = mysqli_fetch_array($result_pre);
		$GRNo=$row_pre['G.R.No'];
		$sender=$row_pre['name'];
		$freight=$row_pre['freight'];
		
		
		$sql_insert = "INSERT INTO `pakkachallan` (`challan_id`, `G.R.No`, `sender`, `freight`, `created_at`) SELECT '$challan_id', '$GRNo', '$sender', '$freight', '$created_at' FROM DUAL WHERE NOT EXISTS( SELECT * FROM `pakkachallan` WHERE `challan_id` = '$challan_id')";
		$result_insert=$db->query($sql_insert) or die("Sql_insert Error:".$db->error);
		
		if($_SERVER['REQUEST_METHOD']=="POST"){
			$sender=$_POST['sender'];
			$receiver=$_POST['receiver'];
			$freight=$_POST['freight'];
			$commission=$_POST['commission'];
			$labour=$_POST['labour'];
			$s_charge=$_POST['s_charge'];
			$g_tax=$_POST['g_tax'];
			$goushala=$_POST['goushala'];
			$updated_at=date('y-m-d');
			$sql_update = "UPDATE `pakkachallan` SET `G.R.No`='$GRNo', `sender`='$sender', `receiver`='$receiver', `freight`='$freight', `commission`='$commission', `labour`='$labour', `s.charge`='$s_charge', `g.tax`='$g_tax', `goushala`='$goushala', `updated_at`='$updated_at' WHERE `challan_id` = '$challan_id'";
			$result_update=$db->query($sql_update) or die("Sql_update Error:".$db->error);
			if($_POST['btn']=='conform'){
				$readonly='readonly';
				$show=1;
			}
		}
		$sql="SELECT * FROM `pakkachallan` WHERE `challan_id`='$challan_id'";
		$result = $db->query($sql) or die('sql Error: '.$db->error);
		$row = mysqli_fetch_array($result);
		
?>
<html>
	<head>
		<head>
		<link rel="stylesheet" href="../css/main.css">
		<script type="text/javascript" src="../js/jquery-1.4.1.min.js"></script>
		<script> var user = "<?php echo $user;?>";var perm = "<?php echo $perm;?>";</script>
		<style>
			body{
				padding:2%;
			}
			input[type="text"],input[type="number"],input[type="date"]{
				width:100px;
			}
		</style>
	</head>
	<head>
	<body><h2 align="center">Pakka Challan View</h2>
		<div width="50%">
			<form method="POST">
				<label>G.R.No: <?php echo $row['G.R.No'];?><input type="hidden" name="G_R_No" value="<?php echo $row['G.R.No'];?>"></label><br><br>
				<label>Sender: <input type="text" name="sender" value="<?php echo $row['sender'];?>" readonly></label><br><br>
				<label>Receiver: <input type="text" name="receiver" <?php echo $readonly;?>></label><br><br>
				<label>Freight: <?php echo $row['freight'];?><input type="hidden" name="freight" id="freight" value="<?php echo $row['freight'];?>"></label><br><br>
				<label>Commission: <input type="number" name="commission" id="commission" value="<?php echo $row['commission'];?>" <?php echo $readonly;?>></label><br><br>
				<label>Labor: <input type="number" name="labour" id="labour" value="<?php echo $row['labour'];?>" <?php echo $readonly;?>></label><br><br>
				<label>S. Charge: <input type="number" name="s_charge" id="s_charge" value="<?php echo $row['s.charge'];?>" <?php echo $readonly;?>></label><br><br>
				<label>G. Tax: <input type="number" name="g_tax" id="g_tax" value="<?php echo $row['g.tax'];?>" <?php echo $readonly;?>></label><br><br>
				<label>Cow House: <input type="number" name="goushala" id="goushala" value="<?php echo $row['goushala'];?>" <?php echo $readonly;?>></label><br><br>
				<label>Total: <input type="number" id="total" readonly></label><br><BR>
				<?php
				if(!$show){
					echo'<button id="update" >Update</button><button id="conform">Conform</button>
				<input type="hidden" id="btn" name="btn">';
				}?>
			</form>
				<?php
				if($show){
					echo'<button id="print" onclick="window.location=\'push/pakka_print.php?id='.$row['ID'].'\'">Print</button>';
				}
			?>
		</div>
	</body>
</html>
<script>
		commission = +$('#commission').val();
		labour = +$('#labour').val();
		s_charge = +$('#s_charge').val();
		g_tax = +$('#g_tax').val();
		goushala = +$('#goushala').val();
		$('#total').val(commission+labour+s_charge+g_tax+goushala);
	$('#update').click(function(){
		$('#btn').val('update');
		$("form").attr("action", "pakka_view.php?challan_id=<?php echo $challan_id?>");
	});
	$('#conform').click(function(){
		$('#btn').val('conform');
		$("form").attr("action", "pakka_view.php?challan_id=<?php echo $challan_id?>");
	});
	$('#print').click(function(){
		window.location.href="push/pakka_print.php?id=<?php echo $row['ID']?>";
	});
	$('#commission, #labour, #s_charge, #g_tax, #goushala').bind('keyup change',function(){
		commission = +$('#commission').val();
		labour = +$('#labour').val();
		s_charge = +$('#s_charge').val();
		g_tax = +$('#g_tax').val();
		goushala = +$('#goushala').val();
		$('#total').val(commission+labour+s_charge+g_tax+goushala);
	});
</script>
<?php
	}
?>