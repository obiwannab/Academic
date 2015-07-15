<?php
	require_once("../includes/session.php");
	require_once("../includes/db_connection.php");
	require_once("../includes/functions.php");
	$layout_context = "public";  // Setting the context variable to change the header...
	include("../includes/layouts/header.php");
	set_current_navigation(true);
?>

	<div id="main">
		<div id="navigation">
			<a href="admin.php">&laquo; Main menu</a><br />
			<?php public_navigation($current_subject, $current_page); ?>
			</div>
		<div id="page">
			<?php
				if ($current_page) {
					echo "<h2>" . htmlentities($current_page["menu_name"]) . "</h2>";
					// The nl2br function will change "new line" entries in the text into BR tags for HTML to render the line return
					echo nl2br(htmlentities($current_page["content"]));
					echo "<br />";
				} else {
					echo "<p>Welcome</p>"; // Essentially the Home Page...
				}
			?>
		</div>
	</div>
	
<?php include("../includes/layouts/footer.php"); ?>
