<?php
	include('../configure/config.php');
	include('../configure/session.php');
	$user = $_SESSION['login_user'];
	$perm = $_SESSION['permission'];
	$party=null;
	if($user!='Admin'){
		$sql = "SELECT `connected_parties` FROM `users` WHERE `partyname`='$user' AND `access`='$perm'";
		$result=$db->query($sql);
		$row=mysqli_fetch_array($result);
		$party=$row['connected_parties'];
	}
	else{
		$sql = "SELECT `ID` FROM `party`";
		$result=$db->query($sql);
		while($row=mysqli_fetch_array($result)){
			if($party==null){
				$party=$row['ID'];
			}
			else{
				$party=$party.', '.$row['ID'];
			}
		}
	}
?>
<html>
	<head>
		<link rel="stylesheet" href="../css/main.css">
		<script type="text/javascript" src="../js/jquery-1.4.1.min.js"></script>
		<script> var user = "<?php echo $user;?>";var perm = "<?php echo $perm;?>";var pakka=0;</script>
		<style>
			input[type="text"],input[type="number"],input[type="date"]{
				width:100px;
			}
			body{
				padding:2%;
			}
		</style>
	</head>
	<body><br>
		<div align="center">
			<h2>Print Challan</h2><br><br>
			<label>Please Select Party: <select id="party" class="search"><option value="">--select--</option><?php 
				$part1=explode(', ', $party);
				foreach($part1 as $id){
					$sql1="SELECT * FROM `party` WHERE `ID`='$id'";
					$result1=$db->query($sql1);
					$row1=mysqli_fetch_array($result1);
					echo '<option value="'.$row1['ID'].'">'.$row1['name'].'</option>';
				}
			?></select></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>G.R.No: <input type="number" id="grn" class="search"><br><br>
		</div><br><button id="print">Print</button><br><br><br><br>
		<div id="report">
			<label id="party_fld" style="font-size: large;"></label><br><br>
			<div id="table">
			</div>
		</div>
	</body>
</html>
<script>
	$(document).ready(function(){
		var party=''; var grn='';
		$('#party').change(function(){
			$('#party_fld').html('Party Name: <b>'+$(this).find('option[selected]').text()+'</b>');
			party=$(this).val();
		});
		$('#grn').change(function(){
			grn=$(this).val();
		});
		$('.search').change(function(){
			$('#report').hide();
			$('#table').hide();
			dataString = 'party='+party+'&grn='+grn;
			$.ajax({
				type: "POST",
				url: "get/get_print_table.php?user="+user+"&perm="+perm,
				data: dataString,
				cache: false,
				success: function(data)
					{
						$('#table').show();
						$('#table').html(data);
						$('#report').show();
					}
			});
		});
		$('#print').click(function(){
			var divContents = $("#report").html();
			var printWindow = window.open('', '', 'height=400,width=800');
			printWindow.document.write('<html><head>');
			printWindow.document.write('<style>table {width:100%;}table, th, td {border: 1px solid black;    border-collapse: collapse;}th, td {    padding: 5px;    text-align: left;}table#report_table tr:nth-child(even) {    background-color: #eee;}table#report_table tr:nth-child(odd) {    background-color:#fff;}table#report_table th {    background-color: White;    color: Black; font-width:bold;}</style>');
			printWindow.document.write('</head><body >');
			printWindow.document.write(divContents);
			printWindow.document.write('</body></html>');
			printWindow.document.close();
			printWindow.print();
		});
	});
</script>