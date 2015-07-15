<?php
	require_once("../includes/session.php");
	require_once("../includes/db_connection.php");
	require_once("../includes/functions.php");
	require_once("../includes/validation_functions.php");

	$current_subject = find_subject_by_id($_GET["subject"], false);
	// A subject id is required in order to make a change to the database.
	//  Check to make sure a subject id exists...
	if (!$current_subject) {
		redirect_to("manage_content.php");
	}

	$pages_set = find_all_pages_for_subject($current_subject["id"]);
	if (mysqli_num_rows($pages_set) > 0) {
		$_SESSION["message"] = "Cannot delete a subject with active pages.";
		redirect_to("manage_content.php?subject={$current_subject["id"]}");
	}
	
	$query = "DELETE FROM subjects ";
	$query .= "WHERE id = {$current_subject["id"]} LIMIT 1";
	$result = mysqli_query($connection, $query);
	
	if ($result && mysqli_affected_rows($connection) == 1) {
		// On successful query, redirect back to Manage Content Page...
		$_SESSION["message"] = "Subject deleted.";
		redirect_to("manage_content.php");
	} else {
		// On unsuccessful query, redirect back to the current subject page...
		$_SESSION["message"] = "Subject delete failed";
		redirect_to("manage_content.php?subject={$current_subject["id"]}");
	}

?>
