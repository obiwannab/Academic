window.onload(function () {
	/* Basic JavaScript Course
	 * Section Two, Item #17: FINAL PRACTICAL
	   -- Log In PopUp Message -- 
	   Create a popup message with JavaScript that will alert the user to a Login success/failure  */
	if ($("#error").text() === "") {
		alert("Please Login...");
	} else {
		alert("Login Attempt Falied.  Please Try Again...");
	}
	
});
