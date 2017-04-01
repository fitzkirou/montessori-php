<?php
/*
   File: 			prnty3arca1.php
   Base URL:		http://guelphmontessori.com
   Description:		Displays a hyperlinked calendar of events.
   Author: 			Robert B. Young
   Revised:			22 October, 2013.
   
-------------------------------------------------------------------------
   PREPARE.
------------------------------------------------------------------------- */

// Kick out illegal HTTP requests for Parent Tools files.
session_start();
$isPrivate = true;
if ($isPrivate && !$_SESSION['isSignedIn']) 
{ 	
	die ("<html><body><h1>Authorization required.</h1></body></html>");
}

$dbh = connectToDatabase ();

// Define time-related constants.
define ("IS_ONE_YEAR", FALSE);
define ("YEAR1_START_MONTH", 7);	// July to ...
define ("YEAR1_END_MONTH", 12);		// December.
define ("YEAR2_START_MONTH", 1);	// January to ...
define ("YEAR2_END_MONTH", 6);		// June.
// Define constants for the content.
define ("ORGANIZATION", "Guelph Montessori School");

// Define variable $thisYear as current system year (XXXX format).
$thisYear = date ("Y");
// Ensure correct academic year is displayed during YEAR2:
// If the current month number is less than or equal to the academic 
// year's end-month, then decrement the calendar year $thisYear.
if (date ("n") <= YEAR2_END_MONTH)
{
	$thisYear = $thisYear - 1;
}
include ("includes/calendar_header.php");


/* -------------------------------------------------------------------------
   MAINLINE LOGIC
------------------------------------------------------------------------- */

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
echo "</table>\n";


/* -------------------------------------------------------------------------
   FINISH UP.
------------------------------------------------------------------------- */

include ("includes/footer.php");



/* -------------------------------------------------------------------------
   MODULE DEFINITIONS
------------------------------------------------------------------------- */

/*
 * Establish a connection with MySQL server and your database.
 */
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


/*
 * Produce a complete table row for each month, beginning with the 
 * $firstMonth and ending with the $lastMonth. For each month, find the 
 * name, start date, and last day integer value. N.B.: Don't literally
 * show a full calendar year--just the month range as per the parameters.
 */
function showCalendarYear ($theYear, $firstMonth, $lastMonth)
{
	// Output the year as a horizontal sub-header row.
	echo "<tr>\n\t<td colspan=\"39\" class=\"yearHeader\">"; 
	echo $theYear . "</td></tr>\n";
	
	for ($month = $firstMonth; $month <= $lastMonth; $month++)
	{
		$Timestamp = mktime (0, 0, 0, $month, 1, $theYear);
		$MonthName = date ("M", $Timestamp);
		
		// Get start date in integer day-of-the-week format.
		$StartDate = getMonthStart ($Timestamp);
		// Get last day of month--i.e., number of days in this month.
		$LastDay = date ("t", $Timestamp);

		// Output this month's table row.
		echo "<tr>\n\t<td class=\"monthHeader\">" . $MonthName . "</td>\n";
		showDays ($StartDate, $LastDay, $month, $theYear);
		echo "</tr>\n";
	}
}


/*
 * Find this month's starting day. Return it as a day-of-the-week integer,
 * but as its additive inverse. (This helps in the program logic.)
 */
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


/*
 * Output each calendar day in the month, showing empty grey for out-of-
 * range cells, and normal- or event-formatted dates for all other cells 
 * on this row. (Refer to the stylesheet file "includes/frontend.css".)
 */
function showDays ($StartDate, $LastDay, $month, $theYear)
{
	// Local variables: starting & end values for this row of days.
	$startCell = 1;
	$endCell = 38;
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
					   OR (($cell > 29) AND ($cell < 35)) 
					   OR $cell >= 37 )
			{
				echo "\t<td class=\"normal\" valign=\"top\">&nbsp;</td>\n";
			}
			// cells containing weekend days
			else
			{
				echo "\t<td class=\"weekend\" valign=\"top\">&nbsp;</td>\n";
			}
			
		}
	}
}


/*
 * If the date is a weekday, find out if it has been tagged as an 'event'
 * in the database. Then, if it's an event, print the date in a special 
 * format and hyperlink it to a pop-up window containing the full content 
 * for this event record.
 */
function formatDate ($cell, $month, $theYear, $StartDate, $LastDay)
{	
	list ($isEvent, $code, $PK_eventID, $isToday) = getDateStats ($month, $StartDate, $theYear);

	// Case for weekdays:
	if	( (($cell > 1) AND ($cell < 7)) OR (($cell > 8) AND ($cell < 14))
		OR (($cell > 15) AND ($cell < 21)) OR (($cell > 22) AND ($cell < 28))
		OR (($cell > 29) AND ($cell < 35)) OR $cell >= 37 )
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
	echo "</td>\n";
}


/*
 * Write the HTML (and CSS calls) to format the date.
 */
function printDate ($isEvent, $CSS_class, $StartDate, $PK_eventID, $code)
{
	// Print the date in the passed CSS class.
	echo "\t<td class=\"" . $CSS_class . "\" valign=\"top\">";
	echo $StartDate . '<br>';
	// If this is an event date, show a hyperlinked 'event' symbol.
	if ($isEvent)
	{
		echo '<a class="code" href="#" title="Event Details" onclick="openEventDetail(';
		echo $PK_eventID . ')">' . $code . '</a>';
	}
}


/*
 * Find and return the stats on this date: I.e., is it an event date, and 
 * what is its code and PK_eventID? Return these values to formatDate().
 */
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


/*
 * Determine if this calendar date is _today's_ date.
 */
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


/*
 * Force an exit if the query returns FALSE.
 */
function showErrorAndDie ()
{
	echo '<p class="error">ERROR: The calendar couldn\'t display ';
	echo "fully because of a system error.</p>\n";
	exit;
}

?>
