<?php
	require_once("../includes/session.php");
	//session_start();  // Begin a session to store message strings to display after the redirect...
	/* You must start a session at the very beginning of the PHP code...this function will either:
		physically start a new session (file) if there wasn't one already and set a cookie, or 
		opens the old session file that is already being used (currently) and stores the data.  */
	require_once("../includes/db_connection.php");
	require_once("../includes/functions.php");
	require_once("../includes/validation_functions.php");

	// Check to see if the POST data was sent
	if (isset($_POST["submit"])) {
		// If POST data submitted, then process the form...
		$menu_name = mysqli_real_escape_string($connection, $_POST["menu_name"]);
		$position = (int) $_POST["position"];
		$visible = (int) $_POST["visible"];
		
		// Validate the form data...
		$required_fields = array("menu_name", "position", "visible");
		validate_fields($required_fields);
		$fields_with_limit = array("menu_name" => 30);
		validate_lengths($fields_with_limit);
		
		// Check for errors in the validation sequence...
		if (!empty($errors)) {
			$_SESSION["errors"] = $errors;
			redirect_to("new_subject.php");  // the redirect_to function has an exit command which will
		}									 //  keep the rest of this code from executing...
		
		$query = "INSERT INTO subjects (menu_name, position, visible) ";
		$query .= "VALUES ('{$menu_name}', {$position}, {$visible})";
		$result = mysqli_query($connection, $query);
		if ($result) {
			// On successful query, redirect back to Manage Content Page...
			$_SESSION["message"] = "Subject created.";
			redirect_to("manage_content.php");
			/* Whenever a redirect is executed, it begins a new Request-Response Cycle between the client 
				and server.  Therefore, in order to pass information (like this message string) back to 
				the client computer, we need to utilize a session, to store the message and retrieve the
				message (or whatever other data we need) when the redirect is finished and the destination
				HTML is being rendered.  */
		} else {
			// On unsuccessful query, redirect back to the form...
			$_SESSION["message"] = "Subject creation failed";
			redirect_to("new_subject.php");
		}
	} else {
		// If POST data not submitted, then redirect back to the form...
		redirect_to("new_subject.php");
	}
	
	if (isset($connection)) { mysqli_close($connection); }
?>
