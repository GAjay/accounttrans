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
		while($row = mysqli_fetch_array($result)){
			echo '<tr class="j">';
				$count++;
				if(preg_match($ptrn_update,$perm)||preg_match($ptrn_paid,$perm)){
					echo '<td><input type="checkbox" name="count[]" value="'.$count.'" ></td>';
				}
				echo '
				<td><input type="" name="'.$count.'_g_r_no" value="'.$row['G.R.No'].'" '.$readonly.'></td>
				<td><input type="" name="'.$count.'_marka" value="'.$row['marka'].'" '.$readonly.'></td>
				<td><input type="" name="'.$count.'_nag" value="'.$row['nag'].'" '.$readonly.'></td>
				<td><input type="" name="'.$count.'_particular" value="'.$row['particular'].'" '.$readonly.'></td>
				<td><input type="" name="'.$count.'_weight" value="'.$row['weight'].'" '.$readonly.'></td>
				<td><input type="" name="'.$count.'_freight" value="'.$row['freight'].'" '.$readonly.'></td>
				<td><input type="" name="'.$count.'_addedby" value="'.$row['addedby'].'" readonly></td>
				<td><input type="" name="'.$count.'_dateofarrival" value="'.$row['dateofarrival'].'" '.$readonly.'></td>
				<td><input type="" name="'.$count.'_truckno" value="'.$row['truckno'].'" '.$readonly.'></td>
				<td><input type="" name="'.$count.'_drivername" value="'.$row['drivername'].'" '.$readonly.'></td>
				<td><input type="" name="'.$count.'_partyname" value="'.$row['partyname'].'" '.$readonly.'></td>
				<td><input type="" name="'.$count.'_created_at" value="'.$row['created_at'].'" readonly></td>
				<td><input type="" name="'.$count.'_updated_at" value="'.$row['updated_at'].'" readonly.></thd>
			</tr>';
		}
?>