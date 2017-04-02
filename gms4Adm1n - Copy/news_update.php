<?php
	/*
	** Project: WEBadmin - Guelph Montessori School
	** Version: 1.0
	** File: news_add.php
	** Purpose: Takes user input and inserts a news-item record into the database.
	** Author: Bob Young, May 2003.
	*/
	
	/* **************************************************************************
	** Mainline Logic
	** **************************************************************************
	*/
	
	include("includes/library.php"); //Include shared modules.

	$isViewAllLinked = true; //Define global variables.
	$process = "Edit";
	$item = "news item";
	$action = "news_update.php";
	$thisItemID = $_REQUEST['PK_newsID']; //passed via the "Edit" link on news_main.php, then via POST
	
	prepare($isViewAllLinked,$process,$item,$action);
	
	// process the form only if the submit button has been clicked
	if (isset($_POST['submit']))
	{
		updateNewsItem();
	}
	// otherwise find the record and populate the form fields.
	else
	{
		$record_result = findRecord($thisItemID, $item);
		//assign query result to variables
		while($row = mysql_fetch_array($record_result))
		{
			$PK_newsID = $row['PK_newsID'];
			$title = $row['title'];
			$main_text = $row['main_text'];
			$REL_dateID = $row['REL_dateID'];
			$REL_monthID = $row['REL_monthID']; //month number
			$month_name = getMonthName($REL_monthID); //month name
			$REL_yearID = $row['REL_yearID'];
			$isActive = $row['isActive'];
		}
		include("includes/fields_news.php");
	}
	finishUp();


	/* **************************************************************************
	** Module definitions
	** **************************************************************************
	*/	
	function updateNewsItem()
	{
		// reference the global variables.
		global $isViewAllLinked;
		global $process;
		global $item;
		global $action;
		// For this record only, update the  news_item table with the posted values.
		$update_query =  "	UPDATE	news_item 
							SET 	title       = '" . $_POST['title'] . "',
									main_text   = '" . $_POST['main_text'] . "',
									REL_dateID  = "  . $_POST['REL_dateID'] . ",
									REL_monthID = "  . $_POST['REL_monthID'] . ",
									REL_yearID  = "  . $_POST['REL_yearID'] . ",
									isActive    = '" . $_POST['isActive'] . "' 
							WHERE 	PK_newsID	= "  . $_POST['PK_newsID'];
		$update_result = mysql_query($update_query);
		//Now get the record that's just been updated in the database.
		$new_query = "	SELECT	*
						FROM 	news_item
						WHERE 	PK_newsID = " . $_POST['PK_newsID'];
		$new_result = mysql_query($new_query);
		// Show a confirmation of entered data...
		if ($new_result)
		{
			//Open the table and form.
			include("includes/form_start.php");
			//Open table-row wrapper.
			echo("<tr class=\"feedback\" valign=\"top\">\n");
			echo("<td class=\"feedback\" colspan=\"2\>\n");
			//Print confirmation content.
			echo("<div class=\"feedback\">\n");
			while($row = mysql_fetch_array($new_result))
			{	
				echo("<br><p class=\"feedback\"><em style=\"color:black;\">Your " . $item . " was updated successfully in the database! Here is the edited record:</em></p>\n");
				echo("<p class=\"feedback\" style=\"font-weight:bold;font-size:18px;\">" . $row['title'] . "</p>\n");
				echo("<p class=\"feedback\">" . nl2br($row['main_text']) . "</p>\n");
				echo("<p class=\"feedback\" style=\"color:#000\"><b>Critical Date:</b> " . getMonthName($row['REL_monthID']) . " " . $row['REL_dateID'] . ", " . $row['REL_yearID'] . "</p>\n");
				echo("<p class=\"feedback\" style=\"color:#000\"><b>Show on Website:</b> " . $row['isActive'] . "</p>\n");
				echo("<p>&nbsp;&nbsp;<input type=\"button\" value=\" OK \" onclick=\"window.location.href='news_main.php'\"></p>");
			}
			echo("</div>\n");
			//Close table-row wrapper.
			echo("</td></tr>\n");
			//Close the table and form.
			include("includes/form_end.php");
		}
		// ...or an error.
		else
		{
			echo("<br><br><p class=\"error\">Error adding submitted news item: " . mysql_error() . "</p>\n");
		}
	}
?>
