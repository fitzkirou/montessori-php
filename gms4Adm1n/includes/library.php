<?php 
/*
** Project: WEBadmin - Guelph Montessori School
** Version: 1.0
** File: includes/library.php
** Description: Reusable modules for the Guelph Montessori BACK-END
** Author: Bob Young, June 2003.
*/

/*
** Show subnavigation, immediately above the input form.
*/
function showFormNav ($isViewAllLinked,$process,$item,$linkFile)
{
	echo ("<br><br><div>");
	// Toggle what is hyperlinked, depending on context.
	if($item != "Help")
	{
		if($isViewAllLinked)
		{
			// Point the link to the correct master page.
			if($item == "news item")
			{
				echo("<a href=\"news_main.php\">View all " . $item . "s</a>");
			}
			else if($item == "upcoming date")
			{
				echo("<a href=\"event_main.php\">View all " . $item . "s</a>");
			}
			else if($item == "quotation")
			{
				echo("<a href=\"quotation_main.php\">View all " . $item . "s</a>");
			}
		}
		else
		{
			//Handle the indefinite article preceding $item.
			if($item == "upcoming date")
			{
				echo("<a href=\"" . $linkFile . "\">Add " . $item . "</a>&nbsp;");
				// echo ("<a href=\"" . $linkFile . "\">Advance all " . $item . "s</a>");
			}
			//Now link for the "Update Fees" form.
			elseif ($item == 'tuition &amp; fee')
			{
				// Show nothing!
			}
			else
			{
				echo("<a href=\"" . $linkFile . "\">Add " . $item . "</a>");
			}
		}
		echo ("</div><br>");
	}
}


function prepare ($isViewAllLinked, $process, $item, $action)
{
	// DEV. NOTE: DELETE NEXT LINE?
	//global $isViewAllLinked, $process, $item, $action;
	
	// Connect to MySQL server.
	include("../../config.php");
	$dbh = @mysql_connect ($host, $username, $password) 
		or die ( '<p style="color:red;"><b style="color:black;">Guelph Montessori School</b><br><br>There\'s a problem connecting to the Guelph Montessori database.<br>Please contact the School\'s <a href="mailto:bobyoung@sgci.com">webmaster.</a></p>');
	// Select the database to use.
	mysql_select_db ($database);
	
	// Start Html and show header graphic/menu.
	include("includes/header.php");
	
	showFormNav ($isViewAllLinked,$process,$item,$action);
}


function finishUp()
{
	mysql_close();
	include ("includes/footer.php");
}

function getIsDifferentEnd($thisEventID)
{
	// First get the value of 'isDifferentEnd' field for this record.
	$different_query = "SELECT	isDifferentEnd 
						FROM	event
						WHERE	PK_eventID = '$thisEventID' ";
	$different_result = mysql_query($different_query);
	if(!$different_result)
	{
		echo("There's a problem with query named 'different_result'.");
	}
	// Next assign the value of the isDifferentEnd field to a variable.
	if($different_row = mysql_fetch_array($different_result))
	{
		$isDifferentEnd = $different_row['isDifferentEnd'];
		return($isDifferentEnd);
	}
	else
	{
		echo('There were no rows returned within the function "getIsDifferentEnd()".');
		return;
	}
}

function getMonthName($REL_monthID)
{
	if ($REL_monthID==1) {
		return("January");
	}
	elseif ($REL_monthID==2) {
		return("February");
	}
	elseif ($REL_monthID==3) {
		return("March");
	}
	elseif ($REL_monthID==4) {
		return("April");
	}
	elseif ($REL_monthID==5) {
		return("May");
	}
	elseif ($REL_monthID==6) {
		return("June");
	}
	elseif ($REL_monthID==7) {
		return("July");
	}
	elseif ($REL_monthID==8) {
		return("August");
	}
	elseif ($REL_monthID==9) {
		return("September");
	}
	elseif ($REL_monthID==10) {
		return("October");
	}
	elseif ($REL_monthID==11) {
		return("November");
	}
	else {
		return("December");
	}
}

/*
** This is used for the $start_month_num and $end_month_num variables;
** converts to a month name.
*/
function getStartEndMonth($monthNum)
{
	if ($monthNum==1) {
		return("January");
	}
	elseif ($monthNum==2) {
		return("February");
	}
	elseif ($monthNum==3) {
		return("March");
	}
	elseif ($monthNum==4) {
		return("April");
	}
	elseif ($monthNum==5) {
		return("May");
	}
	elseif ($monthNum==6) {
		return("June");
	}
	elseif ($monthNum==7) {
		return("July");
	}
	elseif ($monthNum==8) {
		return("August");
	}
	elseif ($monthNum==9) {
		return("September");
	}
	elseif ($monthNum==10) {
		return("October");
	}
	elseif ($monthNum==11) {
		return("November");
	}
	else {
		return("December");
	}
}

	/* *******************************************************************
	** FOLLOWING FUNCTIONS ARE USED BY THE FILES event_add.php, 
	** event_update.php., and  event_delete.php.
	** *******************************************************************
	*/
	
	/*
	** Show a confirmation of the $process-ed upcoming date.
	** This should work for adding, deleing, and updating events.
	*/
	function showConfirmation ($PK_eventID)
	{
		global $item, $process;
		//Get fields from latest PK_eventID in table 'event'.
		$updatedEvent_query = "	SELECT	* 
								FROM	event 
								WHERE	PK_eventID = '$PK_eventID' ";
		$updatedEvent_result = mysql_query($updatedEvent_query);
		//Open the table and form.
		include("includes/form_start.php");
		//Open table-row wrapper.
		echo("<tr class=\"feedback\" valign=\"top\">\n");
		echo("<td class=\"feedback\" colspan=\"2\ valign=\"top\">\n");
		//Set up the confirmation content.
		echo("<div class=\"feedback\">\n");
		//Control for conjugation of verbs (-ed versus -d suffix on past participle).
		if(($process == "Add") OR ($process == "Edit"))
		{
			echo("<br><p class=\"warning\">Your " . $item . " was " . strtolower($process) . "ed sucessfully!</p></div><br>");
		}
		else
		{
			echo("<br><p class=\"warning\">Your " . $item . " was " . strtolower($process) . "d sucessfully!</p></div><br>");
		}
		// Show a confirmation of entered data...
		if ($updatedEvent_result)
		{
			if ($row = mysql_fetch_array($updatedEvent_result))
			{
				echo("<p class=\"feedback\"><em>Here it is what you entered:</em></p><br><br>\n");
				echo("<span class=\"eventTitle\">" . $row['title'] . "</span><br>\n");
				showDateTime ($row);
				showLocation ($row);
				echo("<p class=\"feedback\">Event Type: <b>" . $row['type'] . "</b></p>\n");
				echo("<p class=\"feedback\">Show on Website: <b>" . $row['isActive'] . "</b></p>\n");
				echo("</div>\n");
			}
		}
		// ...or an error.
		else
		{
			echo("<br><br><p class=\"error\">There was an error updating this event: " . mysql_error() . "</p>\n");
		}
		//Show 'OK' (back) button.
		echo("&nbsp;&nbsp;<input type=\"button\" name=\"goBack\" value=\" OK \" onclick=\"window.location.href='event_main.php';\"><br><br>");
		//Close table-row wrapper.
		echo("</td></tr>\n");
		//Close the table and form.
		include("includes/form_end.php");
	}
	
	/*
	** Find the record that's been passed via a GET variable.
	*/
	function findRecord($thisID)
	{
		global $item;
		//Query to find result for this event record.
		if($item == "upcoming date")
		{
			$record_query = "	SELECT 	*
								FROM 	event
								WHERE	PK_eventID = '$thisID' ";
			$record_result = mysql_query($record_query);
		}
		//Query to find result for this news item record.
		else if($item == "news item")
		{
			$record_query = "	SELECT 	*
								FROM 	news_item
								WHERE	PK_newsID = '$thisID' ";
			$record_result = mysql_query($record_query);
		}
		//Pass query result back.
		if(!$record_result)
		{
			echo("Error in the query named '$record_query'.");
			return;
		}
		else
		{
			return($record_result);
		}
	}
	
	/*
	** Show the event's start (and possible end) date-time values.
	*/
	function showDateTime($row)
	{
		//Get this event's start- and end- values from the related tables.
		list($start_month_num, $start_date_num, $start_time, $start_year) = getStartFields($row);
		list($end_month_num, $end_date_num, $end_time, $end_year) = getEndFields($row);
		
		//Open div tag.
		echo("<div class=\"feedback\">");
		
		
		/* -------------------------------------------------------------------
		** Select among four possible cases of start- vs. end-of-event values:
		------------------------------------------------------------------- */
		
		//(1) Start- and end-of-event are identical, so don't show any end values.
		if(	($start_date_num == $end_date_num) 
			AND ($start_month_num == $end_month_num) 
			AND ($start_time == $end_time) )
		{
			showNoEndData($start_month_num, $start_date_num, $start_time, $start_year);
		}
		
		//(2) Both months and dates are identical, but the start- and end-times are different.
		else if( ($start_date_num == $end_date_num) 
				AND ($start_month_num == $end_month_num) 
				AND ($start_time != $end_time) )
		{
			appendEndTime($start_date_num, $start_month_num, $start_time, $start_year, $end_time);
		}
		
		//(3) Months, dates, and years are different (or dates and years the same).
		else if( (($start_date_num != $end_date_num) OR ($start_date_num == $end_date_num)) 
				AND ($start_month_num != $end_month_num) 
				AND (($start_year != $end_year) OR ($start_year == $end_year)) )
		{
			showBothDates($start_date_num, $start_month_num, $start_year, $end_date_num, $end_month_num, $end_year);
		}
		
		//(4) Start- and end-months differ, OR they're identical but with different dates; so, show everything.
		else if( ($start_month_num != $end_month_num) 
			OR (($start_month_num == $end_month_num)AND($start_date_num != $end_date_num)) )
		{
			showStartAndEnd($start_month_num, $start_date_num, $start_time, $start_year, $end_month_num, $end_date_num, $end_time, $end_year);
		}
		
		//default case
		else
		{
			showStartAndEnd($start_month_num, $start_date_num, $start_time, $start_year, $end_month_num, $end_date_num, $end_time, $end_year);
		}
		
		//Close div tag.
		echo("</div>");
	}
	
	/*
	** Get the "start" field values from the related record in table 'event_start'.
	*/
	function getStartFields ($row)
	{
		$REL_startID = $row['REL_startID'];
		$start_query = "	SELECT	* 
							FROM	event_start 
							WHERE	PK_startID = '$REL_startID' ";
		$start_result = mysql_query ($start_query);
		if(!$start_result)
		{
			echo("<p class=\error\">There is a problem with the SELECT query named 'start_query.'</p>");
			exit();
		}
		else
		{
			if ($start_row = mysql_fetch_array($start_result))
			{
				//Assign variables to this record's fields in table 'event_start'.
				$start_month_num = $start_row['start_month_num'];
				$start_date_num = $start_row['start_date_num'];
				//Lop the seconds off the time string.
				$start_HHMM = substr ($start_row['start_time'],0,5);
				//Lop off the first zero of single-digit hours (e.g., 03:00 p.m.).
				$first_digit = substr ($start_HHMM, 0, 1);
				// If the time is OTHER THAN 10:xx or 11:xx, call function to
				// lop off the first digit. This test is necessary before the
				// function call; otherwise, lopOffFirstDigit() returns NULL
				// for 10:xx and 11:xx!
				if ($first_digit != "1")
				{
					$start_HHMM = lopOffFirstDigit ($start_HHMM);
				}
				//Concatenate the start-time and AmPm values (for use below.)
				$start_time = ($start_HHMM . " " . $start_row['start_AmPm']);
				$start_year = $start_row['start_year'];
			}
		}
		return array ($start_month_num, $start_date_num, $start_time, $start_year);
	}
	
	/*
	** Get the "end" field values from the related record in table 'event_start'.
	*/
	function getEndFields($row)
	{
		$REL_endID = $row['REL_endID'];
		$end_query = "	SELECT	* 
						FROM	event_end 
						WHERE	PK_endID = '$REL_endID' ";
		$end_result = mysql_query($end_query);
		if(!$end_result)
		{
			echo("<p class=\error\">There is a problem with the SELECT query named 'end_query.'</p>");
			exit();
		}
		else
		{
			if($end_row = mysql_fetch_array($end_result))
			{
				//Assign variables to this record's fields in table 'event_end'.
				$end_month_num = $end_row['end_month_num'];
				$end_date_num = $end_row['end_date_num'];				
				//Lop the seconds off the time string.
				$end_HHMM = substr($end_row['end_time'],0,5);
				
				//Lop off the first zero of single-digit hours (e.g., 03:00 p.m.).
				$first_digit = substr ($end_HHMM, 0, 1);
				// If the time is OTHER THAN 10:xx or 11:xx, call function to
				// lop off the first digit. This test is necessary before the
				// function call; otherwise, lopOffFirstDigit() returns NULL
				// for 10:xx and 11:xx!
				if ($first_digit != "1")
				{
					$end_HHMM = lopOffFirstDigit ($end_HHMM);
				}
				
				//Concatenate the end-time and AmPm values (for use below.)
				$end_time = ($end_HHMM . " " . $end_row['end_AmPm']);
				$end_year = $end_row['end_year'];
			}
		}
		return array($end_month_num, $end_date_num, $end_time, $end_year);
	}
	
	/*
	** //Lop off the redundant preceding zero of single-digit hours (e.g., 03:00 p.m.).
	*/
	function lopOffFirstDigit ($time)
	{
		$first_digit = substr ($time, 0, 1);
		if ($first_digit == "0")
		{
			//Redefine var $time to start at 2nd character (position 1).
			$time = substr ($time, 1);
			return ($time);
		}
	}
	
	/*
	** Show just the start-of-event data.
	*/
	function showNoEndData($start_month_num, $start_date_num, $start_time, $start_year)
	{
		// Use PHP mktime() and date() built-in functions to get day name.
		$start_day = getDayName ($start_month_num, $start_date_num, $start_year);
		
		// If the $start_time was not entered, the database records "00:00" 
		// (now 0:00). So, don't show an end-time in this case; otherwise, do.
		if(($start_time == "0:00 a.m.") OR ($start_time == "0:00 p.m."))
		{
			echo($start_day . ", " . getStartEndMonth($start_month_num) . " " . $start_date_num . ", " . $start_year . "<br>");
		}
		else
		{
			echo($start_day . ", " . getStartEndMonth($start_month_num) . " " . $start_date_num . ", " . $start_year . ", at " . $start_time . "<br>");
		}
	}
	
	/*
	** Just show the end-time appended to the full start-of-event data.
	*/
	function appendEndTime($start_date_num, $start_month_num, $start_time, $start_year, $end_time)
	{
		// Use PHP mktime() and date() built-in functions to get day name.
		$start_day = getDayName ($start_month_num, $start_date_num, $start_year);
		
		//If the $end_time was not entered, the database records "00:00" (now 0:00); control for this.
		//NOTE: last two 'OR' clauses are a hack to deal with an apparent zero-length string -- when $end_time should be '0:00'
		if(($end_time=="0:00 a.m.") OR ($end_time=="0:00 p.m.") OR ($end_time==" a.m.") OR ($end_time==" p.m."))
		{
			echo($start_day . ", " . getStartEndMonth($start_month_num) . " " . $start_date_num . ", " . $start_year . ", at " . $start_time . "<br>");
		}
		else
		{
			echo($start_day . ", " . getStartEndMonth($start_month_num) . " " . $start_date_num . ", " . $start_year . ", at " . $start_time . " &ndash; " . $end_time . "<br>");
		}
	}
	
	/*
	** Show full start date and end date -- no times. 
	*/
	function showBothDates($start_date_num, $start_month_num, $start_year, $end_date_num, $end_month_num, $end_year)
	{
		// Use PHP mktime() and date() built-in functions to get day names.
		$start_day = getDayName ($start_month_num, $start_date_num, $start_year);
		$end_day = getDayName ($end_month_num, $end_date_num, $end_year);
	
		echo($start_day . ", " . getStartEndMonth($start_month_num) . " " . $start_date_num . ", " . $start_year . " &ndash; ");
		echo($end_day . ", " . getStartEndMonth($end_month_num) . " " . $end_date_num . ", " . $end_year . "<br>");
	}
	
	/*
	** Show both start- and end-of-event data, but omit time if user left it blank.
	*/
	function showStartAndEnd($start_month_num, $start_date_num, $start_time, $start_year, $end_month_num, $end_date_num, $end_time, $end_year)
	{
		// Use PHP mktime() and date() built-in functions to get day names.
		$start_day = getDayName ($start_month_num, $start_date_num, $start_year);
		$end_day = getDayName ($end_month_num, $end_date_num, $end_year);
	
		//If the $start_time was not entered, the database records "00:00" (now 0:00); control for this.
		if(($start_time=="0:00 a.m.") OR ($start_time=="0:00 p.m."))
		{
			echo($start_day . ", " . getStartEndMonth($start_month_num) . " " . $start_date_num . ", " . $start_year . " &ndash; "); //append a dash
		}
		else
		{
			echo($start_day . ", " . getStartEndMonth($start_month_num) . " " . $start_date_num . ", " . $start_year . ", at " . $start_time . " &ndash; ");
		}
		//If the $end_time was not entered, the database records "00:00" (now 0:00); control for this.
		if(($end_time=="0:00 a.m.") OR ($end_time=="0:00 p.m."))
		{
			echo($end_day . ", " . getStartEndMonth($end_month_num) . " " . $end_date_num . ", " . $start_year . "<br>");
		}
		else
		{
			echo($end_day . ", " . getStartEndMonth($end_month_num) . " " . $end_date_num . ", " . $start_year . ", at " . $end_time . "<br>");
		}
	}
	
	/*
	** Determine the day-name that corresponds to the parameters; 
	** use PHP mktime() and date() built-in functions to get day name.
	*/
	function getDayName ($month_num, $date_num, $year)
	{
		$time_stamp = mktime (0, 0, 0, $month_num, $date_num, $year);
		$dayName = date ("l", $time_stamp);
		return ($dayName);
	}
	
	/*
	** IF there's a location value for this event record, show that value.
	*/
	function showLocation($row)
	{
		if($row['location'] != "")
		{
			echo("<div class=\"feedback\">");
			echo("<span style=\"font-style:italic;\">" . $row['location'] . "</span><br>\n");
			echo("</div>");
		}
	}
	
	/*
	** There's no 'type' form-field, so we have to get it from an array.
	*/
	function getTypeFromCode ($passedCode)
	{
		// Create array.
		$typesList = array ("D" => "Designated Holiday",
							 "E" => "School Event",
							 "H" => "Statutory Holiday",
							 "P" => "Professional Development Day");
		// Find the type that corresponds to $eventCode in the array.
		foreach ($typesList AS $arrayCode => $arrayType)
		{
			// Return the matching type on success.
			if ($arrayCode == $passedCode)
			{
				$theType = $arrayType;
				return ($theType);
			}
		}
	}
	
	/*
	** Build string for a fee amount.
	*/
	function showFee($feeName)
	{
		// Get record in db.
		$qryFee = "SELECT amount FROM fee WHERE fee_name = '" . $feeName . "'";
		$result = mysql_query($qryFee);
		if ($row = mysql_fetch_array($result)) {
			$theFee = $row['amount'];
		} else {
			die('ERROR: Due to a system error, our academic fees cannot be shown.');
		}
			
		// Do currency format. NOTE: '%n' argumnet is for 'national' currency symbol.
		setlocale(LC_MONETARY, 'en_US');
		$theFee = money_format('%n', $theFee) . "\n";
		
		return $theFee;
	}	
?>