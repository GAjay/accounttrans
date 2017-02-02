<?php
	include('../../configure/config.php');
	$try=true;
	if($_POST['member']!=''&&isset($_POST['paid_at'])){
		$d = explode('-',$_POST['paid_at']);
		$j=0;$n;
		foreach($d as $p){
			$n[$j]=$p;
			$j++;
		}
		$paid_at = '20'.$n[2].'-'.$n[1].'-'.$n[0];
		$n=0;
		$member = $_POST['member'];
		$sql = "SELECT `connected_parties` FROM `users` WHERE `partyname`='$member'";
		$result = $db->query($sql) or Die('sql Error:'.$db->error);
		$row1 = mysqli_fetch_array($result);
		$parties = explode(', ',$row1['connected_parties']);
		$total_freight=0;$total_admjustment=0;$total_paid=0;?>
		<div id="table">
		<table id="b">
			<tr class="mh">
				<th>#</th>
				<th>Party Name</th>
				<th>Total Nag</th>
				<th>Total Freight</th>
				<th>Total Adjustment</th>
				<th>Total Paid</th>
			</tr>
<?php		foreach($parties as $i){
				$n++;
				$check_sql = "SELECT * FROM `challan` WHERE `partyname`='$i' AND `paid_at`='$paid_at' AND `is_pakka`=0 AND `paid`=1";
				$result_check = $db->query($check_sql) or Die('sql Error:'.$db->error);
				$count = mysqli_num_rows($result_check);
				if($count>0){
					$sql_m = "SELECT SUM(`nag`) AS `Nag`, SUM(`freight`) AS `Freight`, SUM(`adjustment`) AS `Adjustment`, `partyname` FROM `challan` WHERE `partyname`='$i' AND `paid`=1";
					$result_m = $db->query($sql_m) or Die('sql Error:'.$db->error);
					while($row = mysqli_fetch_array($result_m)){
						
						$paid = $row['Freight']-$row['Adjustment'];
						$p_sql = "SELECT * FROM `party` WHERE `ID`='$i'";
						$p_result = $db->query($p_sql) or die("Sql Error :" . $db->error);
						$p_row = mysqli_fetch_array($p_result);
						$try=false;
						echo '<tr class="j">
							<td><label><input type="radio" name="select" class="select" value="'.$row['partyname'].'">'.$n.'</label></td>
							<td>'.$p_row['name'].'</td>
							<td>'.$row['Nag'].'</td>
							<td>'.$row['Freight'].'</td>
							<td>'.$row['Adjustment'].'</td>
							<td>'.$paid.'</td>
						</tr>';
						$total_paid=$total_paid+$paid;
						$total_freight=$total_freight+$row['Freight'];
						$total_admjustment=$total_admjustment+$row['Adjustment'];
					}
				}
			}
			
		echo '<br><div align="left"><label>Total Freight: '.$total_freight.'</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>Total Adjustment: '.$total_admjustment.'</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>Total Paid: '.$total_paid.'</label></div>
		<br></table></div><br><Br>';?>
		<div id="e"></div>
		<div align="center"><img align="center" src="../img/loading.gif" id="loading1" height="90px"></div>
<?php	
	}
	if($try){
		echo '<script>$("#table").hide();</script><h2>No Payment Information</h2>';
	}
?>
<script>var check;
$(document).ready(function(){
	$('#t_a').html('');
	$('#e').hide();
	$('#loading1').hide();
	$('.select').click(function(){
		$('#loading1').show();
		$('#e').hide();
		dataString = 'partyname='+$(this).val();
		$.ajax({
			type: "POST",
			url: "get/get_party_table.php",
			data: dataString,
			cache: false,
			success: function(data)
			{
				$('#e').html(data);
				$('#loading1').hide();
				$("#e").show();
			}
		});
	});
});
</script>