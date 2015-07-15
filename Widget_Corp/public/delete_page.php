<?php
	require_once("../includes/session.php");
	require_once("../includes/db_connection.php");
	require_once("../includes/functions.php");
	require_once("../includes/validation_functions.php");

	$current_page = find_page_by_id($_GET["page"], false);
	// A subject id is required in order to make a change to the database.
	//  Check to make sure a subject id exists...
	if (!$current_page) {
		redirect_to("manage_content.php");
	}
	
	$query = "DELETE FROM pages ";
	$query .= "WHERE id = {$current_page["id"]} LIMIT 1";
	$result = mysqli_query($connection, $query);
	
	if ($result && mysqli_affected_rows($connection) == 1) {
		// On successful query, redirect back to Manage Content Page...
		$_SESSION["message"] = "Page deleted.";
		redirect_to("manage_content.php?subject={$current_page["subject_id"]}");
	} else {
		// On unsuccessful query, redirect back to the current subject page...
		$_SESSION["message"] = "Page delete failed";
		redirect_to("manage_content.php?subject={$current_page["subject_id"]}");
	}

?>
