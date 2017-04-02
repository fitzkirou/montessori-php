<?php
/* *********************************************************************

	FILE: admin_calendar.php
	LAST MODIFIED: 2004-06-17
	AUTHOR: Robert B. Young
	E-MAIL: bob@youngstudios.net
	Copyright (c) 2003-2004 Bob Young Studios.  All rights reserved.
   
	HOW TO USE THIS FILE:
	Displays a hyperlinked calendar of events. The mainline
	logic defines constants that the programmer can customize
	as required. I.e., you can choose to display:

	(a) one full calendar year (or any consecutive month-range 
		within it), or
	
	(b) two consecutive calendar years (as in an academic or 
		fiscal year). In each calendar year, you can choose 
		any range of consecutive months. E.g., in a typical 
		academic year, for year 1 you'd show months 9-12 
		(September through December); for year 2, you'd show 
		months 1-6 (January through June).
		
	PHP's built-in date() and mktime() functions provide the
	automation here.

*** ********************************************************************* */

// NB: To change the CONSTANTS that govern the calendar's
//     behaviour, scroll down to the getDB_and_constants()
//     function below.
$dbh = getDB_and_constants ();


/*
** *********************************************
** ASSIGN THE MONTH(S) & YEAR(S) DYNAMCIALLY.
** *********************************************
*/
// Determine and assign the current SYSTEM year and month.
$systemYear = date ("Y");
$systemMonth = date ("n");

// Control for one versus two calendar years.
switch (IS_ONE_YEAR)
{
	case (true):
		$nextYear = $systemYear;
		break;

	case (false):
		// For first calendar year:
		if ($systemMonth > YEAR2_END_MONTH)
		{
			$nextYear = $systemYear + 1;
		}
		// For second calendar year:
		else if ($systemMonth <= YEAR2_END_MONTH)
		{
			$nextYear = $systemYear;
			$systemYear = $systemYear - 1;
		}
		
		break;
}


/*
** *********************************************
** OUTPUT THE WEB PAGE.
** *********************************************
*/

include ("includes/calendar_header.php");

// Within the HTML table structure (established in
// calendar_header.php), output the events in each year.
showCalendarYear ($systemYear, YEAR1_START_MONTH, YEAR1_END_MONTH);
showCalendarYear ($nextYear, YEAR2_START_MONTH, YEAR2_END_MONTH);

include ("includes/calendar_footer.php");



/*
** *************************************************************************
** FUNCTIONS FOR THIS FILE.
** *************************************************************************
*/

/* -------------------------------------------------------------------------
   Establish a connection with MySQL server and your database.
------------------------------------------------------------------------- */

function getDB_and_constants ()
{	
	/*
	** *********************************************
	** DEFINE CONSTANTS (FOR THE CALENDAR).
	** *********************************************
	*/
	// Define constants for the calendar's text content.
	define ("ORGANIZATION", "Guelph Montessori School");
	define ("ADDRESS", "151 Waterloo Avenue, Guelph, ON Canada N1H 3H9");
	define ("PHONE", "(519) 836-3810");
	define ("EMAIL", "guelphmontessori@rogers.com");
	// The following NOTE value appears just above the calendar output.
	define ("NOTE", "The following event dates are subject to change. Use this 
				calendar frequently to verify dates as the year progresses.");
	
	// Define key months to configure the academic/fiscal year.
	define ("IS_ONE_YEAR", FALSE);
	define ("YEAR1_START_MONTH", 7);	// July to ...
	define ("YEAR1_END_MONTH", 12);		// December.
	define ("YEAR2_START_MONTH", 1);	// January to ...
	define ("YEAR2_END_MONTH", 6);		// June.
	
	/*
	** *********************************************
	** Connect to db and return handle.
	** *********************************************
	*/
	// Edit file config.php as required for your database.
	include("../../config.php");
	
	// Define the database handle ($dbh).
	$dbh = @mysql_connect ($host, $username, $password) 
	or die ( 'I cannot connect to the database because: ' . mysql_error() );
	mysql_select_db ($database);
	
	return ($dbh);
}


/* -------------------------------------------------------------------------
   Produce a complete table row for each month, beginning with the 
   $firstMonth and ending with the $lastMonth. For each month, find the 
   name, start date, and last day integer value. N.B.: Don't literally
   show a full calendar year--just the month range as per the parameters.
------------------------------------------------------------------------- */

function showCalendarYear ($theYear, $firstMonth, $lastMonth)
{
	for ($month = $firstMonth; $month <= $lastMonth; $month++)
	{
		$Timestamp = mktime (0, 0, 0, $month, 1, $theYear);
		$MonthName = date ("M", $Timestamp);
		
		// Get this month's start date in day-of-the-week integer format.
		$StartDate = getMonthStart ($Timestamp);
		// Get last day of month--i.e., number of days in this month.
		$LastDay = date ("t", $Timestamp);

		// Output this month's table row.
		echo ("<tr>\n\t<td class=\"monthHeader\">" . $MonthName . "</td>\n");
		showDays ($StartDate, $LastDay, $month, $theYear);
		echo ("</tr>\n");
	}
}


/* -------------------------------------------------------------------------
   Find this month's starting day. Return it as a day-of-the-week integer,
   but as its additive inverse. (This helps in the program logic.)
------------------------------------------------------------------------- */

function getMonthStart ($Timestamp)
{
	// The format is integer day-of-the-week (0-6).
	$MonthStart = date ("w", $Timestamp);

	// Convert Sunday (value = 0) to 7, to work with the remaining logic.
	if ($MonthStart == 0)
	{
		$MonthStart = 7;
	}
	// Use additive inverse of the day-of-the-week integer;
	// further logic will output empty <td></td> cells until 
	// (a) a positive integer and (b) after this month's ending integer.
	$integerDayInverse = -$MonthStart;
	return ($integerDayInverse);
}


/* -------------------------------------------------------------------------
   Output each calendar day in the month, showing empty grey for out-of-
   range cells, and normal- or event-formatted dates for all other cells 
   on this row. (Refer to the stylesheet file "includes/frontend.css".)
------------------------------------------------------------------------- */

function showDays ($StartDate, $LastDay, $month, $theYear)
{
	// Local variables: starting & end values for this row of days.
	$startCell = 1;
	$endCell = 35;
	for ($cell = $startCell; $cell <= $endCell; $cell++)
	{
		// On each iteration, increment the printed date.
		$StartDate++;
		// Only print a date if $StartDate is within 1 and the last day 
		// (integer) of this month. Otherwise, just print an empty cell.
		if (($StartDate > 0) AND ($StartDate <= $LastDay))
		{
			formatDate ($cell, $month, $theYear, $StartDate, $LastDay);
		}
		else
		{
			// cells containing weekdays
			if	( (($cell > 1) AND ($cell < 7)) 
					   OR (($cell > 8) AND ($cell < 14))
					   OR (($cell > 15) AND ($cell < 21))
					   OR (($cell > 22) AND ($cell < 28))
					   OR (($cell > 29) AND ($cell < 35)) )
			{
				echo ("\t<td class=\"normal\" valign=\"top\">&nbsp;</td>\n");
			}
			// cells containing weekend days
			else
			{
				echo ("\t<td class=\"weekend\" valign=\"top\">&nbsp;</td>\n");
			}
			
		}
	}
}


/* -------------------------------------------------------------------------
   If the date is a weekday, find out if it has been tagged as an 'event'
   in the database. Then, if it's an event, print the date in a special 
   format and hyperlink it to the 'edit' screen for this event record.
------------------------------------------------------------------------- */

function formatDate ($cell, $month, $theYear, $StartDate, $LastDay)
{	
	list ($isEvent, $code, $PK_eventID, $isToday) = getDateStats ($month, $StartDate, $theYear);

	// Case for weekdays:
	if	( (($cell > 1) AND ($cell < 7)) OR (($cell > 8) AND ($cell < 14))
		OR (($cell > 15) AND ($cell < 21)) OR (($cell > 22) AND ($cell < 28))
		OR (($cell > 29) AND ($cell < 35)) )
	{
		if ($isEvent AND !$isToday)
		{
			$CSS_class = "event";
			printDate ($isEvent, $CSS_class, $StartDate, $PK_eventID, $code);
		}
		elseif ($isEvent AND $isToday)
		{
			$CSS_class = "eventToday";
			printDate ($isEvent, $CSS_class, $StartDate, $PK_eventID, $code);
		}
		elseif (!$isEvent AND $isToday)
		{
			$CSS_class = "today"; 
			printDate ($isEvent, $CSS_class, $StartDate, $PK_eventID, $code);
		}
		else
		{
			$CSS_class = "normal";
			printDate ($isEvent, $CSS_class, $StartDate, $PK_eventID, $code);
		}
	}
	// Case for weekend days:
	else
	{
		if ($isToday)
		{
			$CSS_class = "today";
		}
		else
		{
			$CSS_class = "weekend";
		}
		printDate ($isEvent, $CSS_class, $StartDate, $PK_eventID, $code);
	}
	// Close up the table cell for this date.
	echo ("</td>\n");
}


/* -------------------------------------------------------------------------
   Write the HTML (and CSS calls) to format the date.
------------------------------------------------------------------------- */

function printDate ($isEvent, $CSS_class, $StartDate, $PK_eventID, $code)
{
	// Print the date in the passed CSS class.
	echo ("\t<td class=\"" . $CSS_class . "\" valign=\"top\">");
	echo ($StartDate . '<br>');
	// If this is an event date, show a hyperlinked 'event' symbol.
	if ($isEvent)
	{
		echo ('<a class="code" href="event_update.php?PK_eventID=');
		echo ($PK_eventID . '" title="Edit this event">');
		echo ($code . '</a>');
	}
}


/* -------------------------------------------------------------------------
   Find and return the stats on this date: I.e., is it an event date, and 
   what is its code and PK_eventID? Return these values to formatDate().
------------------------------------------------------------------------- */

function getDateStats ($month, $StartDate, $theYear)
{
	// Join the 'event_start' and 'event' tables, and select where 'event_
	// start' has month, date, and year fields match this date on the calendar.
	$isEvent_query =  "SELECT	e.PK_eventID, e.code 
						 FROM	event e, event_start s 
					    WHERE	e.REL_startID = s.PK_startID 
						  AND	s.start_month_num = '$month' 
						  AND	s.start_date_num = '$StartDate' 
						  AND	s.start_year = '$theYear'";
	$isEvent_result = mysql_query ($isEvent_query);

	// Concatenate date parts--used in the calls to compareCellToToday() below.
	$calendar_MMDDYY = $month . $StartDate . $theYear;
	
	// Query worked, so see if there was a matching row returned.
	if ($isEvent_result)
	{
		$numberOfRows = mysql_num_rows ($isEvent_result);
		// We've got a matching row in the the 'event_start' table; it's an event!
		if ($numberOfRows > 0)
		{
			$isEvent = TRUE;
			while ($row = mysql_fetch_array ($isEvent_result))
			{
				$code = $row['code'];
				$PK_eventID = $row['PK_eventID'];
			}
			$isToday = compareCellToToday ($calendar_MMDDYY);
		}
		// No match found, so return FALSE for all three variables.
		else
		{
			$isEvent = FALSE;
			$code = "";
			$PK_eventID = 0;
			$isToday = compareCellToToday ($calendar_MMDDYY);
		}
	}
	// On FALSE query result:
	else
	{
		showErrorAndDie ();
	}
	return (array ($isEvent, $code, $PK_eventID, $isToday));
}


/* -------------------------------------------------------------------------
   Determine if this calendar date is _today's_ date.
   ---------------------------------------------------------------------- */

function compareCellToToday ($thisCellDate)
{
	$today = date("njY");	// 'mmddyyyy' format
	if ($thisCellDate == $today)
	{
		$isToday = TRUE;
	}
	else
	{
		$isToday = FALSE;
	}
	return ($isToday);
}


/* -------------------------------------------------------------------------
   Force an exit if the query returns FALSE.
   ---------------------------------------------------------------------- */

function showErrorAndDie ()
{
	echo ('<p class="error">ERROR: The calendar couldn\'t display ');
	echo ("fully because of a system error.</p>\n");
	exit;
}

?>
