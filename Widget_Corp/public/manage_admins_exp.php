<?php
	require_once("../includes/session.php");
	require_once("../includes/db_connection.php");
	require_once("../includes/functions.php");
	$layout_context = "admin";
	include("../includes/layouts/header.php");
?>

	<div id="main">
		<div id="navigation">

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
			<!-- Using this area to try out the password hashing... -->
			<hr />
			<?php 
				/* The hash_format string tells PHP what algorithm to use and how many times to run the algorithm.
					 In this case, "2y" tells PHP to use Blowfish, and run it "10" times.
					 Normally, salt would be randomly generated...but we want it to be 22 characters long (or more, but not less);
					 Blowfish will require that length.  */
				$password = "secret";
				$hash_format = "$2y$10$";
				$salt = "Salt22Characters0rMore";
				echo "Length: " . strlen($salt) . "<br />";
				$format_and_salt = $hash_format . $salt;
				
				$hash = crypt($password, $format_and_salt);
				echo $hash;
				/* The crypt function will return a large string that is comprised of the $hash_format string,
					 followed by the $salt string, followed by the encrypted string.  This is useful because now
					 we can just pass the $hash back into the encryption process when a user tries to authenticate.
					 The crypt function is programmed to take the first 22 characters of the $salt string to use as salt.
					 This allows for use to reuse the $hash string and have already stored there at the beginning, the
					 salt string needed for comparison.  */
				$hash2 = crypt("secret", $hash);
				echo "<br />";
				echo $hash2;
				 ?>
		</div>
	</div>
	
<?php include("../includes/layouts/footer.php"); ?>
