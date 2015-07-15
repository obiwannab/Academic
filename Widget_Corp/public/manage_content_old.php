<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<!-- only include functions once otherwise if it gets accidentally included again, 
      PHP will return an error for attempting to redefine functions once they have 
	  already been defined. -->
<?php include("../includes/layouts/header.php"); ?>
<!-- making use of the include function in php to reuse header and footer HTML that we
	  to be consistant throughout the website, from page to page.  -->
<?php
	// Check to see if the user has selected a link from the navigation bar
	//  assign subject and page values to display correct content
	if (isset($_GET["subject"])) {
		$selected_subject_id = $_GET["subject"];
		$selected_page_id = null;
	} elseif (isset($_GET["page"])) {
		$selected_subject_id = null;
		$selected_page_id = $_GET["page"];
	} else {
		$selected_subject_id = null;
		$selected_page_id = null;
	}
?>
	<div id="main">
		<div id="navigation">
			<?php navigation($selected_subject_id, $selected_page_id); ?>
			<!-- since we moved all of the navigation HTML/PHP into a function, we simply call the
				   function to produce the navigation bar on each page that we want it displayed on.
				 Also, since I chose to have the function echo out HTML instead of concatenating an
				   output string, I do not need to echo the function call; the function will not return
				   an output for me to worry about.  (This may be a reason why Kevin Skoglund in the
				   lynda.com lessons chose to build the $output return string; it avoids confusion in
				   your future development so that you ALWAYS have a return value from a function...)  -->
		</div>
		<div id="page">
		<!-- Kevin Skoglund in the lynda.com lessons strongly encourages that the HTML code be about
			  the displaying of content and not be cluttered up with a lot of PHP code.  To this end
			  he spends a lot of time refactoring code and moving large sections of PHP code into abs
			  defined function to "clean up" the code.  But at this stage...this code looks really clean
			  to me...unless he is looking for functionality between web pages...??  -->
			<?php
			if ($selected_subject_id) {
				echo "<h2>Manage Subject</h2>";
				$current_subject = find_subject_by_id($selected_subject_id);  // returns an associative array...need to capture that
				echo "Menu name: " . $current_subject["menu_name"] . "<br />";
			} elseif ($selected_page_id) {
				echo "<h2>Manage Page</h2>";
				$current_page = find_page_by_id($selected_page_id);
				echo "Menu name: " . $current_page["menu_name"] . "<br />";
			}
			?>
		</div>
	</div>
	
<?php include("../includes/layouts/footer.php"); ?>
