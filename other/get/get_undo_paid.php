<?php
	$user = $_GET['user'];
	$perm = $_GET['perm'];
	$ptrn_update = "/3/";
	$ptrn_paid = "/2/";
	$ptrn_add = "/1/";
	include('../../configure/config.php');
	$gr_no=null;$sql=null;
	if(isset($_POST['gr_no'])){
		$gr_no= $_POST['gr_no'];
		$gr_no = '^'.$gr_no.'[0-9]*';
	}
	if($_POST['party']!=''){
		$party= $_POST['party'];
		$sql = ("SELECT *, DATE_FORMAT(`dateofdeparture`,'%d-%m-%Y') as `dateofdeparture` FROM `challan` WHERE (`G.R.No` REGEXP '$gr_no') AND `partyname`='$party' AND `paid`=1 ORDER BY `paid_at` DESC");
	}
	else{
		$sql = ("SELECT *, DATE_FORMAT(`dateofdeparture`,'%d-%m-%Y') as `dateofdeparture` FROM `challan` WHERE (`G.R.No` REGEXP '$gr_no') AND `paid`=1 ORDER BY `paid_at` DESC");
	}

		$result = $db->query($sql) or die("Sql Error :".$db->error);
		$count = 0;
		$readonly = 'readonly';
		while($row = mysqli_fetch_array($result)){
			echo '<tr class="j">';
				$count++;
					echo '<td><label><input type="checkbox" id="'.$count.'" name="count[]" value="'.$count.'" >
					<input type="hidden" name="'.$count.'_id_value" value="'.$row['ID'].'"> '.$count.'</label></td>
				<td>'.$row['challanNo'].'</td>
				<td>'.$row['G.R.No'].'</td>
				<td>'.$row['marka'].'</td>
				<td>'.$row['nag'].'</td>
				<td>'.$row['particular'].'<input type="hidden" name="'.$count.'_particular" value="'.$row['particular'].'"></td>
				<td>'.$row['weight'].'</td>
				<td>'.$row['freight'].'<input type="hidden" name="'.$count.'_freight" value="'.$row['freight'].'"></td>';
				$p_id = $row['partyname'];
				$party_sql = "SELECT * FROM `party` WHERE `ID`='$p_id'";
				$party_result = $db->query($party_sql) or die("Sql Error :" . $db->error);
				$party_row = mysqli_fetch_array($party_result);
				echo '<td>'.$party_row['name'].'<input type="hidden" name="'.$count.'_partyid" value="'.$row['partyname'].'"></td>
				<td>'.$row['dateofdeparture'].'</td>
				<td>'.$row['truckno'].'</td>
				<input type="hidden" name="'.$count.'_is_roundof" value="'.$row['is_roundof'].'">
			</tr>';
		}
?>
<script>
	$("#all_select").click(function(){
		$('input:checkbox').not(this).attr('checked', this.checked);
	});
</script>