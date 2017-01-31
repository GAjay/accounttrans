<?php
	$user = $_GET['user'];
	$perm = $_GET['perm'];
	$ptrn_update = "/3/";
	$ptrn_paid = "/2/";
	$ptrn_add = "/1/";
	include('../../configure/config.php');
	$party=null;$gr_no=null;$mrk=null;$frght=null;$doa=null;
	if(isset($_POST['party'])){
		$party = $_POST['party'];
		$party = '^'.$party.'[a-zA-Z0-9]*';
	}
	if(isset($_POST['gr_no'])){
		$gr_no= $_POST['gr_no'];
		$gr_no = '^'.$gr_no.'[0-9]*';
	}
	if(isset($_POST['mrk'])){
		$mrk = $_POST['mrk'];
		$mrk = '^'.$mrk.'[a-zA-Z0-9]*';
	}
	if(isset($_POST['frght'])){
		$frght = $_POST['frght'];
		$frght = '^'.$frght.'[0-9]*';
	}
	if(isset($_POST['doa'])){
		$doa = $_POST['doa'];
		$sql = ("SELECT * FROM `challan` WHERE (`G.R.No` REGEXP '$gr_no') AND (`partyname` REGEXP '$party') AND (`marka` REGEXP '$mrk') AND (`freight` REGEXP '$frght') AND `paid`=0");
	}
	else{
		$sql = ("SELECT * FROM `challan` WHERE (`G.R.No` REGEXP '$gr_no') AND (`partyname` REGEXP '$party') AND (`marka` REGEXP '$mrk') AND (`freight` REGEXP '$frght') AND `paid`=0 AND `dateofarrival`='$doa'");
	}

		$result = $db->query($sql) or die("Sql Error :".$db->error);
		$count = 0;
		$readonly = 'readonly';
		while($row = mysqli_fetch_array($result)){
			echo '<tr class="j">';
				$count++;
				if(preg_match($ptrn_update,$perm)){
					echo '<td><input type="checkbox" id="'.$count.'" name="count[]" value="'.$count.'" >
					<input type="hidden" name="'.$count.'_id_value" value="'.$row['ID'].'"></td>';
				}
				echo '
				<td>'.$row['challanNo'].'</td>
				<td>'.$row['G.R.No'].'</td>
				<td>'.$row['marka'].'</td>
				<td>'.$row['nag'].'</td>
				<td>'.$row['weight'].'</td>
				<td><input class="'.$count.'_read" type="text" name="'.$count.'_freight" value="'.$row['freight'].'" '.$readonly.'></td>
				<td><input class="'.$count.'_read" type="text" name="'.$count.'_partyname" value="'.$row['partyname'].'" '.$readonly.' list="party_list">
				<datalist id="party_list">
				<select>';
					$sql1="SELECT `name` FROM `party`";
					$result1 = $db->query($sql1) or die("Sql Error :" . $db->error);
					while($row1 = mysqli_fetch_array($result1)){
						echo '<option>'.$row1['name'].'</option>';
					}
				echo '</select>
				</datalist></td>
				<td>'.$row['dateofarrival'].'</td>
				<td>'.$row['truckno'].'</td>
			</tr>';
		}
?>
<script>
	<?php
		$j=$count;
		if(preg_match($ptrn_update,$perm)){
		while($count>0){
			echo '$("#'.$count.'").click(function(){
				if($(this).is(":checked")){
					$(".'.$count.'_read").attr("readonly",false);
				}
				else{
					$(".'.$count.'_read").attr("readonly",true);
				}
			});';
			$count--;
		}
		}
	?>
	$("#all_select").click(function(){
	$('input:checkbox').not(this).attr('checked', this.checked);
		<?php 
			if(preg_match($ptrn_update,$perm)){
			while($j>0){echo '
				if($(this).is(":checked")){
					$(".'.$j.'_read").attr("readonly",false);
				}
				else{
					$(".'.$j.'_read").attr("readonly",true);
				}';
				$j--;
			}
			}
		?>
	});
</script>