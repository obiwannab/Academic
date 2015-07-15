<?php
	require_once("../includes/session.php");
	require_once("../includes/db_connection.php");
	require_once("../includes/functions.php");
	require_once("../includes/validation_functions.php");
	// Check for a logged in user...
	confirm_login_status();
	
	$layout_context = "admin";
	include("../includes/layouts/header.php");
	
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
			$query = "INSERT INTO admins (username, hashed_password) ";
			$query .= "VALUES ('{$username}', '{$password}')";
			$result = mysqli_query($connection, $query);
			if ($result) {
				// On successful query, redirect back to Manage Content Page...
				$_SESSION["message"] = "Admin login created.";
				redirect_to("manage_admins.php");
			} else {
				// On unsuccessful query, "redirect" back to the form...which is below...
				$_SESSION["message"] = "Admin creation failed";
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
			<h2>Create New Admin</h2>
			
			<form action="new_admin.php" method="post">
				<p>Username:<input type="text" name="username" value="" /></p>
				<p>Password:<input type="password" name="password" value="" /></p>
				<input type="submit" name="submit" value="Create Admin" />
			</form>
			<br />
			<a href="manage_admins.php">Cancel</a>
		</div>
	</div>
	
<?php include("../includes/layouts/footer.php"); ?>
