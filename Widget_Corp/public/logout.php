<?php
	require_once("../includes/session.php");
	require_once("../includes/functions.php");
	
	// Check for a logged in user...
	confirm_login_status();
	
	// Simple Method (which is what you'll probably use most of the time)
	// session_start();  Don't forget, you'll need to start the session before you can modify it...
	$_SESSION["admin_id"] = null;
	$_SESSION["username"] = null;
	redirect_to("login.php");
	
	
	// Heavy Handed Method
	// This method assumes that you do not need to keep ANYTHING once the user logs out
	//   completely erradicates the session
	//session_start();
	//$_SESSION = array();      // empty the entire SESSION by making it an empty array
	//if (isset($_COOKIE[session_name()])) {      // check to see if the cookie that links to the session still exists
	//	setcookie(session_name(), "", time()-42000, "/");   // and if so set the cookie to nothing, and set the expiration to a date in the past
	//}
	//session_destroy();      // This will destroy the session file on the server
	//redirect_to("login.php");

?>