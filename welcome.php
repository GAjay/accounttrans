<?php
	include('configure/session.php');
    $user = $_SESSION['login_user'];
	$perm = $_SESSION['permission'];
	$prtn_admin1 = "/8/";
	$prtn_admin2 = "/9/";
?>
<html>

	<head>
		<title>Welcome </title>
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<script type="text/javascript" src="js/jquery-1.4.1.min.js"></script>
	</head>

	<body>
		<div id="top" >
            <b>New India Transport Company</b>
            <a href = "configure/logout.php">
                <img id ="logout" alter="logout" src="img/logout.png">
            </a>
		</div>
		<div id="left">
			<button type="submit" onclick="window.location='welcome.php'" class="left">Data Entry</button><br />
			<button type="submit" onclick="return pakka_challan()" class="left">Pakka Challan</button><br />
			<button type="submit" onclick="return round_of()" class="left">Round of Payment</button><br />
			<?php
				if(preg_match('/2/',$perm)||preg_match('/3/',$perm)){
					echo '<button type="submit" onclick="return paid()" class="left">Paid Entry</button><br />
					<button type="submit" onclick="return undo_paid()" class="left">Undo Paid Entry</button><br />';
				}
			?>
			<?php
				if(preg_match($prtn_admin1,$perm)&&preg_match($prtn_admin2,$perm)){
					echo '<button type="submit" onclick="return monthly_statement()" class="left">Monthly Statement</button><br />
						<button type="submit" onclick="return party()" class="left">Parties Infoarmation</button><br />
						<button type="submit" onclick="return member()" class="left">Members Information</button><br />
						<button type="submit" onclick="return payment()" class="left">Payment Information</button><br />
						<button type="submit" onclick="return challan_search()" class="left">Challan Search</button><br />';
				}
			?>
			<button type="submit" onclick="return grn_search()" class="left">G.R.No Search</button><br />
			<button type="submit" onclick="return print_value()" class="left">Print</button><br />
			<button type="submit" onclick="return profile()" class="left">Profile</button><br />
		</div>
        <script> var user = "<?php echo $_SESSION['login_user'];?>";var perm = "<?php echo $_SESSION['permission'];?>";</script>
        <div id="main">
            <iframe id="myIframe" style="border:0px solid;" src='other/home.php?user'>Welcome</iframe>
        </div>
        <script type="text/javascript" src="js/functions.js"></script>
	</body>

</html>

