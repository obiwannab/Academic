<?php
	/* Placing all of the connection PHP code in a separate file makes it easy to include
		just like with headers and footers in case changes need to be made to the database connection
		procedure.  Now it can be done in one place and it affects the entire website.  */

	/* Using constants to define each of the parameters needs for the database connection...
		Kevin did not go into detail as to WHY you would really do this.  Is it to allow
		you quick access to those values in the PHP code?? maybe to keep those values away from 
		potential hackers??  It is unclear why defining constants and/or using dynamic variables
		inside the connection function (and even a page unique query function) is necessary...  */
			//define("DB_SERVER", "localhost");
			//define("DB_USER", "widget_cms");
			//define("DB_PASS", "secretpassword");
			//define("DB_NAME", "widget_corp");
	$connection = mysqli_connect("localhost", "widget_cms", "secretpassword", "widget_corp");
	if (mysqli_connect_errno()) {
		die("Database connection failed: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")" );
	}
?>
