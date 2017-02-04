<?php
include('../../configure/config.php');
if(isset($_POST['gr_no']))
{
	$gr_no= $_POST['gr_no'];
	$sql = ("SELECT `marka` FROM `challan` WHERE `G.R.No` = '$gr_no' AND `is_pakka`=0 group by marka");
}
else{
	$sql = ("SELECT `marka` FROM `challan` WHERE `paid` = 0 group by marka");
}
	$result = $db->query($sql) or die("Sql Error :".$db->error);
	while ($row = mysqli_fetch_array($result))
	{
		?>
        	<option><?php echo $row['marka']; ?></option>
        <?php
	}
?>