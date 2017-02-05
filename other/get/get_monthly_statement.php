<?php
	$user = $_GET['user'];
	$perm = $_GET['perm'];
	$ptrn_update = "/3/";
	$ptrn_paid = "/2/";
	$ptrn_add = "/1/";
	$sum=0;$count = 0;$try=true;$ids='';
	include('../../configure/config.php');
	if(isset($_POST['month'])&&$_POST['connected_parties']!='undefined'){
		$month=$_POST['month'];
		echo '<table id="l" style="width:70%;">
			<thead><tr>
				<th>#</th>
				<th>Paid Date</th>
				<th>Total Collection</th>
			</tr></thead><tbody>';
		$m = explode(', ', $_POST['connected_parties']);
		foreach($m as $i){
			$sql1="SELECT `ID`,`name` FROM `party` WHERE `address/mobile`='$i'";
			$result1 = $db->query($sql1) or die('sql Error: '.$db->error);
			while($row1 = mysqli_fetch_array($result1)){
				$ids=$ids.'^'.$row1['ID'].'$|';
			}
		}
		if($ids!=''){$ids = substr($ids,0,strlen($ids)-1);}
		$sql = "SELECT *,`paid_at`, sum(`freight`) as freight, sum(`adjustment`)as adjustment FROM `challan` WHERE Month(`paid_at`)='$month' AND `is_pakka`=0 AND (`partyname` REGEXP '$ids') AND ((paid=0 AND is_roundof=1 AND is_due=0)OR(paid=1 AND is_roundof=0)OR(paid=0 AND is_due=1 AND is_roundof=0)) group by `paid_at`";
		$result = $db->query($sql) or die('sql Error: '.$db->error);
		$count_row = mysqli_num_rows($result);
		if($count_row >0){
			while($row = mysqli_fetch_array($result)){
				$count++;
				$try=false;
				$total=$row['freight']-$row['adjustment'];
				echo '<tr class="tr">
					<td>'.$count.'</td>
					<td>'.$row['paid_at'].'</td>
					<td>'.$total.'</td>
				</tr>';
				$sum = $sum + $row['freight'];
			}
		}
		echo '<label id="b">Total Amount: '.$sum.'</label><br><br></tbody></table>';
	}
	if($try){
		echo '<h2>No Statement</h2>';
	}
?>