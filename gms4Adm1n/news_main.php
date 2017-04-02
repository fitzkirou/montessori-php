<?php
	/*
	** Project: WEBadmin - Guelph Montessori School
	** Version: 1.0
	** File: news_main.php
	** Purpose: Lists all active and inactive news items in the database.
	** Author: Bob Young, June 2003.
	*/
	error_reporting(E_ALL);
	/* **************************************************************************
	** Mainline Logic
	** **************************************************************************
	*/
	//Include shared modules.
	include("includes/library.php");
	//Define global variables.
	$isViewAllLinked = false;
	$process = "View all";
	$item = "news item";
	$action = "news_add.php"; //this is the linkfile too
	
	//Connect DB, write the HTML header & subnavigation
	prepare($isViewAllLinked,$process,$item,$action);
	//Main program
	include("includes/form_start.php");
	showActiveItems();
	showInactiveItems();
	include("includes/form_end.php");
	//Close DB connection, close off HTML
	finishUp();

	/* **************************************************************************
	** Module definitions
	** **************************************************************************
	*/
	function setUpDataTable($rowsReturned,$subhead)
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
			echo("\t<th>Title</th>\n");
			echo("\t<th>Critical Date</th>\n");
			echo("\t<th>&nbsp;</th>\n");
			echo("\t<th>&nbsp;</th>\n");
			echo("</tr>\n\n");
		}
	}
	
	function showRecords($itemStatus_result,$rowsReturned)
	{
		//Only show results if we've got some rows.
		if($rowsReturned > 0)
		{
			while ( $row = mysql_fetch_array($itemStatus_result) )
			{
				echo("<tr>\n");
				echo("\t<td width=\"50%\" class=\"dataRow\">" . $row['title'] . "</td>\n");
				echo("\t<td width=\"25%\" class=\"dataRow\">" . getMonthName($row['REL_monthID']) . " " . $row['REL_dateID'] . ", " . $row['REL_yearID'] . "</td>\n");
				echo("\t<td width=\"10%\" class=\"dataRow\"><a class=\"form\" href=\"news_update.php?PK_newsID=" . $row['PK_newsID'] . "\">Edit</a></td>\n");
				echo("\t<td width=\"15%\" class=\"dataRow\"><a class=\"form\" href=\"news_delete.php?PK_newsID=" . $row['PK_newsID'] . "\">Delete</a></td>\n");
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
		//Find the items whose isActive field is flagged 'yes'.
		$itemStatus_query = "   SELECT * FROM news_item 
								WHERE 		isActive='yes'
								ORDER BY	REL_yearID, REL_monthID, REL_dateID, title ";
		$itemStatus_result = mysql_query($itemStatus_query);
		$rowsReturned = mysql_num_rows($itemStatus_result);
		// Output the news items...
		if($itemStatus_result)
		{
			setUpDataTable($rowsReturned,"Show on homepage<br>and current newsletter");
			showRecords($itemStatus_result,$rowsReturned);
			endDataTable();
		}
		// ...or an error.
		else
		{
			echo("<br><br><p class=\"error\">Error " . $process . "ing" . $item . ": " . mysql_error() . "</p>\n");
		}
	}
	
	function showInactiveItems()
	{
		//Find the items whose isActive field is flagged 'no'.
		$itemStatus_query = "   SELECT * FROM news_item 
								WHERE 		isActive='no'
								ORDER BY	REL_yearID, REL_monthID, REL_dateID, title ";
		$itemStatus_result = mysql_query($itemStatus_query);
		$rowsReturned = mysql_num_rows($itemStatus_result);
		// Output the news items...
		if($itemStatus_result)
		{
			setUpDataTable($rowsReturned,"Do NOT show on homepage<br>or current newsletter");
			showRecords($itemStatus_result,$rowsReturned);
			endDataTable();
			//White space at form's bottom.
			echo("<tr>\n");
			echo("\t<td colspan=\"2\">&nbsp;</td>\n");
			echo("</tr>\n");
		}
		// ...or an error.
		else
		{
			echo("<br><br><p class=\"error\">Error " . $process . "ing" . $item . ": " . mysql_error() . "</p>\n");
		}
	}
?>
