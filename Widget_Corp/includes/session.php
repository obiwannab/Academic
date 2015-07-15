<?php
session_start();
// This will be a functions file but all related to the current session...

// Display messages from other pages...	
function message() {	
	if (isset($_SESSION["message"])) {
		echo "<div class=\"message\">";
		echo htmlentities($_SESSION["message"]);  // The SESSION message could be coming from anywhere...protect the HTML code...
		echo "</div>";
		$_SESSION["message"] = null;  // clear out the message after displaying it...
	}
}

// Display error messages from failed validation(s)...
function errors() {	
	if (isset($_SESSION["errors"])) {
		$err = $_SESSION["errors"];  // I am in control of the error messages...very low risk of HTML code corruption...
		echo "<div class=\"error\">";
		echo "Please be aware...<br />";
		echo "<ul>";
		foreach ($err as $key => $message) {
			echo "<li>" . htmlentities($message) . "</li>";
		}
		echo "</ul></div>";
		$_SESSION["errors"] = null;  // clear out the error messages after displaying it...
	}
}
?>