<?php
	$user = $_GET['user'];
	$perm = $_GET['perm'];
	$ptrn_update = "/3/";
	$ptrn_paid = "/2/";
	$ptrn_add = "/1/";
	$count = 0;
	include('../../configure/config.php');
	if(isset($_POST['party'])){
		$party = $_POST['party'];
		$sql = "SELECT * FROM `challan` WHERE `paid`='0' AND `partyname`='$party'";?>
		<tr class="mh">
			<th><input type="checkbox" id="all_select" ></th>
			<th>Challan No</th>
			<th>G.R.No</th>
			<th>Marka</th>
			<th>Nag</th>
			<th>weight</th>
			<th>freight</th>
			<th>Paid Amount</th>
			<th>Adjustment</th>
			<th>partyname</th>
			<th>dateofarrival</th>
			<th>truckno</th>
		</tr><?php
		$result = $db->query($sql) or die("Sql Error :" . $db->error);
		while($row = mysqli_fetch_array($result)){
			echo '<tr class="j">';
				$count++;
				echo '<td><input type="checkbox" id="'.$count.'" name="count[]" value="'.$count.'" >
				<input type="hidden" name="'.$count.'_id_value" value="'.$row['ID'].'"></td>
				<td>'.$row['challanNo'].'</td>
				<td>'.$row['G.R.No'].'</td>
				<td>'.$row['marka'].'</td>
				<td>'.$row['nag'].'</td>
				<td>'.$row['weight'].'</td>
				<td><input class="'.$count.'_read" type="text" id="'.$count.'_freight" name="'.$count.'_freight" value="'.$row['freight'].'" readonly></td>
				<td><input class="'.$count.'_read" type="text" id="'.$count.'_paidamount" name="'.$count.'_paidamount" value="'.$row['paidamount'].'" readonly></td>';
				$adjustment = $row['freight'] - $row['paidamount'];
				echo '<td id="'.$count.'_adjustment_td">'.$adjustment.'</td>
				<td>'.$row['partyname'].'</td>
				<td>'.$row['dateofarrival'].'</td>
				<td>'.$row['truckno'].'</td>
			</tr>';
		}
	}
	$m = $count;
?>
<script>
$(document).ready(function(){
	<?php $j=$count;
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
	<?php
		while($m>0){
			echo "
				$('#".$m."_freight,#".$m."_paidamount').bind('keyup change', function(){
					freight = $('#".$m."_freight').val();
					paidamount = $('#".$m."_paidamount').val();
					$('#".$m."_adjustment_td').html((+freight)-(+paidamount));
				});
			";
			$m--;
		}
	?>
});
</script>