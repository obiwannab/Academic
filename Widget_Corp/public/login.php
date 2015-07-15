<?php
	require_once("../includes/session.php");
	require_once("../includes/db_connection.php");
	require_once("../includes/functions.php");
	require_once("../includes/validation_functions.php");
	$layout_context = "admin";
	include("../includes/layouts/header.php");
	// Initialize variables...
	$username = "";
	
	// Begin Processing the form data (single-form submission method)
	// Check to see if the POST data was sent
	if (isset($_POST["submit"])) {
		// If POST data submitted, then process the form...

		// Validate the form data...
		// No need to validate the lengths, but really the entire validation is optional,
		//  you could just try to find blank entries in the database (which of course will return no match)
		$required_fields = array("username", "password");
		validate_fields($required_fields);
		
		// Check for errors in the validation sequence...
		//   if there are no errors, then proceed with processing, otherwise display form...
		if (empty($errors)) {
			//Attempt Login
			$username = $_POST["username"];
			$password = $_POST["password"];

			/*using a defined function to wrap up all the code for escaping the POST data and
			   querying the database and verifying the password. */
			$found_admin = attempt_login($username, $password);
			if ($found_admin) {
				// Successful Login
				// Mark user as logged in
				$_SESSION["admin_id"] = $found_admin["id"];        //Don't put important information like this
				$_SESSION["username"] = $found_admin["username"];  // in a COOKIE; those can be seen by the user
				redirect_to("admin.php");                          // and the data can be faked
			} else {
				// Failed Login
				$_SESSION["message"] = "Invalid Username/password";
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
			<h2>Admin Login</h2>
			
			<form action="login.php" method="post">
				<p>Username:<input type="text" name="username" value="<?php echo htmlentities($username); ?>" /></p>
				<p>Password:<input type="password" name="password" value="" /></p>
				<input type="submit" name="submit" value="Login" />
			</form>
		</div>
	</div>
	
<?php include("../includes/layouts/footer.php"); ?>
