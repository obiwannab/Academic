<?php
	/* PHP Course
	   Section Four, Item #2: FINAL PRACTICAL
		
		-- Login Page --  
		This is a self-submitting login page for a future web application to keep
		  track of some personal databases at home   */

	// Establish connection with database
	$connection = mysqli_connect("localhost", "web_app", "secret", "personal");
	if (mysqli_connect_errno()) {
		die("Database connection failed: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")" );
	}

	$message = "";  // Initialize the message string for processing...
	
	// Check for form data submission
	if (isset($_POST["submit"])) {
		// form data was submitted
		$username = $_POST["username"];
		$password = $_POST["password"];
		// Validate the submitted data
		if (!isset($username) || !isset($password)) {
			// No username or password submitted (blank fields submitted)
			$message = "Invalid Username/Password...";
		}
		
		// Check for Validation errors
		if (empty($message)) {
			// Attempt Login...
			$safe_username = mysqli_real_escape_string($connection, $username);
			$query = "SELECT * FROM users WHERE username = '{$username}'";
			$query_result = mysqli_query($connection, $query);
			if (!$query_result) {
				echo $query;
				die("Database query failed.");  // Terminate code if the database query fails (returns an error)
			}
			$user_info = mysqli_fetch_assoc($query_result);
			if ($user_info) {
				// Username found in database
				if ($password === $user_info["password"]) {
					// Password is a match...successful login
					session_start();
					$_SESSION["user_id"] = $user_info["id"];
					$_SESSION["username"] = $user_info["username"];
					header("Location: success.php");
					exit;
				} else {
					// Password is not a match...login fails
					$message = "PASSWORD DOES NOT MATCH..."; //Username/Password do not match";
				}
			} else {
				// Username was not found in the database
				$message = "USERNAME NOT FOUND..."; //Username/Password do not match";
			}
		}
	} else {
		// form data was not submitted
		// set default dynamic values when page loads without POST array
		$username = "";
	}
?>
<!DOCTYPE html>
<html lang="en-us">
	<head>
		<meta charset="UTF-8" />		
		<title>Final Practical Login Page</title>
		<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.1.3.min.js"></script>
		<script type="text/javascript" src="login.js"></script>
	</head>
	<body>
		<h1>PHP Course</h1>
		<h2>Section Four, Item #2: FINAL PRACTICAL</h2>
		<h3 id="error"><?php echo $message; ?></h3>
		<p>Please Login...</p>
		<form action="login.php" method="post">
			Username: <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" /><br />
			Password: <input type="password" name="password" value="" /><br />
			<br />
			<input type="submit" name="submit" value="Submit" />
		</form>
	</body>
</html>
