<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
	<title>Event Details - Guelph Montessori School</title>
	<!-- Link to stylesheet. -->
	<link rel="stylesheet" type="text/css" href="includes/frontend.css">
</head>

<body class="eventDetail">

<?php

error_reporting (E_ALL);
$dbh = connectToDatabase ();
require("gms4Adm1n/includes/library.php");

// Assign the GET variable to a more simply named variable.
$passed_eventID = $_GET['PK_eventID'];

// Get the 'event' table row that's been 
// passed via JavaScript (in calendar_header.php).
$event_query = "SELECT * FROM event 
				WHERE PK_eventID = '$passed_eventID'";
$event_result = mysql_query ($event_query);

if ($event_result)
{
	while ($row = mysql_fetch_array ($event_result))
	{
		$numerOfRows = mysql_num_rows ($event_result);
		if ($numerOfRows > 0)
		{
			showEventType ($row);
			showEvent ($row);
		}
		else
		{
			echo ('<p class="error">No record exists for this event!');
			echo (' Please contact the Guelph Montessori School to report this.</p>');
		}
	}
}
else
{
	echo ('<p class="error">The event\'s details can\'t be shown ');
	echo ('because of a system error.</p>');
}


/* -------------------------------------------------------------------------
   Establish a connection with MySQL server and your database.
------------------------------------------------------------------------- */

function connectToDatabase ()
{
	// Edit file config.php as required for your database.
	include("../config.php");
	
	// Define the database handle ($dbh).
	$dbh = @mysql_connect ($host, $username, $password) 
	or die ( 'I cannot connect to the database because: ' . mysql_error() );
	mysql_select_db ($database);
	return ($dbh);
}


/* -------------------------------------------------------------------------
   Output and format the event's type as the page title. 
-------------------------------------------------------------------------  */
function showEventType ($row)
{
	echo ('<h1 class="eventDetail">');
	echo ($row['type']);
	echo ('</h1>');
	// echo ('<br />');
}


/* -------------------------------------------------------------------------
   Output and format the event.
-------------------------------------------------------------------------  */
function showEvent ($row)
{
	echo ("<p>");
	echo ("<span class=\"eventTitle\">" . $row['title'] . "</span><br>");
	//next 2 functions are in admin/includes/library.php
	showDateTime($row);
	showLocation($row);
	echo ("</p>");
}

?>

<!-- 'Close' button -->
<a href="javascript:window.close();" style="font-size:11px;">
	Close
</a>

</body>
</html>

<?php
	mysql_close($dbh);
?>
