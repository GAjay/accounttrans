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
		<h2 align="center">Search With G.R.No</h2>
		<label >G.R. No. <input type="text" id="grn" list="grn_list"><datalist id="grn_list"><select>
		<?php
					$sql = "SELECT `G.R.No` FROM `challan` GROUP BY `G.R.No`";
					$result = $db->query($sql) or die('Sql Error: '.$db->error);
					$i=1;
					while($row = mysqli_fetch_array($result)){
						echo '<option>'.$row['G.R.No'].'</option>';
					}
				?>
		</select></datalist></label>
	</div><br><br>
	<div id="result"></div>
	<div align="center"><img align="center" src="../img/loading.gif" id="loading" height="90px"></div>
	</body>
</html>
<script>
$('#result').hide();
$('#loading').hide();
$('#grn').bind('keyup change',function(){
	$('#result').hide();
	$('#loading').show();
	dataString = 'grn='+$(this).val();
	$.ajax({
		type: "POST",
		url: "get/grn_search_value.php",
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