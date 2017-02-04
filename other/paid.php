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
			<label>Party Name: <select id="party_select"><option selected>--select--</option>
			<?php
				$sql1="SELECT * FROM `party`";
				$result1 = $db->query($sql1) or die("Sql Error :" . $db->error);
				while($row1 = mysqli_fetch_array($result1)){
					echo '<option value="'.$row1['ID'].'">'.$row1['name'].'</option>';
				}
			?>
			</select></label><br><br><br>
		
		
			<div id="main_div"></div>
			<img align="center" src="../img/loading.gif" id="loading" height="90px">
		</div>
		
		
	</body>
</html>



<script>
	$('form').hide();
	$('#loading').hide();
	$('#party_select').change(function(){
		$('#loading').show();
		$('#main_div').hide();
		dataString = 'party='+$(this).val();
		$.ajax({
			type: "POST",
			url: "get/get_table_paid.php?user="+user+"&perm="+perm,
			data: dataString,
			cache: false,
			success: function(data)
				{
					
					$('#loading').hide();
					$('#main_div').show();
					$('#main_div').html(data);
				}
		});
	});
</script>