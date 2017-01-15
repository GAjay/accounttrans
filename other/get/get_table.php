<?php
	$user = $_GET['user'];
	$perm = $_GET['perm'];
	$ptrn_update = "/3/";
	$ptrn_paid = "/2/";
	$ptrn_add = "/1/";
	include('../../configure/config.php');
	
if(isset($_POST['gr_no'])&&!isset($_POST['mrk'])&&!isset($_POST['frght'])&&!isset($_POST['doa'])){
		$gr_no= $_POST['gr_no'];
		$gr_no = '^'.$gr_no.'[0-9]*';
		$sql = ("SELECT * FROM `challan` WHERE (`G.R.No` REGEXP '$gr_no') AND `paid`=0");
	}
else if(!isset($_POST['gr_no'])&&isset($_POST['mrk'])&&!isset($_POST['frght'])&&!isset($_POST['doa'])){
		$mrk = $_POST['mrk'];
		$mrk = '^'.$mrk.'[a-zA-Z0-9]*';
		$sql = ("SELECT * FROM `challan` WHERE (`marka` REGEXP '$mrk') AND `paid`=0");
	}
else if(isset($_POST['gr_no'])&&isset($_POST['mrk'])&&!isset($_POST['frght'])&&!isset($_POST['doa'])){
		$mrk = $_POST['mrk'];
		$mrk = '^'.$mrk.'[a-zA-Z0-9]*';
		$gr_no= $_POST['gr_no'];
		$gr_no = '^'.$gr_no.'[0-9]*';
		$sql = ("SELECT * FROM `challan` WHERE (`G.R.No` REGEXP '$gr_no') AND (`marka` REGEXP '$mrk') AND `paid`=0");
	}
else if(isset($_POST['gr_no'])&&!isset($_POST['mrk'])&&isset($_POST['frght'])&&!isset($_POST['doa'])){
		$frght = $_POST['frght'];
		$frght = '^'.$frght.'[0-9]*';
		$gr_no= $_POST['gr_no'];
		$gr_no = '^'.$gr_no.'[0-9]*';
		$sql = ("SELECT * FROM `challan` WHERE (`G.R.No` REGEXP '$gr_no') AND (`freight` REGEXP '$frght') AND `paid`=0");
	}
else if(!isset($_POST['gr_no'])&&isset($_POST['mrk'])&&isset($_POST['frght'])&&!isset($_POST['doa'])){
		$frght = $_POST['frght'];
		$frght = '^'.$frght.'[0-9]*';
		$mrk = $_POST['mrk'];
		$mrk = '^'.$mrk.'[a-zA-Z0-9]*';
		$sql = ("SELECT * FROM `challan` WHERE (`marka` REGEXP '$mrk') AND (`freight` REGEXP '$frght') AND `paid`=0");
	}
else if(!isset($_POST['gr_no'])&&!isset($_POST['mrk'])&&isset($_POST['frght'])&&!isset($_POST['doa'])){
		$frght = $_POST['frght'];
		$frght = '^'.$frght.'[0-9]*';
		$sql = ("SELECT * FROM `challan` WHERE (`freight` REGEXP '$frght') AND `paid`=0");
	}
else if(isset($_POST['gr_no'])&&isset($_POST['mrk'])&&isset($_POST['frght'])&&!isset($_POST['doa'])){
		$frght = $_POST['frght'];
		$frght = '^'.$frght.'[0-9]*';
		$mrk = $_POST['mrk'];
		$mrk = '^'.$mrk.'[a-zA-Z0-9]*';
		$gr_no= $_POST['gr_no'];
		$gr_no = '^'.$gr_no.'[0-9]*';
		$sql = ("SELECT * FROM `challan` WHERE (`G.R.No` REGEXP '$gr_no') AND (`marka` REGEXP '$mrk') AND (`freight` REGEXP '$frght') AND `paid`=0");
	}
else if(isset($_POST['gr_no'])&&isset($_POST['mrk'])&&isset($_POST['frght'])&&isset($_POST['doa'])){
		$doa = $_POST['doa'];
		$frght = $_POST['frght'];
		$frght = '^'.$frght.'[0-9]*';
		$mrk = $_POST['mrk'];
		$mrk = '^'.$mrk.'[a-zA-Z0-9]*';
		$gr_no= $_POST['gr_no'];
		$gr_no = '^'.$gr_no.'[0-9]*';
		$sql = ("SELECT * FROM `challan` WHERE (`G.R.No` REGEXP '$gr_no') AND (`marka` REGEXP '$mrk') AND (`freight` REGEXP '$frght') AND `paid`=0 AND `dateofarrival`='$doa'");
	}
else if(!isset($_POST['gr_no'])&&isset($_POST['mrk'])&&isset($_POST['frght'])&&isset($_POST['doa'])){
		$doa = $_POST['doa'];
		$frght = $_POST['frght'];
		$frght = '^'.$frght.'[0-9]*';
		$mrk = $_POST['mrk'];
		$mrk = '^'.$mrk.'[a-zA-Z0-9]*';
		$sql = ("SELECT * FROM `challan` WHERE (`marka` REGEXP '$mrk') AND (`freight` REGEXP '$frght') AND `paid`=0 AND `dateofarrival`='$doa'");
	}
else if(!isset($_POST['gr_no'])&&!isset($_POST['mrk'])&&isset($_POST['frght'])&&isset($_POST['doa'])){
		$doa = $_POST['doa'];
		$frght = $_POST['frght'];
		$frght = '^'.$frght.'[0-9]*';
		$sql = ("SELECT * FROM `challan` WHERE (`freight` REGEXP '$frght') AND `paid`=0 AND `dateofarrival`='$doa'");
	}
else if(!isset($_POST['gr_no'])&&isset($_POST['mrk'])&&!isset($_POST['frght'])&&isset($_POST['doa'])){
		$doa = $_POST['doa'];
		$mrk = $_POST['mrk'];
		$mrk = '^'.$mrk.'[a-zA-Z0-9]*';
		$sql = ("SELECT * FROM `challan` WHERE (`marka` REGEXP '$mrk') AND `paid`=0 AND `dateofarrival`='$doa'");
	}
else if(isset($_POST['gr_no'])&&!isset($_POST['mrk'])&&!isset($_POST['frght'])&&isset($_POST['doa'])){
		$doa = $_POST['doa'];
		$gr_no= $_POST['gr_no'];
		$gr_no = '^'.$gr_no.'[0-9]*';
		$sql = ("SELECT * FROM `challan` WHERE (`G.R.No` REGEXP '$gr_no') AND `paid`=0 AND `dateofarrival`='$doa'");
	}
else if(isset($_POST['gr_no'])&&!isset($_POST['mrk'])&&isset($_POST['frght'])&&isset($_POST['doa'])){
		$doa = $_POST['doa'];
		$frght = $_POST['frght'];
		$frght = '^'.$frght.'[0-9]*';
		$gr_no= $_POST['gr_no'];
		$gr_no = '^'.$gr_no.'[0-9]*';
		$sql = ("SELECT * FROM `challan` WHERE (`G.R.No` REGEXP '$gr_no') AND (`freight` REGEXP '$frght') AND `paid`=0 AND `dateofarrival`='$doa'");
	}
else if(!isset($_POST['gr_no'])&&!isset($_POST['mrk'])&&!isset($_POST['frght'])&&isset($_POST['doa'])){
		$doa = $_POST['doa'];
		$sql = ("SELECT * FROM `challan` WHERE `paid`=0 AND `dateofarrival`='$doa'");
	}
else if(isset($_POST['gr_no'])&&isset($_POST['mrk'])&&!isset($_POST['frght'])&&isset($_POST['doa'])){
		$doa = $_POST['doa'];
		$mrk = $_POST['mrk'];
		$mrk = '^'.$mrk.'[a-zA-Z0-9]*';
		$gr_no= $_POST['gr_no'];
		$gr_no = '^'.$gr_no.'[0-9]*';
		$sql = ("SELECT * FROM `challan` WHERE (`G.R.No` REGEXP '$gr_no') AND (`marka` REGEXP '$mrk') AND `paid`=0 AND `dateofarrival`='$doa'");
	}
else{
		$sql = ("SELECT * FROM `challan` WHERE `paid`=0");
	}
		
		$result = $db->query($sql) or die("Sql Error :".$db->error);
		$count = 0;
		$readonly = 'readonly';
		while($row = mysqli_fetch_array($result)){
			echo '<tr class="j">';
				$count++;
				if(preg_match($ptrn_update,$perm)||preg_match($ptrn_paid,$perm)){
					echo '<td><input type="checkbox" id="'.$count.'" name="count[]" value="'.$count.'" >
					<input type="hidden" name="'.$count.'_id_value" value="'.$row['ID'].'"></td>';
				}
				echo '
				<td><input class="'.$count.'_read" type="number" name="'.$count.'_g_r_no" value="'.$row['G.R.No'].'" '.$readonly.'></td>
				<td><input class="'.$count.'_read" type="text" name="'.$count.'_marka" value="'.$row['marka'].'" '.$readonly.'></td>
				<td><input class="'.$count.'_read" type="number" name="'.$count.'_nag" value="'.$row['nag'].'" '.$readonly.'></td>
				<td><input class="'.$count.'_read" type="text" name="'.$count.'_particular" value="'.$row['particular'].'" '.$readonly.'></td>
				<td><input class="'.$count.'_read" type="text" name="'.$count.'_weight" value="'.$row['weight'].'" '.$readonly.'></td>
				<td><input class="'.$count.'_read" type="text" name="'.$count.'_freight" value="'.$row['freight'].'" '.$readonly.'></td>
				<td><input type="text" name="'.$count.'_addedby" value="'.$row['addedby'].'" readonly></td>
				<td><input class="'.$count.'_read" type="" name="'.$count.'_dateofarrival" value="'.$row['dateofarrival'].'" '.$readonly.'></td>
				<td><input class="'.$count.'_read" type="text" name="'.$count.'_truckno" value="'.$row['truckno'].'" '.$readonly.'></td>
				<td><input class="'.$count.'_read" type="text" name="'.$count.'_partyname" value="'.$row['partyname'].'" '.$readonly.'></td>
			</tr>';
		}
?>
<script><?php $j=$count;
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
	?>
	$("#all_select").click(function(){
			$('input:checkbox').not(this).attr('checked', this.checked);
			<?php 
				while($j>0){echo '
					if($(this).is(":checked")){
						$(".'.$j.'_read").attr("readonly",false);
					}
					else{
						$(".'.$j.'_read").attr("readonly",true);
					}';
					$j--;
				}
			?>
		});</script>
