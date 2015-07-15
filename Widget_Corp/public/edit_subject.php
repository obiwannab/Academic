<?php
	require_once("../includes/session.php");
	require_once("../includes/db_connection.php");
	require_once("../includes/functions.php");
	require_once("../includes/validation_functions.php");
	// Check for a logged in user...
	confirm_login_status();
	
	$layout_context = "admin";
	include("../includes/layouts/header.php");
	set_current_navigation();
	// A subject id is required in order to make a change to the database.
	//  Check to make sure a subject id exists...
	if (!$current_subject) {
		redirect_to("manage_content.php");
	}

	// Begin Processing the form data (single-form submission method)
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
		//   if there are no errors, then proceed with processing, otherwise display form...
		if (empty($errors)) {
			$query = "UPDATE subjects ";
			$query .= "SET menu_name = '{$menu_name}', position = {$position}, visible = {$visible} ";
			$query .= "WHERE id = {$current_subject["id"]} LIMIT 1";
			$result = mysqli_query($connection, $query);
			if ($result && mysqli_affected_rows($connection) >= 0) {  //affected rows function will return a negative one value if there was an error in the query
				// On successful query, redirect back to Manage Content Page...
				$_SESSION["message"] = "Subject updated.";
				redirect_to("manage_content.php");
			} else {
				// On unsuccessful query, "redirect" back to the form...which is below...
				$_SESSION["message"] = "Subject update failed";
			}
		}
		$_SESSION["errors"] = $errors;
	} // If POST data not submitted, then "redirect" to the form...which is below...
?>

	<div id="main">
		<div id="navigation">
			<?php navigation($current_subject, $current_page); ?>
		</div>
		<div id="page">
			<?php message(); ?>
			<?php errors(); ?>
			<?php echo "<h2>Edit Subject: " . htmlentities($current_subject["menu_name"]) . "</h2>"; ?>
			
			<form action="edit_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>" method="post">
				<p>Menu name:<input type="text" name="menu_name" value="<?php echo htmlentities($current_subject["menu_name"]); ?>" /></p>
				<p>Position:<select name="position">
					<?php
						$subject_set = find_all_subjects(false);
						$subject_count = mysqli_num_rows($subject_set);
						for($count = 1; $count <= $subject_count; $count++) {
							echo "<option value=\"{$count}\"";
							  if ($current_subject["position"] == $count) { echo " selected"; }
							echo ">{$count}</option>";
						}
					?></select></p>
				<p>Visible:<input type="radio" name="visible" value="0" <?php if ($current_subject["visible"] == 0) { echo " checked"; } ?> />No&nbsp;
						   <input type="radio" name="visible" value="1" <?php if ($current_subject["visible"] == 1) { echo " checked"; } ?> />Yes</p>
				<input type="submit" name="submit" value="Edit Subject" />
			</form>
			<br />
			<a href="manage_content.php">Cancel</a>&nbsp;&nbsp;
			<a href="delete_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>" onclick="return confirm('Are you sure?');">Delete this subject</a>
		</div>
	</div>
	
<?php include("../includes/layouts/footer.php"); ?>
