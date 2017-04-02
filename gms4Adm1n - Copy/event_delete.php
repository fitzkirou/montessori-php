<?php
	/*
	** Project: WEBadmin - Guelph Montessori School
	** Version: 1.0
	** File: event_delete.php
	** Purpose: From a passed GET variable, displays the content of an upcoming
	** 			date; buttons will execute deletion or allow user to back out.
	** Author: Bob Young, June 2003.
	*/
	error_reporting(E_ALL);
	/* **************************************************************************
	** Mainline Logic
	** **************************************************************************
	*/
	include("includes/library.php"); //Include shared modules.
	$isViewAllLinked = true; //Define global variables.
	$process = "Delete";
	$item = "upcoming date";
	$action = "event_delete.php";
	
	prepare($isViewAllLinked,$process,$item,$action);
	
	// Delete the item on submit; otherwise just show a delete form.
	if (isset($_POST['submit'])) {
		// Get the related start- and end-of-event IDs.
		$record_result = findRecord($_POST['PK_eventID']);
		if($eventRow = mysql_fetch_array($record_result))
		{
			$REL_startID = $eventRow['REL_startID'];
			$REL_endID = $eventRow['REL_endID'];
		}
		//Proceed to delete the two related records, then this event record.
		$dateTimeIDs = array(	"REL_startID"=>$REL_startID,
								"REL_endID"=>$REL_endID);
		deleteDateTimeRecords($dateTimeIDs);
		deleteEvent($_POST['PK_eventID']);
		//Show changes to user.
		showConfirmation($_POST['PK_eventID']);
	}
	else
	{
		showDeleteForm($_GET['PK_eventID']);
	}
	
	finishUp();

	/* **************************************************************************
	** Module definitions
	** **************************************************************************
	*/
	
	function showDeleteForm($passed_eventID)
	{
		global $isViewAllLinked, $process, $item, $action;
		// Put this upcoming date's field values into an SQL query result.
		$event_result = findRecord($passed_eventID);
		// Display the full content to the user.
		if($row = mysql_fetch_array($event_result))
		{
			//Open the table and form.
			include("includes/form_start.php");
			//Open table-row wrapper.
			echo("\t<tr class=\"feedback\" valign=\"top\">\n");
			echo("\t<td class=\"feedback\" colspan=\"2\>\n");
			//Print confirmation content.
			echo("\t\t<div class=\"feedback\"><br><br>\n");
			echo("<div class=\"feedback\"><em>Here is the record you're about to delete:</em></div><br><br>\n");
			echo("<span class=\"eventTitle\">" . $row['title'] . "</span><br>\n"); //event title
			showDateTime($row); //event start and end date-time(s)
			showLocation($row); //event location
			echo("\t\t</div class=\"feedback\"><br><br><br>\n");
			//Give warning message.
			echo("\t\t\t<div class=\"warning\">Are you sure you want to delete the " . $item . " above?</div>\n");
			//Put $id in a hidden field.
			echo("<input type=\"hidden\" name=\"PK_eventID\" value=\"" . $passed_eventID . "\">");
			//Show buttons.
			echo("\t\t\t&nbsp;&nbsp;&nbsp;<input type=\"submit\" name=\"submit\" value=\"Yes\">&nbsp;\n");
			echo("\t\t\t<input type=\"button\" value=\"No\" onclick=\"window.history.back();\">\n");
			echo("\t\t\t<br><br>");
			echo("\t\t</div>\n");
			//Close table-row wrapper.
			echo("\t</td></tr>\n");
			//Close the table and form.
			include("includes/form_end.php");
		}
	}

	/*
	** Loop to delete the ID-matching records in tables 'event_start' and 'event_end'.
	*/
	function deleteDateTimeRecords($dateTimeIDs)
	{
		foreach($dateTimeIDs as $key=>$value)
		{
			if($key == "REL_startID")
			{
				$start_query = "	DELETE FROM		event_start 
									WHERE 			PK_startID = '$value' ";
				$start_result = mysql_query($start_query);
				if(!$start_result)
				{
					echo('Error in DELETE query named $start_query.');
				}
			}
			else
			{
				$end_query = "	DELETE FROM		event_end 
								WHERE 			PK_endID = '$value' ";
				$end_result = mysql_query($end_query);
				if(!$end_result)
				{
					echo('Error in DELETE query named $end_query.');
				}
			}
		}
	}
	
	/*
	** Delete the main event record.
	*/
	function deleteEvent($PK_eventID)
	{
		//Perform delete query
		$delete_query = "DELETE FROM event 
						 WHERE PK_eventID = '$PK_eventID'";
		$delete_result = mysql_query($delete_query);
		if(!$delete_result)
		{
			echo("<br><br><p class=\"error\">Error in DELETE query: " . mysql_error() . "</p>\n");
		}
	}
?>
