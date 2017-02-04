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
		<script> var user = "<?php echo $user;?>";var perm = "<?php echo $perm;?>";</script>
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
		<div align="center"><h1>Monthly Statements</h1></div>
		<br><br><br>
		<div>
			Select Month:<br>
			<label><input type="radio" name="month" value="1" checked> JAN</label>
			<label><input type="radio" name="month" value="2"> FEB</label>
			<label><input type="radio" name="month" value="3"> MAR</label>
			<label><input type="radio" name="month" value="4"> APR</label>
			<label><input type="radio" name="month" value="5"> MAY</label>
			<label><input type="radio" name="month" value="6"> JUN</label>
			<label><input type="radio" name="month" value="7"> JUL</label>
			<label><input type="radio" name="month" value="8"> AUG</label>
			<label><input type="radio" name="month" value="9"> SEP</label>
			<label><input type="radio" name="month" value="10"> OCT</label>
			<label><input type="radio" name="month" value="11"> NOV</label>
			<label><input type="radio" name="month" value="12"> DEC</label>
		</div><br><Br>
		<div align="center"  id="main_div">
			<table id="table">
				<thead>
				<tr>
					<th>#</th>
					<th>Paid Date</th>
					<th>Total Collection</th>
				</tr>
				</thead>
				<tbody>
				<?php
					$sql = "SELECT `paid_at`, sum(`freight`) - sum(`adjustment`) as `total amount` FROM `challan` WHERE Month(`paid_at`)=1 AND `paid`=1 AND `is_pakka`=0 group by `paid_at`";
					$result = $db->query($sql) or die('sql Error: '.$db->error);
					$count = 0;
					while($row = mysqli_fetch_array($result)){
						$count++;
						echo '<tr class="tr">
							<td>'.$count.'</td>
							<td>'.$row['paid_at'].'</td>
							<td>'.$row['total amount'].'</td>
						</tr>';
					}
				?>
				</tbody>
			</table>
		</div>
		<div align="center"><img align="center" src="../img/loading.gif" id="loading" height="90px"></div>
	</body>
</html>
<script>
$('#loading').hide();
	$('input[name=month]').click(function(){
		$('#main_div').hide();
		$('#loading').show();
		dataString = 'month='+$(this).val();
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