<?php 
/*
** Reusable modules for the Guelph Montessori website.
*/

/* ---------------------------------------------------------------------------------
** Connect to database server and include the header HTML code.
** ---------------------------------------------------------------------------------
*/
function prepare()
{
	// Connect to MySQL server & select database.
	include ("../config.php");
	$dbh = @mysql_connect ($host, $username, $password) 
		or die ('I cannot connect to the database because: ' . mysql_error());
	mysql_select_db ($database);
	
	// Start Html and show header graphic/menu.
	include("header.php");
}

/* ---------------------------------------------------------------------------------
** Returns the month name that corresponds to the month number ID.
** ---------------------------------------------------------------------------------
*/
function getMonthName($REL_monthID)
{
	if ($REL_monthID == 1) {
		return("January");
	}
	elseif ($REL_monthID == 2) {
		return("February");
	}
	elseif ($REL_monthID == 3) {
		return("March");
	}
	elseif ($REL_monthID == 4) {
		return("April");
	}
	elseif ($REL_monthID == 5) {
		return("May");
	}
	elseif ($REL_monthID == 6) {
		return("June");
	}
	elseif ($REL_monthID == 7) {
		return("July");
	}
	elseif ($REL_monthID == 8) {
		return("August");
	}
	elseif ($REL_monthID == 9) {
		return("September");
	}
	elseif ($REL_monthID == 10) {
		return("October");
	}
	elseif ($REL_monthID == 11) {
		return("November");
	}
	else {
		return("December");
	}
}

/* ---------------------------------------------------------------------------------
** Close connection to database server and include the HTML footer code.
** ---------------------------------------------------------------------------------
*/
function finishUp()
{
	mysql_close();
	include ("footer.php");
}

?>