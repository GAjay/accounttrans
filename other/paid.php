<?php
	include('../configure/config.php');
	include('../configure/session.php');
	$user = $_SESSION['login_user'];
	$perm = $_SESSION['permission'];
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
		<script> var user = "<?php echo $user;?>";var perm = "<?php echo $perm;?>";</script>
		<style>
			input[type="text"],input[type="number"],input[type="date"]{
				width:130px;
			}
		</style>
	</head>
	<body style="padding:2%"><br><BR>
		<div align="center">
			<h3>Select party to show challan</h3><br>
			<label>Part Name: <select id="party_select">
				<option>--Select--</option>
			<?php
				$sql1="SELECT `name` FROM `party`";
				$result1 = $db->query($sql1) or die("Sql Error :" . $db->error);
				while($row1 = mysqli_fetch_array($result1)){
					echo '<option>'.$row1['name'].'</option>';
				}
			?>
			</select></label><br><br><br>
		
		<form action="push/paid_value.php?user=<?php echo $user;?>&perm=<?php echo $perm;?>" method="post" onkeypress="return event.keyCode != 13;">
			<button id="update" onclick="update_fn()" type="submit">Update Challan</button>   
			<button id="paid" onclick="paid_fn()" type="submit">Paid</button>
			<input type="hidden" id="upload_record" name="upload_record">
			<br><BR><br>
			<table id="main_table">
			</table>
			<script type="text/javascript" src="../js/home.js"></script>
			<input id="fn" type="hidden" name="fn">
	
		</form>
		<img align="center" src="../img/loading.gif" id="loading" height="90px">
		</div>
		
		
		</body>
</html>



<script>
	$('form').hide();
	$('#loading').hide();
	function update_fn(){
		$('#fn').val('update_record');
	};
	function paid_fn(){
		$('#fn').val('paid_record');
	};
	$('#party_select').change(function(){
		$('#loading').show();
		$('#main_table').find('tr').remove();
		dataString = 'party='+$(this).val();
		$.ajax({
			type: "POST",
			url: "get/get_table_paid.php?user="+user+"&perm="+perm,
			data: dataString,
			cache: false,
			success: function(data)
				{
					
					$('#loading').hide();
					$('#main_table').append(data);
					$('form').show();
				}
		});
	});
</script>