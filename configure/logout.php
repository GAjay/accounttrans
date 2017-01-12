<?php
session_start();
	if(session_destroy()&&isset($_GET['updated'])){
		echo '<script>window.parent.location.href = "../index.php?'.$_GET['updated'].'";</script>';
	}
	else {
		session_destroy();
		header("Location: ../index.php?logout");
	}
?>