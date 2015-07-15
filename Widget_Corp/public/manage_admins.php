<?php
	require_once("../includes/session.php");
	require_once("../includes/db_connection.php");
	require_once("../includes/functions.php");
	// Check for a logged in user...
	confirm_login_status();
	
	$layout_context = "admin";
	include("../includes/layouts/header.php");
?>

	<div id="main">
		<div id="navigation">
			<a href="admin.php">&laquo; Main menu</a><br />
		</div>
		<div id="page">
			<?php
				echo message();
				// Display all of the admins currently in the database.
				echo "<h2>Manage Admins</h2>";
				echo "<table><tr>";
				echo "<th style=\"text-align: left; width: 200px;\">Username</th>";
				echo "<th colspan=\"2\" style=\"text-align: left;\">Actions</th></tr>";
				$admin_set = find_all_admins();
				while ($admin = mysqli_fetch_assoc($admin_set)) {
					echo "<tr><td>" . htmlentities($admin["username"]) . "</td>";
					echo "<td><a href=\"edit_admin.php?id={$admin["id"]}\">Edit</a></td>";
					echo "<td><a href=\"delete_admin.php?id={$admin["id"]}\" onclick=\"return confirm('Are you sure?');\">Delete</a></td>";
					echo "</td>";
				}
				mysqli_free_result($admin_set);
				echo "</table><br />";
				echo "<a href=\"new_admin.php\">Add new admin</a>";
			?>
		</div>
	</div>
	
<?php include("../includes/layouts/footer.php"); ?>
