<?php
	/* PHP Course
	   Section Four, Item #2: FINAL PRACTICAL
		
		-- Successful Login Page --  
		This is a temporary page for a future web application to keep
		  track of some personal databases at home   */

	// Confirm Login Status
	session_start();
	if (!isset($_SESSION["user_id"])) {
		// redirect to login page...
		header("Location: login.php");
		exit;
	}
?>
<!DOCTYPE html>
<!-- Basic JavaScript Course
	 Section Two, Item #7: DRILL
	 
	 -- Sliding Menu --
	 Create a link called "Menu" and make the link extend downward when the user
	 	hovers the mouse over the link.  -->
<html lang="en-us">
	<head>
		<meta charset="UTF-8" />
		<title>Final Practical Success Page</title>
		<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.1.3.min.js"></script>
		<script type="text/javascript" src="behavior.js"></script>
		<link rel="stylesheet" type="text/css" href="presentation.css" />
	</head>
	<nav>
		<p id="menu">Menu</p>
		<ul>
			<li><a href="kickstarter.html">Kickstarter Tracking</a></li>
			<li><a href="boardgame.html">Board Game Collection</a></li>
			<li><a href="remember.html">Remembral</a></li>
		</ul>
	</nav>
	<body>
		<h1>PHP Course</h1>
		<h2>Section Four, Item #2: FINAL PRACTICAL</h2>
		<br />
		<h3>You are now Logged in...</h3>
		<br />
		<p>This is my temporary success page.</p>
		<p>My future web application will display here, which will be a simple database management system to display and update some personal information at home.</p>
		<br />
		<a href="logout.php">Logout</a>
		<br />
		<h1>Basic JavaScript Course</h1>
		<h2>Section Two, Item #17: FINAL PRACTICAL</h2>
		<br />
		<img id="currentSlide" src="pic1.jpg" alt="Picture1 - Clouds" />
		<aside id="slider">
			<img src="pic1.jpg" alt="Picture1 - Clouds" />
			<img src="pic2.jpg" alt="Picture2 - Desk" />
			<img src="pic3.jpg" alt="Picture3 - Rain" />
		</aside>
	</body>
</html>
