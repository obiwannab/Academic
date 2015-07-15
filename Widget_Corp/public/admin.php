<?php
	require_once("../includes/session.php");
	require_once("../includes/functions.php");

	// Check for a logged in user...
	/* Here is also where we should perform additional security checks if needed, such as
		maybe certain users are only allowed to log in or be logged in up to a certain date or time,
		or maybe we need to validate the id every time the user navigates to provide additional security...*/
	// by placing all that code into a function, we can call it at the beginning of each secure page
	// if the function doesn't find a SESSION id, then it will automatically redirect them;
	// if the function does find a SESSION id, then the code will just continue on through after this point
	confirm_login_status();

	$layout_context = "admin";  // Setting a context variable to change the header display...
	include("../includes/layouts/header.php");
?>

		<div id="main">
			<div id="navigation">
				&nbsp;
			</div>
			<div id="page">
				<h2>Admin Menu</h2>
				<p>Welcome to the admin area, <?php echo htmlentities($_SESSION["username"]); ?>.</p>
				<ul>
					<li><a href="manage_content.php">Manage Website Content</a></li>
					<li><a href="manage_admins.php">Manage Admin Users</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</div>
		</div>

<?php include("../includes/layouts/footer.php"); ?>