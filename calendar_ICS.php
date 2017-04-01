<?php

/*
   File: 		icscalendar.php
   Base URL:	http://guelphmontessori.com
   Description:	Outputs an ics formatted calendar.
   Copyright:	(c) Bob Young 2004
   				(c) Antony Savich 2010, 2011
*/

require_once '../iCalcreator.class.php';
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

/* -------------------------------------------------------------------------
   MAINLINE LOGIC
------------------------------------------------------------------------- */
$v = new vcalendar();                          // initiate new CALENDAR
$v->setConfig( 'unique_id', 'guelphmontessori.com' );             // config with site domain
$v->setProperty( 'X-WR-CALNAME', 'School Year Calendar' );          // set some X-properties, name, content.. .
$v->setProperty( 'X-WR-CALDESC', 'School year events in ics format' );
$v->setProperty( 'X-WR-TIMEZONE', 'Canada/Eastern' );

// Control for one versus two calendar years.
if (IS_ONE_YEAR) {
	showCalendarYear ($thisYear, YEAR1_START_MONTH, YEAR1_END_MONTH,$v);
} else {
	$nextYear = $thisYear + 1;
	showCalendarYear ($thisYear, YEAR1_START_MONTH, YEAR1_END_MONTH,$v);
	showCalendarYear ($nextYear, YEAR2_START_MONTH, YEAR2_END_MONTH,$v);
}

//echo("<br>------------------------<br>");
//$v->setConfig( "filename", "gmscalendar.ics" );

$v->returnCalendar();

//$str = $v->createCalendar();                   // generate and get output in string, for testing?
//echo $str;
//echo "<br />\n\n";


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
function showCalendarYear ($theYear, $firstMonth, $lastMonth, $c)
{
	//echo("doing showCalendarYear for $theYear, $firstMonth, $lastMonth<br>/r/n");

	$isEvent_query =  "SELECT	*
						 FROM	event e, event_start s
					    WHERE	e.REL_startID = s.PK_startID
						  AND	s.start_month_num >= $firstMonth
						  AND	s.start_month_num <= $lastMonth
						  AND	s.start_year = '$theYear'";
	$isEvent_result = mysql_query ($isEvent_query);

	// Query worked, so see if there was a matching row returned.
	if ($isEvent_result) {
		$numberOfRows = mysql_num_rows ($isEvent_result);
		//echo("got $numberOfRows matching rows <br>/r/n");

		if ($numberOfRows > 0) {
			while ($row = mysql_fetch_array ($isEvent_result)) {
				$code = $row['code'];
				$endid = $row['REL_endID'];
				$sd = $row['start_date_num'];
				$sm = $row['start_month_num'];
				$st = $row['start_time'];
				$sth = $st[0].$st[1];
				$stm = $st[3].$st[4];
				$sts = $st[6].$st[7];
				$st_ap = $row['start_AmPm'];
				//echo("time = <br>$st_ap<br>");
				switch ($st_ap) {
					case "a.m.":
						//echo("time = <br>$st_ap<br>\n");
						break;
					case "p.m.":
						if ($sth!=12) $sth=$sth+12;
						//echo("time = <br>$st_ap<br>supposedly converting<br> -- $sth\n");
						break;
				}
				$PK_eventID = $row['PK_eventID'];
				$title = utf8_encode($row['title']);
				$location = utf8_encode($row['location']);

				// stuff below doesn't work if you don't have mb_detect_encoding or mb_check_encoding
				//$title = $row['title'];
				//$location = $row['location'];
				// do utf-8 correction for non ascii characters
				//mb_check_encoding($title, 'UTF-8') ?  : $location = utf8_encode($location);
				//mb_check_encoding($location, 'UTF-8') ?  : $location = utf8_encode($location);


				//echo("EVENT: $code $theYear:$sm:$sd $PK_eventID $title <br>");


				$e = new vevent();
				$codename="";
				switch ($code) {
					case "D":
						$codename="Designated Holiday";
						break;
					case "E":
						$codename="School Event";
						break;
					case "H":
						$codename="Statutory Holiday";
						break;
					case "P":
						$codename="Professional Development Day";
						break;
				}

				$e->setProperty( 'categories', $codename );
				$e->setProperty( 'categories', 'GMS' );
				if ($st=="00:00:00") {
					$e->setProperty( 'dtstart' , $theYear, $sm, $sd,array( 'VALUE' => 'DATE' )); //, 19, 30, 00 );
					$e->setProperty( 'dtend' , $theYear, $sm, $sd+1,array( 'VALUE' => 'DATE' )); //, 19, 30, 00 );
				} else {
					$e->setProperty( 'dtstart', $theYear, $sm, $sd,$sth,$stm,$sts);

					$end_query =  "SELECT	*
									FROM	event_end
									WHERE	PK_endID = $endid";
					$end_result = mysql_query ($end_query);
					if ($end_result) {
						$row = mysql_fetch_array($end_result);

						$eyear = $row['end_year'];
						$sd = $row['end_date_num'];
						$sm = $row['end_month_num'];
						$st = $row['end_time'];
						$sth = $st[0].$st[1];
						$stm = $st[3].$st[4];
						$sts = $st[6].$st[7];
						$st_ap = $row['end_AmPm'];
						switch ($st_ap) {
							case "a.m.":
								break;
							case "p.m.":
								if ($sth!=12) $sth=$sth+12;
								break;
						}
						$e->setProperty( 'dtend', $eyear, $sm, $sd,$sth,$stm,$sts);

					}
				}
//				$e->setProperty( 'duration',0, 0, 3 );                    // 3 hours
				$e->setProperty( 'summary', $title);
				$e->setProperty( 'location', $location);
//				$e->setProperty( 'location', 'Home' );

/*				$a = new valarm();                             // initiate ALARM
				$a->setProperty( 'action', 'DISPLAY' );                  // set what to do
				$a->setProperty( 'description', 'Buy X-mas gifts' );          // describe alarm
				$a->setProperty( 'trigger', array( 'week' => 1 ));        // set trigger one week before
				$e->setComponent( $a );                        // add alarm component to event component as subcomponent
*/
				$c->setComponent( $e );                        // add event component to calendar
			}
		}
	}
}

?>
