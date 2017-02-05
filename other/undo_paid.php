<?php
	include('../configure/config.php');
	include('../configure/session.php');
	$user = $_SESSION['login_user'];
	$perm = $_SESSION['permission'];
	if(isset($_GET['msg'])){
		echo '<h3 style="color:Black;">'.$_GET['msg'].'</h3>';
	}
	$ptrn_update = "/3/";
	$ptrn_paid = "/2/";
	$ptrn_add = "/1/";
	$readonly = 'readonly';$result=null;
	if($_SERVER['REQUEST_METHOD']=='POST'){
			if(isset($_POST['count'])){
				foreach($_POST['count'] as $upload_record){
					$id = $_POST[$upload_record.'_id_value'];
					$is_roundof = $_POST[$upload_record.'_is_roundof'];
					$particular = $_POST[$upload_record.'_particular'];
					if($is_roundof==1){
						$roundof_amount = $_POST[$upload_record.'_freight'];
						$party_id = $_POST[$upload_record.'_partyid'];
						$particular = 'Round of Amount';
						$sql_p = "UPDATE `party` SET `round_of_amount`=`round_of_amount`+'$roundof_amount' WHERE `ID`='$party_id'";
						$result_p = $db->query($sql_p) or die("Sql Error :" . $db->error);
					}
					$updated_at = date( 'Y-m-d');
					$sql = ("UPDATE `challan` SET `particular`='$particular',`paid`='0', `adjustment`=0, `updated_at`='$updated_at', `is_full`=0, `is_due`=0 WHERE `ID`='$id'");
					$result = $db->query($sql) or die("Sql Error :" . $db->error);
				}
				if($result){
					echo '<h3>Selected Challan Undo Paid successfully</h3>';
				}
			}
			else{
				echo '<h3>Please Select atleast one row</h3>';
			}
	}
	
?>
<html>
	<head>
		<link rel="stylesheet" href="../css/main.css">
		<script type="text/javascript" src="../js/jquery-1.4.1.min.js"></script>
		<script> var user = "<?php echo $user;?>";var perm = "<?php echo $perm;?>";</script>
		
	</head>
	<body class="content">
	<h1 class="heading">Undo Paid Challan</h1>
		
		<div align="center">
		<form action="" method="post" onkeypress="return event.keyCode != 13;">
			<button class ="button button5" type="submit">Undo Paid</button>
			<input type="hidden" id="upload_record" name="upload_record">
			<div id="upload_record_fild"></div>
		<div id="same" align="lef"t"></div><script id="scr"></script>
			<table id="main_table">
				<tr class="mh">
					<th>#</th>
					<th>Challan No</th>
					<th>G.R.No</th>
					<th>Marka</th>
					<th>Nag</th>
					<th>Particular</th>
					<th>weight</th>
					<th>freight</th>
					<th>partyname</th>
					<th>dateofdeparture</th>
					<th>truckno</th>
				</tr>
				<tr class="fl">
					<th><input type="checkbox" id="all_select" ></th>
					<th></th>
					<th><input type="number" class="search" id="grn" list="grn_li"></th>
					<?php
						$sql = ("SELECT `G.R.No` FROM `challan` WHERE `paid`=1 group by `G.R.No`");
						$result = $db->query($sql) or die("Sql Error :" . $db->error);
						echo '<datalist id="grn_li"><select>';
						while($row = mysqli_fetch_array($result)){
							echo '<option>'.$row['G.R.No'].'</option>';
						}
						echo '</select></datalist>';
					?>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th><select class="search" id="party_search">
						<option value="" selected>--selecet--</option>
						<?php	$sql1="SELECT * FROM `party`";
							$result1 = $db->query($sql1) or die("Sql Error :" . $db->error);
							while($row1 = mysqli_fetch_array($result1)){
								echo '<option value="'.$row1['ID'].'">'.$row1['name'].'</option>';

							}
						?>
					</select></th>
					<th></th>
					<th></th>
				</tr>
				<?php
					$sql = ("SELECT *, DATE_FORMAT(`dateofdeparture`,'%d/%m/%Y') as `dateofdeparture` FROM `challan` WHERE `paid`=1 ORDER BY `paid_at` DESC");
					$result = $db->query($sql) or die("Sql Error :" . $db->error);
					$count = 0;
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
			</table>
			<img align="center" src="../img/loading.gif" id="loading" height="90px">
			
			<br><br><br>
	
		</form>
		</div>
		
		
	</body>
</html>



<script>
	$(document).ready(function(){
		var party=''; var grn='';
		$("#all_select").click(function(){
			$('input:checkbox').not(this).attr('checked', this.checked);
		});
	
		var dataString;	var grn = '';
		$('#loading').hide();
		$('#party_search').bind('keyup change', function(){
			party=$(this).val();
		});
		$('#grn').bind('keyup change', function(){
			grn = $(this).val();
		});
		$('.search').bind('keyup change', function(){
			$('.j').remove();
			$('#loading').show();
			dataString = 'gr_no='+grn+'&party='+party;
			$.ajax
			({
				type: "POST",
				url: "get/get_undo_paid.php?user="+user+"&perm="+perm,
				data: dataString,
				cache: false,
				success: function(data)
				{
					$('#loading').hide();
					$('#main_table').append(data);
				}
			});
		});
	});
</script>
