<?php
	$user = $_GET['user'];
	$perm = $_GET['perm'];
	$ptrn_update = "/3/";
	$ptrn_paid = "/2/";
	$ptrn_add = "/1/";
	include('../../configure/config.php');
	$gr_no=null;$party=null;
	if(isset($_POST['gr_no'])){
		$gr_no= $_POST['gr_no'];
		$gr_no = '^'.$gr_no.'[0-9]*';
	}
	if(isset($_POST['party'])){
		$party= $_POST['party'];
		$party = '^'.$party.'[0-9]*';
	}
	
		$sql = ("SELECT *, DATE_FORMAT(`dateofdeparture`,'%d-%m-%Y') as `dateofdeparture` FROM `challan` WHERE (`G.R.No` REGEXP '$gr_no') AND (`partyname` REGEXP '$party') AND `paid`=1 AND `is_pakka`=0 ORDER BY `paid_at` DESC");

		$result = $db->query($sql) or die("Sql Error :".$db->error);
		$count = 0;
		$readonly = 'readonly';
		while($row = mysqli_fetch_array($result)){
			echo '<tr class="j">';
				$count++;
					echo '<td><lable><input type="checkbox" id="'.$count.'" name="count[]" value="'.$count.'" >
					<input type="hidden" name="'.$count.'_id_value" value="'.$row['ID'].'">'.$count.'</lable></td>
				<td>'.$row['challanNo'].'</td>
				<td>'.$row['G.R.No'].'</td>
				<td>'.$row['marka'].'</td>
				<td>'.$row['nag'].'</td>
				<td>'.$row['weight'].'</td>
				<td>'.$row['freight'].'</td>';
							$p_id = $row['partyname'];
							$party_sql = "SELECT * FROM `party` WHERE `ID`='$p_id'";
							$party_result = $db->query($party_sql) or die("Sql Error :" . $db->error);
							$party_row = mysqli_fetch_array($party_result);
							echo '<td>'.$party_row['name'].'</td>
				<td>'.$row['dateofdeparture'].'</td>
				<td>'.$row['truckno'].'</td>
			</tr>';
		}
?>
<script>
	$("#all_select").click(function(){
		$('input:checkbox').not(this).attr('checked', this.checked);
	});
</script>