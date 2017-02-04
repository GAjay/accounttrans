<?php
	$user = $_GET['user'];
	$perm = $_GET['perm'];
	$ptrn_update = "/3/";
	$ptrn_paid = "/2/";
	$ptrn_add = "/1/";
	$count = 0;
	include('../../configure/config.php');
	if(isset($_POST['party'])){
		$sql1="SELECT `round_of_amount` FROM `party` WHERE `ID`='".$_POST['party']."'";
		$result1 = $db->query($sql1) or die("Sql Error :" . $db->error);
		$row1 = mysqli_fetch_array($result1);
		$roundof = $row1['round_of_amount'];
		$party = $_POST['party'];
		$sql = "SELECT *, DATE_FORMAT(`dateofdeparture`,'%d-%m-%Y') as `dateofdeparture` FROM `challan` WHERE `is_pakka`=0 AND `is_full`=0 AND `partyname`='$party'";
		$result = $db->query($sql) or die("Sql Error :" . $db->error);
		$count1 = mysqli_num_rows($result);
		if($count1>0){?>
		<form action="push/paid_value.php?user=<?php echo $user;?>&perm=<?php echo $perm;?>" method="post" onkeypress="return event.keyCode != 13;"> 
			<button type="submit">Paid</button>
			<br><BR><br>
			<div align="left"> <label>Paid Date: <input type="text" name="paid_at" required="" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{2}" placeholder="dd-mm-yy"></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><select name="full"><option value="1" selected>Full Payment</option><option value="0">Net Due</option></select></label><br><br>
			<pre style="font-family:times new roman"><label>Round Of Amount: <?php echo $roundof;?><input type="hidden" id="roundof" name="roundof" value="<?php echo $roundof;?>"></label>		<label id="frght_fld">Total Freight: 0</label>		<label id="adjustment_fld">Total Adjustment: 0</label>		<label id="paid_fld">Total Paid: 0</label><input type="hidden" id="total_paid" name="total_paid" value=0></pre><input type="hidden" name="party_id" value="<?php echo $party;?>"></div><br><BR>
		<table id="main_table">
		<tr class="mh">
			<th><label><input type="checkbox" id="all_select" > #</label></th>
			<th>Challan No</th>
			<th>G.R.No</th>
			<th>Marka</th>
			<th>Nag</th>
			<th>weight</th>
			<th>freight</th>
			<th>Adjustment</th>
			<th>Paid Amount</th>
			<th>partyname</th>
			<th>dateofdeparture</th>
			<th>truckno</th>
		</tr>
		<?php
		while($row = mysqli_fetch_array($result)){
			echo '<tr class="j">';
			$count++;
				echo '<td><label><input type="checkbox" id="'.$count.'" name="count[]" value="'.$count.'" >
				<input type="hidden" name="'.$count.'_id_value" value="'.$row['ID'].'"> '.$count.'</label></td>
				<td>'.$row['challanNo'].'</td>
				<td>'.$row['G.R.No'].'</td>
				<td>'.$row['marka'].'</td>
				<td>'.$row['nag'].'</td>
				<td>'.$row['weight'].'</td>
				<td>'.$row['freight'].'<input type="hidden" id="'.$count.'_freight" value="'.$row['freight'].'"></td>
				<td><input class="'.$count.'_read" type="text" id="'.$count.'_adjustment" name="'.$count.'_adjustment" value="'.$row['adjustment'].'" readonly></td>';
				$adjustment = $row['freight'] - $row['adjustment'];
				echo '<td id="'.$count.'_adjustment_td">'.$adjustment.'</td>';
					$p_id = $row['partyname'];
					$party_sql = "SELECT * FROM `party` WHERE `ID`='$p_id'";
					$party_result = $db->query($party_sql) or die("Sql Error :" . $db->error);
					$party_row = mysqli_fetch_array($party_result);
					echo '<td>'.$party_row['name'].'</td>
				<td>'.$row['dateofdeparture'].'</td>
				<td>'.$row['truckno'].'</td>
			</tr>';
		}
		echo '</table></form>';
		}
		else{
			echo '<h2>Party Name is invalide</h2>';
		}
	}
	$m = $count;
?>
<script>
$(document).ready(function(){
	var total_frght = 0;
	var total_paid = 0;
	var total_adjustment=0;
	<?php $j=$count;
		while($count>0){
			echo "var old".$count."=0;";
			echo '$("#'.$count.'").click(function(){
				if($(this).is(":checked")){
					$(".'.$count.'_read").attr("readonly",false);
					old'.$count.'=+$("#'.$count.'_adjustment").val();
					total_adjustment = total_adjustment+(old'.$count.');
					total_frght = +$("#'.$count.'_freight").val()+total_frght;
				}
				else{
					$(".'.$count.'_read").attr("readonly",true);
					$("#all_select").attr("checked", false);
					total_frght = total_frght-(+$("#'.$count.'_freight").val());
					total_adjustment = total_adjustment-(+$("#'.$count.'_adjustment").val());
				}
				$("#frght_fld").html("Total Freight: "+total_frght);
				$("#adjustment_fld").html("Total Adjustment: "+total_adjustment);
				$("#paid_fld").html("Total Paid: "+(total_frght-total_adjustment));
				$("#total_paid").val((total_frght-total_adjustment));
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
					old'.$j.'=+$("#'.$j.'_adjustment").val();
					total_adjustment = total_adjustment+(old'.$j.');
					total_frght = +$("#'.$j.'_freight").val()+total_frght;
				}
				else{
					$(".'.$j.'_read").attr("readonly",true);
					total_frght = total_frght-(+$("#'.$j.'_freight").val());console.log( +$("#'.$j.'_freight").val());
					total_adjustment = total_adjustment-(+$("#'.$j.'_adjustment").val());
				}
				$("#frght_fld").html("Total Freight: "+total_frght);
				$("#adjustment_fld").html("Total Adjustment: "+total_adjustment);
				$("#paid_fld").html("Total Paid: "+(total_frght-total_adjustment));
				$("#total_paid").val((total_frght-total_adjustment));';

				$j--;
			}
		?>
	});
	<?php
		while($m>0){
			echo "
				$('#".$m."_adjustment').change( function(){
					freight = $('#".$m."_freight').val();
					paidamount = $('#".$m."_adjustment').val();
					$('#".$m."_adjustment_td').html((+freight)-(+paidamount));
					total_adjustment = total_adjustment-old".$m."+(+$('#".$m."_adjustment').val());
					$('#adjustment_fld').html('Total Adjustment: '+total_adjustment);
					$('#paid_fld').html('Total Paid: '+(total_frght-total_adjustment));
					old".$m." = paidamount;
					$('#total_paid').val((total_frght-total_adjustment));
				});
			";
			$m--;
		}
	?>
});
</script>