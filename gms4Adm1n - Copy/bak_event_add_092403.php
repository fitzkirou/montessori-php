<?php
	/*
	** Project: WEBadmin - Guelph Montessori School
	** Version: 1.0
	** File: event_add.php
	** Purpose: Takes user input and inserts an event record into the database.
	** Author: Bob Young, June 2003.
	*/
	
	error_reporting(E_ALL);
	
	/* **************************************************************************
	** Mainline Logic
	** **************************************************************************
	*/
	include("includes/library.php"); //Include shared modules.
	$isViewAllLinked = true; //Define global variables.
	$process = "Add";
	$item = "upcoming date";
	$action = "event_add.php";
	
	// Include header.php, open MySQL connection, 
	// and select the 'guelphm_web' database.
	prepare($isViewAllLinked, $process, $item, $action);
	
	//For checking the time field, client-side.
	echo("<script>");
	include("includes/validation.js");
	echo("</script>");
	
	// On submit, insert to the 'event_start' and 'event_end' tables.
	// Then, insert to the 'event' table and show the entered event record.
	if(isset($submit))
	{
		addStart();
		addEnd();
		list($startMaxId, $endMaxId) = getDateIDs();
		addEvent($startMaxId, $endMaxId);
		$maxEventID = getNewEvent();
		showConfirmation($maxEventID);
	}
	// otherwise, show the input form.
	else
	{
		include("includes/fields_events.php");
	}
	
	// Include footer.php and close the connection to MySQL server.
	finishUp();

	
	
	
	/* **************************************************************************
	** Module definitions
	** *************************************************************************/
	
	/*
	** Insert the posted event-start values to the 'event_start' table.
	*/
	function addStart()
	{
		// Make posted form-field values available to this scope.
		global $start_day, $start_date_num, $start_time, $start_AmPm, $start_month_num, $start_year;
		/*
		** Determine the start day's name.
		$start_day = getDayName ($start_date_num);
		*/
		// Add the event-start field values into the 'event_start' table.
		$event_start_query = "	INSERT INTO event_start (start_day, start_date_num, 
									start_time, start_AmPm, start_month_num, start_year) 
								VALUES ('$start_day', '$start_date_num', '$start_time', 
									'$start_AmPm', '$start_month_num', '$start_year') ";
		$event_start_result = mysql_query($event_start_query);
		if(!$event_start_result)
		{
			echo("<p class=\error\">There is a problem with the INSERT query named 'event_start_query.'</p>");
		}
	}
	
	/*
	** Insert the posted event-end values to the 'event_end' table.
	*/
	function addEnd()
	{
		// Make posted form-field values available to this scope.
		global $start_day, $start_date_num, $start_time, $start_AmPm, $start_month_num, $start_year;
		global $end_day, $end_date_num, $end_time, $end_AmPm, $end_month_num, $end_year;
		global $isDifferentEnd;
		// If $isDifferentEnd == "no", make the end-of-event values same as the start values.
		if($isDifferentEnd == "no")
		{
			$end_day = $start_day;
			$end_date_num = $start_date_num;
			$end_time = $start_time;
			$end_AmPm = $start_AmPm;
			$end_month_num = $start_month_num;
		}
		// Add the event-end field values into the 'event_end' table.
		$event_end_query = "	INSERT INTO event_end (end_day, end_date_num, 
									end_time, end_AmPm, end_month_num, end_year) 
								VALUES ('$end_day', '$end_date_num', '$end_time', 
									'$end_AmPm', '$end_month_num', '$end_year') ";
		$event_end_result = mysql_query($event_end_query);
		if(!$event_end_result)
		{
			echo("<p class=\error\">There is a problem with the INSERT query named 'event_end_query.'</p>");
		}
	}
	
	/*
	** Use SQL 'max' function and return the latest IDs for event start and end.
	*/
	function getDateIDs()
	{
		$max_start_query = "	SELECT	MAX(s.PK_startID)	AS 'startMaxID',
										MAX(e.PK_endID)		AS 'endMaxID' 	
								FROM	event_start AS s,
										event_end	AS e ";
		$max_start_result = mysql_query($max_start_query);
		//Notify user is bad query.
		if(!$max_start_result)
		{
			echo("<p class=\error\">There is a problem with the SELECT query named 'max_start_query'.</p>");
			exit();
		}
		//assign query results to two variables and return them.
		else
		{
			if($row = mysql_fetch_array($max_start_result))
			{
				$startMaxId = $row['startMaxID'];
				$endMaxId = $row['endMaxID'];
				return array($startMaxId, $endMaxId);
			}
		}
	}
	
	/*
	** Insert the posted event fields to the 'event' table.
	*/
	function addEvent($startMaxID, $endMaxID)
	{
		global $isViewAllLinked, $process, $item, $action;
		// Make posted form-field values available to this scope.
		global $title, $location, $isActive, $isDifferentEnd;
		// Do the insert.
		$add_query = "	INSERT INTO	event (title, REL_startID, REL_endID, 
							location, isActive, isDifferentEnd)
						VALUES ('$title', '$startMaxID', '$endMaxID', '$location', 
							'$isActive', '$isDifferentEnd')  ";
		$add_result = mysql_query($add_query);
		if(!$add_result)
		{
			echo("<p class=\error\">There is a problem with the SELECT query named 'add_query.'</p>");
			exit();
		}
	}
	
	/*
	** Use SQL 'max' function and return the latest PK_eventID value.
	*/
	function getNewEvent()
	{
		$newEvent_query = "	SELECT	MAX(PK_eventID) AS 'maxID'
							FROM	event ";
		$newEvent_result = mysql_query($newEvent_query);
		if($newEvent_result)
		{
			if($row = mysql_fetch_array($newEvent_result))
			{
				$newestID = $row['maxID'];
				return($newestID);
			}
		}
		else
		{
			echo("<p class=\error\">There is a problem with the SELECT query named 'newEvent_query.'</p>");
			exit();
		}
	}
?>
