	<?php
		// Show current user's full name, fetched from database.
		$sql = " SELECT first_name, last_name FROM administrator 
					WHERE password='$PHP_AUTH_PW' 
					AND username='$PHP_AUTH_USER' ";
		$result =  mysql_query($sql) 
						or die("Couldn't query the user-database.");
		while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) // (loop actually only executes once)
		{
			echo "<div id=\"userWelcome\">";
			echo ("<b>User:</b> " . $row{'first_name'} . " " . $row{'last_name'});
			echo "</div>";
		}
	?>