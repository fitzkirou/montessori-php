<?php
	include("../../config.php");
	// Connect to MySQL server.
	$dbh = @mysql_connect ($host, $username, $password) 
		or die ( '<p style="color:red;"><b style="color:black;">Guelph Montessori School</b><br><br>There\'s a problem connecting to the Guelph Montessori database.<br>Please contact the School\'s <a title="E-mail the webmaster" href="mailto:bob@youngstudios.net">webmaster.</a></p>');
	// Select the database to use.
	mysql_select_db ($database);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title><?php echo($title); ?> - Guelph Montessori School</title>
  <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
  <meta content="Robert Bruce Young" name="author">
<!-- Link to stylesheet -->
  <link rel="stylesheet" type="text/css" href="gms_enrol.css">
<!-- Text-Input field behaviour NOT IMPLEMENTED YET: w3schools.com/jsref/event_onfocus.asp -->
  <script type="text/javascript">
    function setStyle(x)     {
      document.getElementById(x).style.background="yellow"
    }
  </script>
</head>
<body style="background-image: url(../images/bg_texture.gif); background-color: rgb(224, 233, 242);">
