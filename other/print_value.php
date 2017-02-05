<?php
	include('../configure/config.php');
	include('../configure/session.php');
	$user = $_SESSION['login_user'];
	$perm = $_SESSION['permission'];
?>
<html>
	<head>
		<link rel="stylesheet" href="../css/main.css">
		<script type="text/javascript" src="../js/jquery-1.4.1.min.js"></script>
		<script> var user = "<?php echo $user;?>";var perm = "<?php echo $perm;?>";var pakka=0;var all=[];var allVals = []; </script>
		<style>
			input[type="text"],input[type="number"],input[type="date"]{
				width:100px;
			}
			body{
				padding:2%;
			}
		</style>
	</head>
	<body>
		<div class="content">
			<h2 class="heading">Print Challan</h2>
			<div class="center_button"><label>G.R.No: <input class="print_search"type="number" id="grn"><button class="button button5"id="search">Print challan</button></div>
			<table id="c_d">
			<thead>
				<tr class="mh">
					<th><label><input type="checkbox" id="all" value="0"> #</label></th>
					<th>Name</th>
					<th>Particular</th>
					<th>Address</th>
					<th>Due</th>
				</tr>
				<tr class="fl">
					<th></th>
					<th></th>
					<th></th>
					<th><select id="address">
						<option>--select--</option>
					<?php 
						$sql="SELECT `address/mobile` FROM `party` WHERE `type`=0 GROUP BY `address/mobile`";
						$result = $db->query($sql);
						while($row=mysqli_fetch_array($result)){
							echo '<option>'.$row['address/mobile'].'</option>';
						}
					?></select></th>
					<th></th>
				</tr>
				<script>$('#address').change(function(){
					$('.r').remove();
					dataString = 'address='+$(this).val();
					$.ajax({
						type: "POST",
						url: "get/get_address_table.php?user="+user+"&perm="+perm,
						data: dataString,
						cache: false,
						success: function(data)
							{
								$('table').append(data);
							}
					});
				});</script>
			</thead>
			<tbody>
			<?php
				$count = 0;
				$sql="SELECT * FROM `party` WHERE `type`=0";
				$result=$db->query($sql);
				while($row=mysqli_fetch_array($result)){
					$sum=0;
					$p=$row['ID'];
					$sql_due = "SELECT * FROM `challan` WHERE `partyname`='$p' AND `is_pakka`=0 AND `paid`=0 AND `is_due`=0";
					$result_due=$db->query($sql_due);
					while($row_due=mysqli_fetch_array($result_due)){
						if($row_due['is_roundof']==1){
							$sum = $sum-$row_due['freight'];
						}
						else{
							$sum = $sum+$row_due['freight'];
						}
					}
					$count++;
					echo '<tr class="r">
						<td><label><input type="checkbox" value="'.$row['ID'].'"> '.$count.'</label></td>
						<td>'.$row['name'].'</td>
						<td>'.$row['particular'].'</td>
						<td>'.$row['address/mobile'].'</td>
						<td>'.$sum.'</td>
					</tr>';
				}
			?>
			</tbody>
			</table><br><BR>
			
		</div><br><br><br><br><br>
		<div id="report" style="page-break-after:always">
			<div id="table" style="page-break-after:always">
			</div>
		</div>
	</body>
</html>
<script>
	$(document).ready(function(){
		var grn='';
		$("#all").click(function(){
			$('#c_d input:checkbox').not(this).attr('checked', this.checked);
			allVals=[];
			$('#c_d :checked').each(function() {
				allVals.push($(this).val());
			});
		});
		$('#c_d input').click(function() { 
			allVals=[];
			$('.r :checked').each(function() {
				allVals.push($(this).val());
			});
		});
		$('#grn').change(function(){
			grn=$(this).val();
		});
		
		$('#search').click(function(){
			$('#report').hide();
			$('#table').hide();
			dataString = 'party='+allVals+'&grn='+grn;
			$.ajax({
				type: "POST",
				url: "get/get_print_table.php?user="+user+"&perm="+perm,
				data: dataString,
				cache: false,
				success: function(data)
					{
						$('#table').show();
						$('#table').html(data);
						//$('#report').show();
					}
			});
		});
		/*$('#print').click(function(){
			var divContents = $("#report").html();
			var printWindow = window.open('', '', 'height=400,width=800');
			printWindow.document.write('<html><head>');
			printWindow.document.write('<style>@page {size: landscape;} @media print{ body{width:60%;}table {cell-padding:2px;width:100%;}table, th, td {border: 1px solid black;    border-collapse: collapse;}th, td {    padding: 5px;    text-align: left;}table tr:nth-child(even) {    background-color: #eee;}table tr:nth-child(odd) {    background-color:#fff;}table th {    background-color: White;    color: Black; font-width:bold;}}</style>');
			printWindow.document.write('</head><body ><h2>!! JAI BABA RAMDEV !!</h2>');
			printWindow.document.write(divContents);
			printWindow.document.write('</body></html>');
			printWindow.document.close();
			printWindow.print();
		});*/
	});
</script>
