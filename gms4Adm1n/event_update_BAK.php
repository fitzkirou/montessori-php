<?php
	/*
	** Project: WEBadmin - Guelph Montessori School
	** Version: 1.0
	** File: event_add.php
	** Purpose: Takes user input and inserts an upcoming date record into the database.
	** Author: Bob Young, May 2003.
	*/
	
	/* **************************************************************************
	** Mainline Logic
	** **************************************************************************
	*/
	include("includes/library.php"); //Include shared modules.
	$isViewAllLinked = true; //Define global variables.
	$process = "Edit";
	$item = "upcoming date";
	$action = "event_update.php";
	
	//GET var. passed via the "Edit" link on event_main.php, then via POST
	$thisEventID = $_REQUEST['PK_eventID'];
	
	prepare($isViewAllLinked,$process,$item,$action);
	
	//For checking the time field, client-side.
	echo("<script>");
	include("includes/validation.js");
	echo("</script>");
	
	// process the form only if the submit button has been clicked
	if (isset($_POST['submit']))
	{
		// Get the related start- and end-of-event IDs.
		$record_result = findRecord($thisEventID);
		while ($eventRow = mysql_fetch_array ($record_result))
		{
			$REL_startID = $eventRow['REL_startID'];
			$REL_endID = $eventRow['REL_endID'];
		}
		//Build the update.
		updateStart ($REL_startID);
		updateEnd ($REL_endID);
		updateEvent ();
		//Show changes to user.
		showConfirmation ($PK_eventID);
	}
	// Otherwise, find the record (passed by GET-string from event_main.php) 
	// and populate the form fields.
	else
	{
		$record_result = findRecord($thisEventID);
		//assign query result to variables
		while ( $row = mysql_fetch_array($record_result) )
		{
			$PK_eventID = $row['PK_eventID'];
			$title = $row['title'];
			$REL_startID = $row['REL_startID'];
			$REL_endID = $row['REL_endID'];
			$location = $row['location'];
			$isActive = $row['isActive'];
			$isDifferentEnd = $row['isDifferentEnd'];
			$code = $row['code'];
			$type = $row['type'];
		}
		include("includes/fields_events.php");
	}
	finishUp();


	/* **************************************************************************
	** Module definitions
	** **************************************************************************
	*/
	/*
	** Update the posted event-start values to the 'event_start' table.
	*/
	function updateStart($REL_startID)
	{
		// Modified 2005-11-02, RY.
		// Assign temp. var's from the $_POST array for brevity.
		$start_date_num = $_POST['start_date_num'];
		$start_time = $_POST['start_time'];
		$start_AmPm = $_POST['start_AmPm'];
		$start_month_num = $_POST['start_month_num'];
		$start_year = $_POST['start_year'];
		
		// Add the event-start field values into the 'event_start' table.
		$event_start_query = "	UPDATE	event_start 
								SET		start_date_num	= $start_date_num, 
										start_time		= '$start_time', 
										start_AmPm		= '$start_AmPm', 
										start_month_num	= $start_month_num, 
										start_year		= '$start_year' 
								WHERE	PK_startID		= " . $REL_startID;
		$event_start_result = mysql_query($event_start_query);
		if(!$event_start_result)
		{
			echo("<p class=\error\">There is a problem with the UPDATE query named 'event_start_query.'</p>");
		}
	}
	
	/*
	** Update the posted event-end values to the 'event_end' table.
	*/
	function updateEnd($REL_endID)
	{
		// Modified 2005-11-02, RY.
		// Assign temp. var's from the $_POST array for brevity.
		$start_date_num = $_POST['start_date_num'];
		$start_time = $_POST['start_time'];
		$start_AmPm = $_POST['start_AmPm'];
		$start_month_num = $_POST['start_month_num'];
		$start_year = $_POST['start_year'];
		
		$end_date_num = $_POST['end_date_num'];
		$end_time = $_POST['end_time'];
		$end_AmPm = $_POST['end_AmPm'];
		$end_month_num = $_POST['end_month_num'];
		$end_year = $_POST['end_year'];
		$isDifferentEnd = $_POST['isDifferentEnd'];
		
		// If $isDifferentEnd == "no", make the end-of-event form variables same as the start ones.
		if($isDifferentEnd == "no")
		{
			$end_date_num = $start_date_num;
			$end_time = $start_time;
			$end_AmPm = $start_AmPm;
			$end_month_num = $start_month_num;
			$end_year = $start_year;
		}
		
		// Add the event-end field values into the 'event_end' table.
		$event_end_query = "	UPDATE	event_end 
								SET		end_date_num	= $end_date_num, 
										end_time		= '$end_time', 
										end_AmPm		= '$end_AmPm', 
										end_month_num	= $end_month_num, 
										end_year		= '$end_year' 
								WHERE	PK_endID		= " . $REL_endID;
								
		$event_end_result = mysql_query($event_end_query);
		
		if (! $event_end_result)
			echo("<p class=\error\">There is a problem with the UPDATE query named 'event_end_query.'</p>");
	}
	
	/*
	** Update the row for this PK_eventID in the 'event' table.
	*/
	function updateEvent ()
	{
		// reference the global variables.
		global $isViewAllLinked, $process, $item, $action;
		
		// These globals are from the posted form:
		$PK_eventID = $_POST['PK_eventID'];
		$title = $_POST['title'];
		$location = $_POST['location'];
		$isActive = $_POST['isActive'];
		$isDifferentEnd = $_POST['isDifferentEnd'];
		$code = $_POST['code'];
		// There's no 'type' form-field, so we have to get it from an array.
		$type = getTypeFromCode ($code);
		
		// Get the related start- and end-IDs for this event record.
		$relatedIDs_query = "	SELECT	REL_startID, REL_endID
								FROM	event
								WHERE	PK_eventID = " . $PK_eventID;
		$relatedIDs_result = mysql_query($relatedIDs_query);
		
		if ($relatedIDs_result)
		{
			if($row = mysql_fetch_array($relatedIDs_result))
			{
				$REL_startID = $row['REL_startID'];
				$REL_endID = $row['REL_endID'];
				// update this record with the posted values.
				$update_query = "	UPDATE	event 
									SET		title			= '$title', 
											REL_startID 	= $REL_startID, 
											REL_endID		= $REL_endID, 
											location		= '$location', 
											isActive		= '$isActive', 
											isDifferentEnd	= '$isDifferentEnd', 
											code			= '$code', 
											type			= '$type'
									WHERE	PK_eventID = " .  $PK_eventID;
				$update_result = mysql_query($update_query);
				if(!$update_result)
				{
					echo('There\'s a problem with $update_query.');
				}
			}
			else
			{
				echo('<p class=\"error\">Error: The function mysql_fetch_array($relatedIDs_result) returned no rows.</p>');
			}
		}
		else
		{
			echo("<p class=\"error\">The update for this school event failed due to a system error!</p>");
		}
	}
?>
