<?php
	/*
	** Project: WEBadmin - Guelph Montessori School
	** Version: 1.0
	** File: event_add.php
	** Purpose: Takes user input and inserts an event record into the database.
	** Author: Bob Young, June 2003.
	*/
	
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
	
	// On submit, insert into the 'event_start' and 'event_end' tables.
	// Then, insert to the 'event' table and show the entered event's record.
	if(isset($_POST['submit']))
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
		// Modified 2005-11-02, RY.
		// Assign temp. var's from the $_POST array for brevity.
		$start_date_num = $_POST['start_date_num'];
		// Control for blank time field.
		if ($_POST['start_time'] == '') {
			$start_time = '00:00:00';
		} else {
			$start_time = $_POST['start_time'];
		}
		$start_AmPm = $_POST['start_AmPm'];
		$start_month_num = $_POST['start_month_num'];
		$start_year = $_POST['start_year'];
		
		// Add the event-start field values into the 'event_start' table.
		$event_start_query = "	INSERT INTO event_start (start_date_num, 
									start_time, start_AmPm, start_month_num, start_year) 
								VALUES ($start_date_num, '$start_time', 
									'$start_AmPm', $start_month_num, '$start_year') ";
		$event_start_result = mysql_query($event_start_query);
		if(! $event_start_result)
		{
			die("<p class=\"error\">Error in query 'event_start_query'. <strong>MySQL parser said:</strong> " . mysql_error() . "</p>");
		}
	}
	
	/*
	** Insert the posted event-end values to the 'event_end' table.
	*/
	function addEnd()
	{
		// Modified 2005-11-02, RY.
		// Assign temp. var's from the $_POST array for brevity.
		$start_date_num = $_POST['start_date_num'];
		// Control for blank time field.
		if ($_POST['start_time'] == '') {
			$start_time = '00:00:00';
		} else {
			$start_time = $_POST['start_time'];
		}
		$start_AmPm = $_POST['start_AmPm'];
		$start_month_num = $_POST['start_month_num'];
		$start_year = $_POST['start_year'];
		
		$end_date_num = $_POST['end_date_num'];
		// Control for blank time field.
		if ($_POST['end_time'] == '') {
			$end_time = '00:00:00';
		} else {
			$end_time = $_POST['end_time'];
		}
		$end_AmPm = $_POST['end_AmPm'];
		$end_month_num = $_POST['end_month_num'];
		$end_year = $_POST['end_year'];
		$isDifferentEnd = $_POST['isDifferentEnd'];
		
		// If $isDifferentEnd == "no", make the end-of-event values same as the start values.
		if($isDifferentEnd == "no")
		{
			$end_date_num = $start_date_num;
			$end_time = $start_time;
			$end_AmPm = $start_AmPm;
			$end_month_num = $start_month_num;
		}
		// Add the event-end field values into the 'event_end' table.
		$event_end_query = "INSERT INTO event_end (end_date_num, end_time, end_AmPm, end_month_num, end_year) 
							VALUES ($end_date_num, '$end_time', '$end_AmPm', $end_month_num, '$end_year')";
		$event_end_result = mysql_query($event_end_query);
		if(!$event_end_result)
		{
			die("<p class=\"error\">Error in query 'event_end_query'. <strong>MySQL parser said:</strong> " . mysql_error() . "</p>");
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
		$title = $_POST['title'];
		$location = $_POST['location'];
		$isActive = $_POST['isActive'];
		$isDifferentEnd = $_POST['isDifferentEnd'];
		$code = $_POST['code'];
		// There's no 'type' form-field, so we have to get it from an array.
		$type = getTypeFromCode ($code);
		
		// Do the insert.
		$add_query = "	INSERT INTO	event (title, REL_startID, REL_endID, 
							location, isActive, isDifferentEnd, code, type)
						VALUES ('$title', $startMaxID, $endMaxID, '$location', 
							'$isActive', '$isDifferentEnd', '$code', '$type')";
		$add_result = mysql_query($add_query);
		if(!$add_result)
		{
			echo("<p class=\error\">The event couldn't be added due to a ");
			echo("system error! Please contact the Guelph Montessori webmaster.</p>");
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
