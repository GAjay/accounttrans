<?php
	include('../../configure/config.php');
	$try=true;
	$total_paid=0;
	$total_freight=0;
	$total_admjustment=0;
	$ids='';
	if($_POST['connected_parties']!=''&&isset($_POST['paid_at'])){
		$d = explode('-',$_POST['paid_at']);
		$j=0;$n;
		foreach($d as $p){
			$n[$j]=$p;
			$j++;
		}
		$paid_at = '20'.$n[2].'-'.$n[1].'-'.$n[0];
		$n=0;
		echo'<div id="table">
		<div align="left"><label id="tf"></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label id="ta"></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label id="tr"></label></div><br><BR>';
		$m = explode(', ', $_POST['connected_parties']);
		foreach($m as $i){
			$sql="SELECT `ID` FROM `party` WHERE `address/mobile`='$i'";
			$result = $db->query($sql) or die('sql Error: '.$db->error);
			while($row = mysqli_fetch_array($result)){
				$ids=$ids.'^'.$row['ID'].'$|';
			}
		}
		if($ids!=''){$ids = substr($ids,0,strlen($ids)-1);}
//--------------------------------------------------------------------------------------------------------------------------------------------
		$sql_p = "SELECT `party`.`name`, SUM(`challan`.`nag`) AS `Nag`, SUM(`challan`.`freight`) AS `Freight`, SUM(`challan`.`adjustment`) AS `Adjustment`, `challan`.`partyname` AS `partyname` FROM `challan` INNER JOIN `party` ON `party`.`ID`=`challan`.`partyname` AND (`challan`.`partyname` REGEXP '$ids') AND (`challan`.`paid`=1 OR (`challan`.`paid`=0 AND `is_due`=1))AND `paid_at`='$paid_at'  AND `is_roundof`=0 GROUP BY `challan`.`partyname`";
//---------------------------------------------------------------------------------------------------------------------------------------------
		$sql_r = "SELECT `party`.`name`, SUM(`challan`.`nag`) AS `Nag`, SUM(`challan`.`freight`) AS `Freight`, SUM(`challan`.`adjustment`) AS `Adjustment`, `challan`.`partyname` AS `partyname` FROM `challan` INNER JOIN `party` ON `party`.`ID`=`challan`.`partyname` AND (`challan`.`partyname` REGEXP '$ids') AND `challan`.`paid`=0 AND `paid_at`='$paid_at'  AND `is_roundof`=1 GROUP BY `challan`.`partyname`";
//----------------------------------------------------------------------------------------------------------------------------------------------
		$result_p = $db->query($sql_p) or Die('sql Error:'.$db->error);$r_p=$result_p;$count_p=mysqli_num_rows($r_p);
		$result_r = $db->query($sql_r) or Die('sql Error:'.$db->error);$r_r=$result_r;$count_r=mysqli_num_rows($r_r);
		if($count_p>0){
			echo '
		<table id="b">
			<tr class="mh">
				<th>#</th>
				<th>Party Name</th>
				<th>Total Nag</th>
				<th>Total Freight</th>
				<th>Total Adjustment</th>
				<th>Total Paid</th>
			</tr>';
		while($row = mysqli_fetch_array($result_p)){
			$n++;
			$paid = $row['Freight']-$row['Adjustment'];
			$try=false;
			echo '<tr class="j">
				<td><label><input type="radio" name="select" class="select" value="'.$row['partyname'].'">'.$n.'</label></td>
				<td>'.$row['name'].'</td>
				<td>'.$row['Nag'].'</td>
				<td>'.$row['Freight'].'</td>
				<td>'.$row['Adjustment'].'</td>
				<td>'.$paid.'</td>
			</tr>';
			$total_paid=$total_paid+$paid;
			$total_freight=$total_freight+$row['Freight'];
			$total_admjustment=$total_admjustment+$row['Adjustment'];
		}	
		echo '</table><Br>';
		}
	if($count_r>0){
		echo '<br><h4>Round of Amount</h4>
		<table id="b">
			<tr class="mh">
				<th>#</th>
				<th>Party Name</th>
				<th>Particular</th>
				<th>Total Freight</th>
				<th>Total Adjustment</th>
				<th>Total Paid</th>
			</tr>';
				while($row1 = mysqli_fetch_array($result_r)){
			$n++;
			$paid = $row1['Freight']-$row1['Adjustment'];
			$try=false;
			echo '<tr class="j">
				<td><label>'.$n.'</label></td>
				<td>'.$row1['name'].'</td>
				<td>Round of Amount</td>
				<td>'.$row1['Freight'].'</td>
				<td>'.$row1['Adjustment'].'</td>
				<td>'.$paid.'</td>
			</tr>';
			$total_paid=$total_paid+$paid;
			$total_admjustment=$total_admjustment+$row['Adjustment'];
	}	
		echo '</table>
		<br><br><Br>';
	}
	echo '</div>';
		
		
		
		
		?>
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
	<?php
		echo"$('#tf').html('Total Freight: ".$total_freight."');
		$('#ta').html('Total Adjustment: ".$total_admjustment."');
		$('#tr').html('Total Paid: ".$total_paid."');";
	
	?>
	$('#t_a').html('');
	$('#e').hide();
	$('#loading1').hide();
	$('.select').click(function(){
		$('#loading1').show();
		$('#e').hide();
		dataString = 'partyname='+$(this).val()+'&paid_at=<?php echo $paid_at;?>';
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