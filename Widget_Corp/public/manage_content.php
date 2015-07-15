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
			<a href="admin.php">&laquo; Main menu</a><br />
			<?php navigation($current_subject, $current_page); ?>
			<br />
			<a href="new_subject.php">+ Add a subject</a>
			</div>
		<div id="page">
			<?php
				echo message();
				if ($current_subject) {
					// Display the currently selected subject information
					echo "<h2>Manage Subject</h2>";
					echo "Menu name: " . htmlentities($current_subject["menu_name"]) . "<br />";
					echo "Position: " . $current_subject["position"] . "<br />";
					echo "Visible: ";
					echo $current_subject["visible"] == 1 ? "Yes" : "No";
					echo "<br />";
					echo "<a href=\"edit_subject.php?subject=" . urlencode($current_subject["id"]) . "\">Edit Subject</a><br />";
					echo "<div style=\"margin-top: 2em; border-top: 1px solid #000000;\"><br />";
					echo "<h3>Pages in this subject:</h3>";
					$page_set = find_all_pages_for_subject($current_subject["id"], false);
					// Display any pages that are under the currently selected subject
					echo "<ul>";  //NEED TO INSERT HTML/CSS CLASS HERE...
					while ($page = mysqli_fetch_assoc($page_set)) {
						echo "<li><a href=\"manage_content.php?page=" . urlencode($page["id"]) . "\">" . htmlentities($page["menu_name"]) . "</li></a>";
					}
					mysqli_free_result($page_set);
					echo "</ul><br />+ ";
					echo "<a href=\"new_page.php?subject=" . urlencode($current_subject["id"]) . "\">Add a new page to this subject</a>";
				} elseif ($current_page) {
					echo "<h2>Manage Page</h2>";
					echo "Menu name: " . htmlentities($current_page["menu_name"]) . "<br />";
					echo "Position: " . $current_page["position"] . "<br />";
					echo "Visible: ";
					echo $current_page["visible"] == 1 ? "Yes" : "No";
					echo "<br />";
					echo "Content: <br />";
					echo "<div class=\"view-content\">" . htmlentities($current_page["content"]) . "</div>";
					echo "<br />";
					echo "<a href=\"edit_page.php?page=" . urlencode($current_page["id"]) . "\">Edit Page</a><br />";
				}
			?>
		</div>
	</div>
	
<?php include("../includes/layouts/footer.php"); ?>
