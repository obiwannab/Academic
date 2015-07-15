<?php
	require_once("../includes/session.php");
	require_once("../includes/db_connection.php");
	require_once("../includes/functions.php");
	// Check for a logged in user...
	confirm_login_status();
	
	$layout_context = "admin";
	include("../includes/layouts/header.php");
	set_current_navigation();
?>

	<div id="main">
		<div id="navigation">
			<?php navigation($current_subject, $current_page); ?>
		</div>
		<div id="page">
			<?php message(); ?>
			<?php errors(); ?>
			<h2>Create Subject</h2>
			
			<form action="create_subject.php" method="post">
				<p>Menu name:<input type="text" name="menu_name" value="" /></p>
				<p>Position:<select name="position">
					<?php
						/* A more efficient way of getting the count need here is to perform an SQL query
							on the database and have SQL COUNT the data.  Kevin Skoglund in the lynda.com lessons
							is showing us a slightly less efficient method to expose us to some interesting
							techniques that can become useful in the future.  */
						$subject_set = find_all_subjects(false);  // remember: this defined function will return a resource object with rows...
						$subject_count = mysqli_num_rows($subject_set);  // this function will return the number of rows from the resource object from the query above...
						for($count = 1; $count <= $subject_count + 1; $count++) {
							echo "<option value=\"{$count}\">{$count}</option>";
						}
					?></select></p>
				<p>Visible:<input type="radio" name="visible" value="0" />No&nbsp;
						   <input type="radio" name="visible" value="1" />Yes</p>
				<input type="submit" name="submit" value="Create Subject" />
			</form>
			<br />
			<a href="manage_content.php">Cancel</a>
		</div>
	</div>
	
<?php include("../includes/layouts/footer.php"); ?>
