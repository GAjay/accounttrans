<?php
	include('../configure/config.php');
	include('../configure/session.php');
	$user = $_SESSION['login_user'];
	$perm = $_SESSION['permission'];
	$ptrn_update = "/3/";
	$ptrn_paid = "/2/";
	$ptrn_add = "/1/";
?>
<html>
	<head>
		<link rel="stylesheet" href="../css/main.css">
		<script type="text/javascript" src="../js/jquery-1.4.1.min.js"></script>
		<script> var user = "<?php echo $user;?>";var perm = "<?php echo $perm;?>"; var $connect=[];</script>
		<style>
			body{
				padding:2%;
			}
			#table{
				width:70%;
			}
		</style>
	</head>
	<body><br>
		<div align="center"><h1>Monthly Statements</h1>
		<br>
			<label>Member: <select id="member">
				<option value="">--select--</option>
			<?php
				$sql = ("SELECT * FROM `users`");
				$result = $db->query($sql) or die("Sql Error :" . $db->error);
				while($row = mysqli_fetch_array($result)){
					echo '<option value="'.$row['ID'].'">'.$row['partyname'].'</option><script>$connect['.$row['ID'].']="'.$row['connected_parties'].'";</script>';
				}
			?>
			</select></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<label>Select Month: 
			<select id="month" name="month">
				<option value="1" selected>JAN</option>
				<option value="2">FEB</option>
				<option value="3">MAR</option>
				<option value="4">APR</option>
				<option value="5">MAY</option>
				<option value="6">JUN</option>
				<option value="7">JUL</option>
				<option value="8">AUG</option>
				<option value="9">SEP</option>
				<option value="10">OCT</option>
				<option value="11">NOV</option>
				<option value="12">DEC</option>
			</select>
			</label>
		</div><br><Br>
		<div align="center"  id="main_div">
			
		</div>
		<div align="center"><img align="center" src="../img/loading.gif" id="loading" height="90px"></div>
	</body>
</html>
<script>
$('#loading').hide();
	$('#month, #member').bind('keyup change', function(){
		$('#main_div').hide();
		$('#loading').show();
		$id=$('#member').val();
		con=$connect[$id];
		dataString = 'month='+$('#month').val()+'&connected_parties='+con;
		$.ajax
		({
			type: "POST",
			url: "get/get_monthly_statement.php?user="+user+"&perm="+perm,
			data: dataString,
			cache: false,
			success: function(data)
			{
				$('#loading').hide();
				$('#main_div').html(data);
				$('#main_div').show();
			}
		});
	});
</script>