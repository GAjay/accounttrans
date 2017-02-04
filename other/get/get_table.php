<?php
	$user = $_GET['user'];
	$perm = $_GET['perm'];
	$ptrn_update = "/3/";
	$ptrn_paid = "/2/";
	$ptrn_add = "/1/";
	include('../../configure/config.php');
	$party=null;$gr_no=null;$mrk=null;$frght=null;$dod=null;
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
	if(isset($_POST['pakka'])){
		$pakka = $_POST['pakka'];
	}
	if($_POST['dod']!=''){
		$d = explode('-',$_POST['dod']);
		$i=0;$n;
		foreach($d as $p){
			$n[$i]=$p;
			$i++;
		}
		$dod  = '20'.$n[0].'-'.$n[1].'-'.$n[2];
		$dod  = Date($dod );
		$sql = ("SELECT *, DATE_FORMAT(`dateofdeparture`,'%d-%m-%Y') as `dateofdeparture` FROM `challan` WHERE (`G.R.No` REGEXP '$gr_no') AND (`partyname` REGEXP '$party') AND (`marka` REGEXP '$mrk') AND `dateofdeparture`='$dod' AND `paid`=0 AND `is_pakka`='$pakka'");
	}
	else{
		$sql = ("SELECT *, DATE_FORMAT(`dateofdeparture`,'%d-%m-%Y') as `dateofdeparture` FROM `challan` WHERE (`G.R.No` REGEXP '$gr_no') AND (`partyname` REGEXP '$party') AND (`marka` REGEXP '$mrk') AND `paid`=0 AND `is_pakka`='$pakka' ");
	}

		$result = $db->query($sql) or die("Sql Error :".$db->error);
		$count = 0;
		$readonly = 'readonly';
		while($row = mysqli_fetch_array($result)){
			echo '<tr class="j">';
				$count++;
				echo '<td><label>';
				if(preg_match($ptrn_update,$perm)){
					echo '<input type="checkbox" id="'.$count.'" name="count[]" value="'.$count.'" >
					<input type="hidden" name="'.$count.'_id_value" value="'.$row['ID'].'">';
				}
				echo $count.'</label></td>
				<td>'.$row['challanNo'].'</td>
				<td>'.$row['G.R.No'].'</td>
				<td>'.$row['marka'].'</td>
				<td>'.$row['nag'].'</td>
				<td>'.$row['weight'].'</td>
				<td>'.$row['particular'].'</td>
				<td><input class="'.$count.'_read" type="text" name="'.$count.'_freight" value="'.$row['freight'].'" '.$readonly.'></td>';
				$p_id = $row['partyname'];
				echo '<td>
					<select name="'.$count.'_partyname">';
						$sql2="SELECT * FROM `party`";
						$result2 = $db->query($sql2) or die("Sql Error :" . $db->error);
						while($row2 = mysqli_fetch_array($result2)){
							if($row2['ID']==$p_id){
								echo '<option value="'.$row2['ID'].'" selected>'.$row2['name'].'</option>';
							}
							else{
								echo '<option value="'.$row2['ID'].'">'.$row2['name'].'</option>';
							}
						}
					
					echo '</select>
				</td>
				<td>'.$row['dateofdeparture'].'</td>
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