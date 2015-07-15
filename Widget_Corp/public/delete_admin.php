<?php
	require_once("../includes/session.php");
	require_once("../includes/db_connection.php");
	require_once("../includes/functions.php");
	require_once("../includes/validation_functions.php");

	// An admin id is required in order to make a change to the database.
	//  Check to make sure the admin id exists...
	$current_admin = find_admin_by_id($_GET["id"]);
	if (!$current_admin) {
		redirect_to("manage_admins.php");
	}

	$query = "DELETE FROM admins ";
	$query .= "WHERE id = {$current_admin["id"]} LIMIT 1";
	$result = mysqli_query($connection, $query);
	
	if ($result && mysqli_affected_rows($connection) == 1) {
		// On successful query, redirect back to Manage Content Page...
		$_SESSION["message"] = "Admin deleted.";
		redirect_to("manage_admins.php");
	} else {
		// On unsuccessful query, redirect back to the current subject page...
		$_SESSION["message"] = "Admin delete failed";
		redirect_to("manage_admins.php");
	}

?>
