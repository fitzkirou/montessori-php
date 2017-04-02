<?php
	/*
	** function displayLogin()
	** Provides warning and instructions if login fails.
	*/
	function displayLogin() { 
	    header("WWW-Authenticate: Basic realm=\"Guelph Montessori - Website Administration\""); 
	    header("HTTP/1.0 401 Unauthorized"); 
	    echo "<h2>Guelph Montessori - Authentication Failure</h2>"; 
	    echo "The username and password provided did not work! 
			<br />Please <b>refresh this page</b> and try again.
			<p>If you've logged out, first exit from your web browser, 
			<br />and then re-start your web browser.</p>"; 
	    exit; 
	}
	
	if (!isset($PHP_AUTH_USER) || !isset($PHP_AUTH_PW))
	{ 
	    // If username or password hasn't been entered, display the login request. 
	    displayLogin(); 
	}
	else
	{ 
	    // Escape both the password and username string to prevent users from inserting bogus data. 
	    $PHP_AUTH_USER = addslashes($PHP_AUTH_USER); 
		// Comment out next line until I do more research on md5() function. RY
	    // $PHP_AUTH_PW = md5($PHP_AUTH_PW); 
	    // Check username and password agains the database. 
	    $result = mysql_query(" SELECT count(PK_adminID) FROM administrator 
								WHERE password='$PHP_AUTH_PW' 
								AND username='$PHP_AUTH_USER' ") 
					or die("Couldn't query the user-database."); 
	    $num = mysql_result($result, 0); 
	    if (!$num)
	    { 
	        // If there were no matching users, show the login 
	        displayLogin(); 
	    } 
	} 
	
	// Support user logout (via GET variable added as ?logout=true).
	if ($_REQUEST['logout'] == true)
	{
		// Display authentication notice and resend the authentication headers.
		displayLogin();
	}
?>