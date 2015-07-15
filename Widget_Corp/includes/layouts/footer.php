		<div id="footer">Copyright <?php echo date("Y") ?>, Widget Corp</div>
	</body>
</html>
<?php
	/* Encapsulate this database close connection inside an if statement just in case this footer
		is used on pages that will not utilize the database connection (i.e. the web page never opened
		the connection in the first place).  However, PHP will close connections automatically when
		it reaches the end of the HTML/PHP code and the programmer hasn't explicitly done so.  */
	if (isset($connection)) {
		mysqli_close($connection);
	}
?>