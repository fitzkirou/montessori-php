<?php
/* **********************************************************************

   File: year_calendar.php
   Description: Displays a hyperlinked calendar of events. The mainline
                logic defines constants that the programmer can customize
				as required; the use of PHP date functions in the modules
				provides the automation that clients want in a Web-based
				events calendar.
   Version: 1.0
   Author: Robert B. Young
   E-mail: youngdev@canada.com
   Copyright (c) 2003 Robert B. Young.  All rights reserved.

   ********************************************************************** */
   
error_reporting (E_ALL);
$dbh = connectToDatabase ();

// Define time-related constants.
define ("IS_ONE_YEAR", FALSE);
define ("YEAR1_START_MONTH", 9);	// September to ...
define ("YEAR1_END_MONTH", 12);		// December.
define ("YEAR2_START_MONTH", 1);	// January to ...
define ("YEAR2_END_MONTH", 6);		// June.
// Define constants for the content.
define ("ORGANIZATION", "Guelph Montessori School");

//Show events for all months in this academic or fiscal year; then finish up.
include ("includes/calendar_header.php");
showMonths ();
include ("includes/footer.php");


/* -------------------------------------------------------------------------
   Establish a connection with MySQL server and your database.
------------------------------------------------------------------------- */

function connectToDatabase ()
{
	// Edit file config.php as required for your database.
	include("includes/config.php");
	
	// Define the database handle ($dbh).
	$dbh = @mysql_connect ($host, $username, $password) 
	or die ( 'I cannot connect to the database because: ' . mysql_error() );
	mysql_select_db ($database);
	return ($dbh);
}


/* -------------------------------------------------------------------------
   Within the HTML table structure, output the events in all months, 
   as defined by constants in the mainline logic (see above).
------------------------------------------------------------------------- */

function showMonths ()
{
	// Define local variables.
	$thisYear = date ("Y");
	
	// Control for one versus two calendar years.
	if (IS_ONE_YEAR)
	{
		$nextYear = $thisYear;
	}
	else
	{
		$nextYear = $thisYear + 1;
	}
	
	showCalendarYear ($thisYear, YEAR1_START_MONTH, YEAR1_END_MONTH);
	showCalendarYear ($nextYear, YEAR2_START_MONTH, YEAR2_END_MONTH);
	echo("</table>");
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
		
		// Get start date in integer day-of-the-week format.
		$StartDate = getMonthStart ($Timestamp);
		// Get last day of month--i.e., number of days in this month.
		$LastDay = date ("t", $Timestamp);

		// Output this month's table row.
		echo ('<tr><td class="monthHeader">' . $MonthName . '</td>');
		showDays ($StartDate, $LastDay, $month, $theYear);
		echo ('</tr>');
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
				echo ('<td class="normal" valign="top">&nbsp;</td>');
			}
			// cells containing weekend days
			else
			{
				echo ('<td class="weekend" valign="top">&nbsp;</td>');
			}
			
		}
	}
}


/* -------------------------------------------------------------------------
   If the date is a weekday, find out if it has been tagged as an 'event'
   in the database. Then, if it's an event, print the date in a special 
   format and hyperlink it to a pop-up window containing the full content 
   for this event record.
------------------------------------------------------------------------- */

function formatDate ($cell, $month, $theYear, $StartDate, $LastDay)
{
	if	( (($cell > 1) AND ($cell < 7))			// cells containing weekdays
		   OR (($cell > 8) AND ($cell < 14))
		   OR (($cell > 15) AND ($cell < 21))
		   OR (($cell > 22) AND ($cell < 28))
		   OR (($cell > 29) AND ($cell < 35)) )
	{
		// Get the date's type and print it accordingly.
		list ($isEvent, $code, $PK_eventID) = getDateStats ($month, $StartDate, $theYear);
		if ($isEvent)
		{
			echo ('<td class="event" title="Event Details" valign="top">');
			echo ($StartDate . '<br>');
			//echo ('<img width="25" height="5" src="images/black_dot.gif" class="multiDayEvent" align="right" />');
			echo ('<a class="code" href="#" onclick="openEventDetail(');
			echo ($PK_eventID . ')">' . $code . '</a>');
		}
		else
		{
			echo ('<td class="normal" valign="top">' . $StartDate);
		}

	}
	// If it's a weekend date, print with a grey background (class="weekend").
	else
	{
		echo ('<td class="weekend" valign="top">' . $StartDate);
	}
	// Close up the <td> cell for this date.
	echo ('</td>');
}


/* -------------------------------------------------------------------------
   Find and return the stats on this date: I.e., is it an event date, and 
   what is its code and PK_eventID? Return these values to formatDate().
------------------------------------------------------------------------- */

function getDateStats ($month, $StartDate, $theYear)
{
	// Join the 'event_start' and 'event' tables, and select where 'event_
	// start' has month, date, and year fields match this date on the calendar.
	$isEvent_query = "SELECT	e.PK_eventID, e.code
						 FROM	event e
					     JOIN	event_start s ON e.REL_startID = s.PK_startID 
						 JOIN	event_end f ON e.REL_endID = f.PK_endID 
						WHERE	s.start_month_num = '$month'
						  AND	s.start_date_num = '$StartDate'
						  AND	s.start_year = '$theYear'";
	$isEvent_result = mysql_query ($isEvent_query);
	
	// Convert dates to Unix timestamps.
	if ($isEvent_result)
	{
		$unix_event_start = mktime (0, 0, 0, m, d, y);
		$unix_this_day = mktime (0, 0, 0, m, d, y);
		$unix_event_end = mktime (0, 0, 0, m, d, y);
	}
	else
	{
		echo("<p class=\"error\">There's been a system error!</p>");
	}
	
	
	

	// Query worked, so see if there was a matching row returned.
	if ($isEvent_result)
	{
		$numberOfRows = mysql_num_rows ($isEvent_result);
		if ($numberOfRows > 0)
		{
			$isEvent = TRUE;
			while ($row = mysql_fetch_array ($isEvent_result))
			{
				$code = $row['code'];
				$PK_eventID = $row['PK_eventID'];
			}
		}
		else
		{
			// No match found, so return FALSE for all three variables.
			$isEvent = FALSE;
			$code = "";
			$PK_eventID = 0;
		}
	}
	// On FALSE query result:
	else
	{
		showErrorAndDie ();
	}
	return (array ($isEvent, $code, $PK_eventID));
}


/*
** Force an exit if the query returns FALSE.
*/
function showErrorAndDie ()
{
	echo ('<p class="error">ERROR: The calendar couldn\'t display ');
	echo ('fully because of a system error.</p>');
	exit;
}

?>
