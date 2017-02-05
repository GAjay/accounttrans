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
		<script> var user = "<?php echo $user;?>";var perm = "<?php echo $perm;?>";var $connect=[];</script>
	</head>
	<body style="padding:2%"><br>
		
		<div>
			<h1 align="center">Payment Information </h1>
			<label>Members: <select id="member">
				<option value="">--select--</option>
			<?php
				$sql = ("SELECT * FROM `users`");
				$result = $db->query($sql) or die("Sql Error :" . $db->error);
				while($row = mysqli_fetch_array($result)){
					echo '<option value="'.$row['ID'].'">'.$row['partyname'].'</option><script>$connect['.$row['ID'].']="'.$row['connected_parties'].'";</script>';
				}
			?>
			</select></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<label>Paid Date: <input type="text" id="paid_at" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{2}" placeholder="dd-mm-yy"><label>
		</div><br><Br>
		<div id="main_table" align="center">
		</div>
		<div align="center"><img align="center" src="../img/loading.gif" id="loading" height="90px"></div>
	</body>
</html>



<script>
$('#loading').hide();
$('#member, #paid_at').change(function(){
	var dataString;
	$('#loading').show();
	$('#main_table').hide();
	$id=$('#member').val();
	con=$connect[$id];console.log(con);
	if($('#paid_at').val()!=''){
		dataString = 'connected_parties='+con+'&paid_at='+$('#paid_at').val();
	}
	else{
		dataString = 'connected_parties='+con;
	}
	$.ajax({
		type: "POST",
		url: "get/get_member_table.php",
		data: dataString,
		cache: false,
		success: function(data)
		{
			$('#main_table').html(data);
			$('#loading').hide();
			$("#main_table").show();
		}
	});
});
</script>