<?php
	// Confirm Login Status
	session_start();
	if (!isset($_SESSION["user_id"])) {
		// redirect to login page...
		header("Location: login.php");
		exit;
	}
	
	// Logout Procedure...
	$_SESSION["user_id"] = null;
	$_SESSION["username"] = null;
	header("Location: login.php");
	exit;
?>