<?php
// Modifies HTTP Header to perform a redirect to a different URL
// CAUTION: use of this function will only work if output buffering is turned ON...
//   remember that changing the HTTP Header has to happen first before ANY HTML rendering,
//	 so if output buffering is turned OFF, then turn it on at the start of the page...?
function redirect_to($new_location) {
	header("Location: " . $new_location);
	exit;
}

// Confirm that a Database Query was successful
function confirm_query($result_set) {
	if (!$result_set) {
		die("Database query failed.");
	}
}

// Get all admins
function find_all_admins() {
	global $connection;
	$admin_set = mysqli_query($connection, "SELECT * FROM admins ORDER BY username ASC");
	confirm_query($admin_set);
	return $admin_set;
}

// Get all the subject links
//   Will take a boolean argument to change the query based on context, default is true
/*   As a best practice, use a conditional to "reuse" code and thus avoid having to repeat yourself.
       In this case, we are using an conditional to modify only a single aspect of this function, in order
	   to get the function to behave differently under certain conditions...context  */
function find_all_subjects($public = true) {
	global $connection;
	$query = "SELECT * FROM subjects ";
	if ($public) { $query .= "WHERE visible = 1 "; }
	$query .= "ORDER BY position ASC";
	$subject_set = mysqli_query($connection, $query);
	confirm_query($subject_set);
	return $subject_set;
}

// Get all the page links within a subject
//  Requires one argument: the current subject
//  Will take a boolean argument second to change the query based on context, default is true
function find_all_pages_for_subject($subject_id, $public = true) {
	global $connection;
	$safe_subject_id = mysqli_real_escape_string($connection, $subject_id);
	$query = "SELECT * FROM pages WHERE subject_id = {$safe_subject_id} ";
	if ($public) { $query .= "AND visible = 1 "; }
	$query .= "ORDER BY position ASC";
	$page_set = mysqli_query($connection, $query);
	confirm_query($page_set);
	return $page_set;
}

// Establish a default page for viewing on the public subject selection
function find_default_page_for_subject($subject_id) {
	$page_set = find_all_pages_for_subject($subject_id);
	if ($first_page = mysqli_fetch_assoc($page_set)) {
		return $first_page;
	} else {
		return null;
	}
}

// Establish global variables for the current navigation selection
//  Will take a boolean argument that will bypass the default page query to the database, default is false
function set_current_navigation($public = false) {
	global $current_subject;  // This will establish global variables without needing to return and
	global $current_page;     //   capture values in our main body code...
	if (isset($_GET["subject"])) {
		$current_subject = find_subject_by_id($_GET["subject"], $public);  //What if a user types in a page number in the URL that is supposed to not be visible...
		if ($current_subject && $public) { $current_page = find_default_page_for_subject($current_subject["id"]); }
			else { $current_page = null; }
	} elseif (isset($_GET["page"])) {
		$current_subject = null;
		$current_page = find_page_by_id($_GET["page"], $public);
	} else {
		$current_subject = null;
		$current_page = null;
	}
}

// Display Navigation Bar with current user feedback css
//  Requires two arguments: both the current subject and page associative arrays or null values
function navigation($subject_array, $page_array) {
	echo "<ul class=\"subjects\" >";
	$subject_set = find_all_subjects(false);
	while($subject = mysqli_fetch_assoc($subject_set)) {
		echo "<li";
		  if ($subject_array && $subject["id"] == $subject_array["id"]) { echo  " class=\"selected\" "; }
		echo ">";
		echo "<a href=\"manage_content.php?subject=" . urlencode($subject["id"]) . "\">" . htmlentities($subject["menu_name"]) . "</a>";
		$page_set = find_all_pages_for_subject($subject["id"], false);
		echo "<ul class=\"pages\">";
			while($page = mysqli_fetch_assoc($page_set)) {
				echo "<li";
				  if ($page_array && $page["id"] == $page_array["id"]) { echo " class=\"selected\" "; }
				echo ">";
				echo "<a href=\"manage_content.php?page=" . urlencode($page["id"]) . "\">" . htmlentities($page["menu_name"]) . "</li></a>";
			}
		mysqli_free_result($page_set);
		echo "</ul>";
		echo "</li>";
	}	
	mysqli_free_result($subject_set);  // Release the Query Data
	echo "</ul>";
}

// Display the Public Navigation Bar with current user feedback css
//  Requires two arguments: both the current subject and page associative arrays or null values
function public_navigation($subject_array, $page_array) {
	echo "<ul class=\"subjects\" >";
	$subject_set = find_all_subjects();
	while($subject = mysqli_fetch_assoc($subject_set)) {
		echo "<li";
		  if ($subject_array && $subject["id"] == $subject_array["id"]) { echo  " class=\"selected\" "; }
		echo ">";
		echo "<a href=\"index.php?subject=" . urlencode($subject["id"]) . "\">" . htmlentities($subject["menu_name"]) . "</a>";
		// Only display the pages within the currently selected subject (or when viewing a page within that subject)...
		if ($subject_array["id"] == $subject["id"] || $page_array["subject_id"] == $subject["id"]) {
			$page_set = find_all_pages_for_subject($subject["id"]);
			echo "<ul class=\"pages\">";
				while($page = mysqli_fetch_assoc($page_set)) {
					echo "<li";
					  if ($page_array && $page["id"] == $page_array["id"]) { echo " class=\"selected\" "; }
					echo ">";
					echo "<a href=\"index.php?page=" . urlencode($page["id"]) . "\">" . htmlentities($page["menu_name"]) . "</li></a>";
				}
			mysqli_free_result($page_set);
			echo "</ul>";
		}
		echo "</li>";
	}	
	mysqli_free_result($subject_set);  // Release the Query Data
	echo "</ul>";
}

// Get admin info to display and/or compare
//  Requires the currently selected/logged in admin id as argument
function find_admin_by_id($admin_id) {
	global $connection;
	$safe_admin_id = mysqli_real_escape_string($connection, $admin_id);
	$admin_info = mysqli_query($connection, "SELECT * FROM admins WHERE id = {$safe_admin_id}");
	confirm_query($admin_info);
	if ($output = mysqli_fetch_assoc($admin_info)) {
		return $output;
	} else {
		return null;
	}
}

// Get admin info to display and/or compare
//  Requires the currently selected/logged in admin username as argument
function find_admin_by_username($admin_username) {
	global $connection;
	$safe_admin_username = mysqli_real_escape_string($connection, $admin_username);
	$admin_info = mysqli_query($connection, "SELECT * FROM admins WHERE username = '{$safe_admin_username}'");
	confirm_query($admin_info);
	if ($output = mysqli_fetch_assoc($admin_info)) {
		return $output;
	} else {
		return null;
	}
}

// Get content to display based on currently selected subject
//  Requires the currently selected subject as argument
//  Will take a boolean to change the query to only find visible pages for the public, default is true
//  Returns the associative array containing the single row of data from database
function find_subject_by_id($selected_subject_id, $public = true) {
	// CAUTION: since $selected_subject_id is simply a query number from the URL, it could be tampered with
	//   so be sure to protect the code from SQL Injection threats...
	global $connection;
	$safe_subject_id = mysqli_real_escape_string($connection, $selected_subject_id);
	$query = "SELECT * FROM subjects WHERE id = {$safe_subject_id} ";
	if ($public) { $query .= "AND visible = 1 "; }
	$query .= "LIMIT 1";
	$subject_content = mysqli_query($connection, $query);
	confirm_query($subject_content);
	if ($output = mysqli_fetch_assoc($subject_content)) {
		return $output;
	} else {
		return null;  // return no value if there is nothing in the queried row
	}
}

// Get content to display based on currently selected page
//  Requires the currently selected subject as argument
//  Will take a boolean to change the query to only find visible pages for the public, default is true
//  Returns the associative array containing the single row of data from database
function find_page_by_id($selected_page_id, $public = true) {
	global $connection;
	$safe_page_id = mysqli_real_escape_string($connection, $selected_page_id);
	$query = "SELECT * FROM pages WHERE id = {$safe_page_id} ";
	if ($public) { $query .= "AND visible = 1 "; }
	$query .= "LIMIT 1";
	$page_content = mysqli_query($connection, $query);
	confirm_query($page_content);
	if ($output = mysqli_fetch_assoc($page_content)) {
		return $output;
	} else {
		return null;
	}
}

// Encrypt the user's password
//  Requires a string to process and will return the encrypted hash.
/* This function is scheduled to be included in the PHP syntax for v5.5 release
	called password_hash($password, PASSWORD_DEFAULT)  */
function encrypt_password($password) {
	$hash_format = "$2y$10$";  // Tells PHP to use Blowfish algorithm and repeat 10 times
	$salt_length = 22;  // Blowfish salts should be 22 or more characters in length
	$salt = generate_salt($salt_length);  // Defined function to randomly generate the salt...
	$format_and_salt = $hash_format . $salt;
	$hash = crypt($password, $format_and_salt);
	return $hash;
}

// Generate a random salt string for hashing
//  Requires a length as an argument and returns a random string of that length
function generate_salt($length) {
	// Not 100% unique, not 100% random, but good enough for a salt string
	// The uniqid function takes a value and returns a uniqid id number; 
	//   the true paramenter tells the function to make it a little longer, be more secure...
	// Note that MD5 returns 32 characters
	$unique_random_string = md5(uniqid(mt_rand(), true));
	
	// Valid characters for a salt are [a-z], [A-Z], [0-9], period, and forward-slash
	$base64_string = base64_encode($unique_random_string);
	
	// The base64_encode function will make sure only the valid characters are present in the string
	//  with one except, it allows the plus symbol as well. So we will manually edit that here...
	$modified_base64_string = str_replace('+', '.', $base64_string);
	
	// Truncate the string down to the correct length...
	$salt = substr($modified_base64_string, 0, $length);
	
	return $salt;
}

// Verify that entered password is the stored password in the database
//  Requires the user input password and the hashed-password stored in the database as arguments
//  Will return a boolean of either true if they match or false if they do not.
/* This function is scheduled to be included in the PHP syntax for v5.5 release
	called password_verify($password, $existing_hash)  */
function check_password($password, $existing_hash) {
	// the existing hash contains the format and salt at the start of the string
	$hash = crypt($password, $existing_hash);
	if ($hash === $existing_hash) {
		return true;
	} else {
		return false;
	}
}

// This will escape the user input, query the database by username, and verify the hashed password
//  Requires both a username and password as arguments
//  Returns a either the admin array from the database if the hashed-password is a match to the one stored in the database
//    or a boolean of false if either the username is not found in the database or the hashed password does not match
function attempt_login($username, $password) {
	$valid_admin = find_admin_by_username($username);
	if ($valid_admin) {
		// Admin Username found in database
		if (check_password($password, $valid_admin["hashed_password"])) {
			// Password is a match
			return $valid_admin;
		} else {
			// Password is not a match - Login fail...
			return false;
		}
	} else {
		// Admin Username not found in database - Login fail...
		return false;
	}
}

// This will check the current session to determine if the current user is logged in or not
//  Returns a boolean value, true if the user is logged in, false if not
function logged_in() {
	return isset($_SESSION["admin_id"]);
}

// This will redirect users if they are not logged in, otherwise it will allow the user to continue
function confirm_login_status() {
	if (!logged_in()) {
		redirect_to("login.php");
	}
}

?>