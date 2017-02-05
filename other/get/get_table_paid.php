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
		$sql = "SELECT *, DATE_FORMAT(`dateofdeparture`,'%d-%m-%Y') as `dateofdeparture` FROM `challan` WHERE `paid`=0 AND `is_due`=0 AND `partyname`='$party'";
		$result = $db->query($sql) or die("Sql Error :" . $db->error);
		$count1 = mysqli_num_rows($result);
		if($count1>0){?>
		<form method="post" onkeypress="return event.keyCode != 13;"> 

			<h4 id="error">You can't paid on that date</h4>
			<div align="left">
				<label>Paid Date: 
					<input type="text" id="paid_at" name="paid_at" required="" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-[0-9]{2}" placeholder="dd-mm-yy">
				</label>
				<label>
					<select id="full" name="full">
						<option value="1" selected>Full Payment</option>
						<option value="0">Net Due</option>
					</select>
				</label><div class="button_right"><button class="button button1"type="submit" id="paid_btn">Paid</button></div>
			<div class="clearfix"/>
				<pre style="font-family:times new roman"><label id="roundof_fld">Round of Amount: 0</label>		<label id="frght_fld">Total Freight: 0</label>		<label id="adjustment_fld">Total Adjustment: 0</label>		<label id="paid_fld">Total Due/Paid: 0</label></pre>
				<input type="hidden" name="party_id" value="<?php echo $party;?>">
			</div>
			
			<input type="hidden" id="totalroundof" name="totalroundof" value=0>
			<input type="hidden" id="totalfreight" name="totalfreight" value=0>
			<input type="hidden" id="totaladjustment" name="totaladjustment" value=0>
			<input type="hidden" id="totalpaid" name="totalpaid" value=0>
			
		<table id="main_table">
		<tr class="mh">
			<th><label><input type="checkbox" id="all_select" > #</label></th>
			<th>Challan No</th>
			<th>G.R.No</th>
			<th>Marka</th>
			<th>Nag</th>
			<th>Particular</th>
			<th>weight</th>
			<th>freight</th>
			<th>Adjustment</th>
			<th>Paid Amount</th>
			<th>D.O.B</th>
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
				<td>'.$row['particular'].'</td>
				<td>'.$row['weight'].'</td>';
				
				if($row['is_roundof']==0){
					echo '<td>'.$row['freight'].'<input type="hidden" id="'.$count.'_freight" name="'.$count.'_freight" value="'.$row['freight'].'"></td>
					<input type="hidden" id="'.$count.'_roundofamount" name="'.$count.'_roundofamount" value="0">
					<td><input class="'.$count.'_read" type="text" id="'.$count.'_adjustment" name="'.$count.'_adjustment" value="'.$row['adjustment'].'" readonly></td>';
				}
				else{
					echo '<td><input type="hidden" id="'.$count.'_freight" name="'.$count.'_freight" value="0"></td>
					<input type="hidden" id="'.$count.'_roundofamount" name="'.$count.'_roundofamount" value="'.$row['freight'].'">
					<td><input type="hidden" id="'.$count.'_adjustment" name="'.$count.'_adjustment" value=0></td>';
				}
				$adjustment = $row['freight'] - $row['adjustment'];
				echo '<td id="'.$count.'_adjustment_td">'.$adjustment.'</td>
				<td>'.$row['dateofdeparture'].'</td>
				<td>'.$row['truckno'].'</td>
			</tr>';
		}
		echo '</table></form>';
		}
		else{
			echo '<h2 class="heading">No Data</h2>';
		}
	}
	$m = $count;
?>
<script>
$(document).ready(function(){
	var total_frght = 0;
	var total_paid = 0;
	var total_adjustment=0;
	var total_roundof=0;
	
	<?php $j=$count;
		while($count>0){
			echo "var old".$count."=0;";
			echo '$("#'.$count.'").click(function(){
				if($(this).is(":checked")){
					$(".'.$count.'_read").attr("readonly",false);
					old'.$count.'=+$("#'.$count.'_adjustment").val();
					total_adjustment = total_adjustment+(old'.$count.');
					total_frght = +$("#'.$count.'_freight").val()+total_frght;
					total_roundof = +$("#'.$count.'_roundofamount").val()+total_roundof;
				}
				else{
					$(".'.$count.'_read").attr("readonly",true);
					$("#all_select").attr("checked", false);
					total_frght = total_frght-(+$("#'.$count.'_freight").val());
					total_adjustment = total_adjustment-(+$("#'.$count.'_adjustment").val());
					total_roundof = total_roundof-(+$("#'.$count.'_roundofamount").val());
				}
				$("#roundof_fld").html("Round Of Amount: "+total_roundof);
				$("#frght_fld").html("Total Freight: "+total_frght);
				$("#adjustment_fld").html("Total Adjustment: "+total_adjustment);
				$("#paid_fld").html("Total Due/Paid: "+(total_frght-total_adjustment-total_roundof));
				
				$("#totalroundof").val(total_roundof);
				$("#totalfreight").val(total_frght);
				$("#totaladjustment").val(total_adjustment);
				$("#totalpaid").val((total_frght-total_adjustment-total_roundof));
				
			});			';
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
					total_roundof = +$("#'.$j.'_roundofamount").val()+total_roundof;
				}
				else{
					$(".'.$j.'_read").attr("readonly",true);
					total_frght = total_frght-(+$("#'.$j.'_freight").val());
					total_adjustment = total_adjustment-(+$("#'.$j.'_adjustment").val());
					total_roundof = total_roundof-(+$("#'.$j.'_roundofamount").val());
				}';

				$j--;
			}
		?>
		$("#roundof_fld").html("Round Of Amount: "+total_roundof);
		$("#frght_fld").html("Total Freight: "+total_frght);
		$("#adjustment_fld").html("Total Adjustment: "+total_adjustment);
		$("#paid_fld").html("Total Due/Paid: "+(total_frght-total_adjustment-total_roundof));
		
		$("#totalroundof").val(total_roundof);
		$("#totalfreight").val(total_frght);
		$("#totaladjustment").val(total_adjustment);
		$("#totalpaid").val((total_frght-total_adjustment-total_roundof));
		
	});
	<?php
		while($m>0){
			echo "
				$('#".$m."_adjustment').change( function(){
					freight = $('#".$m."_freight').val();
					paidamount = $('#".$m."_adjustment').val();
					$('#".$m."_adjustment_td').html((+freight)-(+paidamount));
					total_adjustment = total_adjustment-old".$m."+(+$('#".$m."_adjustment').val());
					old".$m." = paidamount;";
				echo'
					$("#roundof_fld").html("Round Of Amount: "+total_roundof);
					$("#frght_fld").html("Total Freight: "+total_frght);
					$("#adjustment_fld").html("Total Adjustment: "+total_adjustment);
					$("#paid_fld").html("Total Due/Paid: "+(total_frght-total_adjustment-total_roundof));
					
					$("#totalroundof").val(total_roundof);
					$("#totalfreight").val(total_frght);
					$("#totaladjustment").val(total_adjustment);
					$("#totalpaid").val((total_frght-total_adjustment-total_roundof));
					if((total_frght-total_adjustment-total_roundof)>0){
						$("#full option[value=0]").attr("selected","selected");
					}
					else{
						$("#full option[value=1]").attr("selected","selected");
					}		
				});
			';
			$m--;
		}
	?>
});$('#error').hide();
	$('#paid_at').change(function(){
		paid_at = new Date("20"+$(this).val().substring(6,8)+"-"+$(this).val().substring(3,5)+"-"+$(this).val().substring(0,2));
		if(+paid_at<+last_paid_date){
			$('button').hide();$('#error').show();
		}
		else{
			$('button').show();$('#error').hide();
		}
	});
	$('#paid_btn').click(function(){
		$t_a = +$('#totaladjustment').val();
		$t_f = +$('#totalfreight').val();
		$t_r = +$('#totalroundof').val();
		if($t_f-$t_a-$t_r<0){
			var ask = window.confirm("These Selected challan has nagative paid value. So these goes into draft");
			if (ask) {
				$("form").attr("action", "push/paid_value.php");
			}
		}
		else{
				$("form").attr("action", "push/paid_value.php");
			}
	});
</script>
