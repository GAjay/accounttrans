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
		<script> var user = "<?php echo $user;?>";var perm = "<?php echo $perm;?>";</script>
	</head>
	<body style="padding:2%">
	<div >
		<h2 align="center">Search with Challan No.</h2>
		<pre style="font-family:times new roman">
		<label >Challan No. <input type="text" id="challanNo" list="ch"><datalist id="ch"><select>
		<?php
					$sql = "SELECT `challanNo` FROM `challan` WHERE `is_pakka`=0 GROUP BY `challanNo`";
					$result = $db->query($sql) or die('Sql Error: '.$db->error);
					$i=1;
					while($row = mysqli_fetch_array($result)){
						echo '<option>'.$row['challanNo'].'</option>';
					}
				?>
		</select></datalist></label>
	</div><br><br>
	<div id="result"></div>
	<div align="center"><img align="center" src="../img/loading.gif" id="loading" height="90px"></div>
	</body>
</html>
<script>
$('#grn_fld').hide();
$('#result').hide();
$('#loading').hide();
$('#challanNo').bind('keyup change',function(){
	$('#result').hide();
	$('#loading').show();
	dataString = 'challanNo='+$('#challanNo').val();
	$.ajax({
		type: "POST",
		url: "get/challan_search_value.php",
		data: dataString,
		cache: false,
		success: function(data)
		{
			$('#loading').hide();
			console.log(data);
			$('#result').html(data);
			$('#result').show();
		}
	});
});
</script>