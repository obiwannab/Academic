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
		$subject_id = (int) $current_subject["id"];
		$menu_name = mysqli_real_escape_string($connection, $_POST["menu_name"]);
		$position = (int) $_POST["position"];
		$visible = (int) $_POST['visible'];
		$content = mysqli_real_escape_string($connection, $_POST["content"]);
		
		// Validate the form data...
		$required_fields = array('menu_name', 'position', 'visible', 'content');
		validate_fields($required_fields);
		$fields_with_limit = array("menu_name" => 30);
		validate_lengths($fields_with_limit);
		
		// Check for errors in the validation sequence...
		//   if there are no errors, then proceed with processing, otherwise display form...
		if (empty($errors)) {
			$query = "INSERT INTO pages (subject_id, menu_name, position, visible, content) ";
			$query .= "VALUES ({$subject_id}, '{$menu_name}', {$position}, {$visible}, '{$content}')";
			$result = mysqli_query($connection, $query);
			if ($result) {
				// On successful query, redirect back to Manage Content Page...
				$_SESSION["message"] = "Page created.";
				redirect_to("manage_content.php?subject={$subject_id}");
			} else {
				// On unsuccessful query, "redirect" back to the form...which is below...
				$_SESSION["message"] = "Page creation failed";
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
			<?php echo "<h2>Create New Page</h2>"; ?>
			
			<form action="new_page.php?subject=<?php echo urlencode($current_subject["id"]); ?>" method="post">
				<p>Page name:<input type="text" name="menu_name" value="" /></p>
				<p>Position:<select name="position">
					<?php
						$page_set = find_all_pages_for_subject($current_subject["id"], false);
						$page_count = mysqli_num_rows($page_set);
						for($count = 1; $count <= ($page_count + 1); $count++) {
							echo "<option value=\"{$count}\"";
							  if ($count == ($page_count + 1)) { echo " selected"; }
							echo ">{$count}</option>";
						}
					?></select></p>
				<p>Visible:<input type="radio" name="visible" value="0" />No&nbsp;
						   <input type="radio" name="visible" value="1" />Yes</p>
				<p>Content:<br /><textarea name="content" rows="20" cols="80"></textarea></p>
			   <input type="submit" name="submit" value="Create Page" />
			</form>
			<br />
			<a href="manage_content.php?subject=<?php echo urlencode($current_subject["id"]); ?>">Cancel</a>
		</div>
	</div>
	
<?php include("../includes/layouts/footer.php"); ?>
