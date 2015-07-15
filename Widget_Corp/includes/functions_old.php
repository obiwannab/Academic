<?php
// Confirm that a Database Query was successful
function confirm_query($result_set) {
	if (!$result_set) {
		die("Database query failed.");
	}
}

// Get all the subject links for the navigation bar
function find_all_subjects() {
	global $connection;
	$subject_set = mysqli_query($connection, "SELECT * FROM subjects WHERE visible = 1 ORDER BY position ASC");
	confirm_query($subject_set);
	return $subject_set;
}

// Get all the page links within a subject for the navigation bar
function find_pages_for_subject($subject_id) {
	global $connection;
	$safe_subject_id = mysqli_real_escape_string($connection, $subject_id);
	$page_set = mysqli_query($connection, "SELECT * FROM pages WHERE visible = 1 AND subject_id = {$safe_subject_id} ORDER BY position ASC");
	confirm_query($page_set);
	return $page_set;
}

// Display Navigation Bar with current user feedback css
//  Requires two arguments: both the currently selected subject and page id variables
function navigation($selected_subject_id, $selected_page_id) {
	/* There are differing opinions on whether or not a function should use echo and output directly
		as it is executed, or if the function should return a value (e.g. an output string) so that the
		programmer can decide what to do with it in the main body of the code.
		Kevin Skoglund in the lynda.com lessons believes it is a better practice to concatenate together an
		$output string and return that instead of doing what I did and just have the function echo out
		all of the strings as the function executes...  */
	echo "<ul class=\"subjects\" >";
	$subject_set = find_all_subjects();
	while($subject = mysqli_fetch_assoc($subject_set)) {
		echo "<li";
		if ($subject["id"] == $selected_subject_id) { echo  " class=\"selected\" "; }
		echo ">";
		echo "<a href=\"manage_content.php?subject={$subject["id"]}\">" . $subject["menu_name"] . "</a>";
		$page_set = find_pages_for_subject($subject["id"]);
		echo "<ul class=\"pages\">";
			while($page = mysqli_fetch_assoc($page_set)) {
				echo "<li";
				  if ($page["id"] == $selected_page_id) { echo " class=\"selected\" "; }
				echo ">";
				echo "<a href=\"manage_content.php?page={$page["id"]}\">" . $page["menu_name"] . "</li></a>";
			}
		mysqli_free_result($page_set);
		echo "</ul>";
		echo "</li>";
	}	
	mysqli_free_result($subject_set);  // Release the Query Data
	echo "</ul>";
}

// Get content to display based on currently selected subject
//  Requires the currently selected subject as argument
//  Returns the associative array containing the single row of data from database
function find_subject_by_id($selected_subject_id) {
	// CAUTION: since $selected_subject_id is simply a query number from the URL, it could be tampered with
	//   so be sure to protect the code from SQL Injection threats...
	global $connection;
	$safe_subject_id = mysqli_real_escape_string($connection, $selected_subject_id);
	$subject_content = mysqli_query($connection, "SELECT * FROM subjects WHERE id = {$safe_subject_id}");
	confirm_query($subject_content);
	if ($output = mysqli_fetch_assoc($subject_content)) {
		return $output;
	} else {
		return null;  // return no value if there is nothing in the queried row
	}
}

// Get content to display based on currently selected page
//  Requires the currently selected subject as argument
//  Returns the associative array containing the single row of data from database
function find_page_by_id($selected_page_id) {
	global $connection;
	$safe_page_id = mysqli_real_escape_string($connection, $selected_page_id);
	$page_content = mysqli_query($connection, "SELECT * FROM pages WHERE id = {$safe_page_id}");
	confirm_query($page_content);
	if ($output = mysqli_fetch_assoc($page_content)) {
		return $output;
	} else {
		return null;
	}
}


?>