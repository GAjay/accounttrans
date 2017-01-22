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
			<button type="submit" onclick="return paid()" class="left">Paid Entry</button><br />
			<button type="submit" onclick="return print_value()" class="left">Print</button><br />
			<button type="submit" onclick="return profile()" class="left">Profile</button><br />
			<?php
				if(preg_match($prtn_admin1,$perm)&&preg_match($prtn_admin2,$perm)){
					echo '<button type="submit" onclick="return party()" class="left">Parties Infoarmation</button><br />
						<button type="submit" onclick="return member()" class="left">Members Information</button><br />';
				}
			?>
		</div>
        <script> var user = "<?php echo $_SESSION['login_user'];?>";var perm = "<?php echo $_SESSION['permission'];?>";</script>
        <div id="main">
            <iframe id="myIframe" style="border:0px solid;" src='other/home.php?user=<?php echo $user."&perm=".$perm;?>'>Welcome</iframe>
        </div>
        <script type="text/javascript" src="js/functions.js"></script>
	</body>

</html>

