<?php
	/*
	** Project: WEBadmin - Guelph Montessori School
	** Version: 1.0
	** File: news_main.php
	** Purpose: Lists all active and inactive news items in the database.
	** Author: Bob Young, June 2003.
	*/

	/* **************************************************************************
	** Mainline Logic
	** **************************************************************************
	*/
	//Include shared modules.
	include ("includes/library.php");

	//Define global variables.
	$isViewAllLinked = false;
	$process = "View all";
	$item = "upcoming date";
	$action = "event_add.php"; //this is the linkfile too
	
	//Connect DB, write the HTML header & subnavigation
	prepare ($isViewAllLinked,$process,$item,$action);
	
	//Main program
	include ("includes/form_start.php");
	showActiveItems ();
	showInactiveItems ();
	include ("includes/form_end.php");
	
	//Close DB connection, close off HTML
	finishUp();


	/* **************************************************************************
	** Module definitions
	** **************************************************************************
	*/
	function setUpDataTable ($rowsReturned, $subhead)
	{
		//Open a row as per file form_start.php.
		echo("<tr><td class=\"feedback\" colspan=\"2\">\n\n");
		//Subtable of summary data begins.
		echo("<br><table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\n");
		//Show a subheading.
		echo("<tr>\n");
		echo("\t<td class=\"subtitle\" colspan=\"4\">" . $subhead . "</td>\n");
		echo("</tr>\n");
		//Header row
		if($rowsReturned > 0)
		{
			echo("<tr>\n");
			echo("\t<th>Event</th>\n");
			echo("\t<th>Start Date</th>\n");
			echo("\t<th>&nbsp;</th>\n");
			echo("\t<th>&nbsp;</th>\n");
			echo("</tr>\n\n");
		}
	}
	
	function showRecords($eventStatus_result,$rowsReturned)
	{
		//Only show results if we've got some rows.
		if($rowsReturned > 0)
		{
			while ($row = mysql_fetch_array ($eventStatus_result))
			{
				echo("<tr>\n");
				// Say "No title" if the title-field's value is a null string.
				if ($row['title'] == "")
				{
					echo("\t<td valign=\"top\" width=\"50%\" class=\"dataRow\" style=\"color:#CC0000\"><b>(No title.)</b></td>\n");
				}
				else
				{
					echo("\t<td valign=\"top\" width=\"50%\" class=\"dataRow\">" . $row['title'] . "</td>\n");
				}
				echo("\t<td valign=\"top\" width=\"25%\" class=\"dataRow\">" . getStartEndMonth($row['start_month_num']) . " " . $row['start_date_num'] . ", " . $row['start_year'] . "</td>\n");
				echo("\t<td valign=\"top\" width=\"10%\" class=\"dataRow\"><a class=\"form\" href=\"event_update.php?PK_eventID=" . $row['PK_eventID'] . "\">Edit</a></td>\n");
				echo("\t<td valign=\"top\" width=\"15%\" class=\"dataRow\"><a class=\"form\" href=\"event_delete.php?PK_eventID=" . $row['PK_eventID'] . "\">Delete</a></td>\n");
				echo("</tr>\n");
			}
		}
		//Otherwise say we've got no results.
		else
		{
			echo("<tr>\n");
			echo("\t<td colspan=\"4\" class=\"feedback\">Currently, there are no records of this type in the database.</td>\n");
			echo("</tr>\n");
		}
	}
	
	function endDataTable()
	{
		echo("</table>\n\n");
		//Close the table and form.
		echo("</td></tr>\n");
	}
	
	function showActiveItems()
	{
		//Find the events whose isActive field is flagged 'yes'.
		$eventStatus_query = "	SELECT		e.title, 
											e.PK_eventID, 
											s.start_month_num, 
											s.start_date_num,
											s.start_year 
								FROM		event		AS e, 
											event_start AS s 
								WHERE 		s.PK_startID = e.REL_startID 
								AND			isActive='yes'
								ORDER BY	s.start_year, s.start_month_num, s.start_date_num ";
		$eventStatus_result = mysql_query($eventStatus_query);
		$rowsReturned = mysql_num_rows($eventStatus_result);
		// Output the upcoming dates...
		if($eventStatus_result)
		{			
			setUpDataTable($rowsReturned,"Show on homepage<br>and current newsletter");
			showRecords($eventStatus_result,$rowsReturned);
			endDataTable();
		}
		// ...or an error on query failure.
		else
		{
			echo("<br><br><p class=\"error\">Error " . $process . "ing" . $item . ": " . mysql_error() . "</p>\n");
		}
	}
	
	function showInactiveItems()
	{
		//Find the events whose isActive field is flagged 'no'.
		$eventStatus_query = "	SELECT		e.title, 
											e.PK_eventID, 
											s.start_month_num, 
											s.start_date_num,
											s.start_year 
								FROM		event		AS e, 
											event_start AS s 
								WHERE 		s.PK_startID = e.REL_startID 
								AND			isActive='no'
								ORDER BY	s.start_year, s.start_month_num, s.start_date_num ";
		$eventStatus_result = mysql_query($eventStatus_query);
		$rowsReturned = mysql_num_rows($eventStatus_result);
		// Output the upcoming dates...
		if($eventStatus_result)
		{
			setUpDataTable ($rowsReturned, "Do NOT show on homepage<br>or current newsletter");
			showRecords ($eventStatus_result, $rowsReturned);
			endDataTable ();
		}
		// ...or an error on query failure.
		else
		{
			echo ("<br><br><p class=\"error\">Error " . $process . "ing" . $item . ": " . mysql_error() . "</p>\n");
		}
	}
?>
