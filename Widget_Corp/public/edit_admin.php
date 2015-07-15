<?php
	require_once("../includes/session.php");
	require_once("../includes/db_connection.php");
	require_once("../includes/functions.php");
	require_once("../includes/validation_functions.php");
	// Check for a logged in user...
	confirm_login_status();
	
	$layout_context = "admin";
	include("../includes/layouts/header.php");

	// An admin id is required in order to make a change to the database.
	//  Check to make sure the admin id exists...
	$current_admin = find_admin_by_id($_GET["id"]);	
	if (!$current_admin) {
		redirect_to("manage_admins.php");
	}

	// Begin Processing the form data (single-form submission method)
	// Check to see if the POST data was sent
	if (isset($_POST["submit"])) {
		// If POST data submitted, then process the form...
		$username = mysqli_real_escape_string($connection, $_POST["username"]);
		$password = encrypt_password($_POST["password"]);
		
		// Validate the form data...
		$required_fields = array("username", "password");
		validate_fields($required_fields);
		$fields_with_limit = array("username" => 50, "password" => 60);
		validate_lengths($fields_with_limit);
		
		// Check for errors in the validation sequence...
		//   if there are no errors, then proceed with processing, otherwise display form...
		if (empty($errors)) {
			$query = "UPDATE admins ";
			$query .= "SET username = '{$username}', hashed_password = '{$password}' ";
			$query .= "WHERE id = {$current_admin["id"]} LIMIT 1";
			$result = mysqli_query($connection, $query);
			if ($result && mysqli_affected_rows($connection) >= 0) {  //affected rows function will return a negative one value if there was an error in the query
				// On successful query, redirect back to Manage Content Page...
				$_SESSION["message"] = "Admin login updated.";
				redirect_to("manage_admins.php");
			} else {
				// On unsuccessful query, "redirect" back to the form...which is below...
				$_SESSION["message"] = "Admin login update failed";
			}
		}
		$_SESSION["errors"] = $errors;
	} // If POST data not submitted, then "redirect" to the form...which is below...
?>

	<div id="main">
		<div id="navigation">
			<a href="admin.php">&laquo; Main menu</a><br />
		</div>
		<div id="page">
			<?php message(); ?>
			<?php errors(); ?>
			<?php echo "<h2>Edit Admin: " . htmlentities($current_admin["username"]) . "</h2>"; ?>
			
			<form action="edit_admin.php?id=<?php echo urlencode($current_admin["id"]); ?>" method="post">
				<p>Username:<input type="text" name="username" value="<?php echo htmlentities($current_admin["username"]); ?>" /></p>
				<p>Password:<input type="password" name="password" value="" /></p>
				<input type="submit" name="submit" value="Edit Admin" />
			</form>
			<br />
			<a href="manage_admins.php">Cancel</a>
		</div>
	</div>
	
<?php include("../includes/layouts/footer.php"); ?>
