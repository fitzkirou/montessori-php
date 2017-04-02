<?php
	/*
	** Project: WEBadmin - Guelph Montessori School
	** Version: 1.0
	** File: news_add.php
	** Purpose: Takes user input and inserts a news-item record into the database.
	** Author: Bob Young, May 2003.
	*/

	/* ******************************************************
	** Mainline Logic
	** ******************************************************
	*/
	include("includes/library.php"); //Include shared modules.
	
	$isViewAllLinked = true; //Define global variables.
	$process = "Add";
	$item = "news item";
	$action = "news_add.php";
	
	prepare($isViewAllLinked,$process,$item,$action);
	
	// process the form only if the submit button has been clicked
	if (isset($_POST['submit'])) {
		insertNewsItem();
	}
	else {
		include("includes/fields_news.php");
	}
	
	finishUp();


	/* ******************************************************
	** Module definitions
	** ******************************************************
	*/
	function insertNewsItem()
	{
		global $isViewAllLinked, $process, $item, $action;
		
		// Insert the form-field values to the news_item table.
		$news_query =  "INSERT INTO news_item 
						SET title = '" . $_POST['title'] . "',
							main_text = '" . $_POST['main_text'] . "',
							REL_dateID = " . $_POST['REL_dateID'] . ",
							REL_monthID = " . $_POST['REL_monthID'] . ",
							REL_yearID = " . $_POST['REL_yearID'] . ",
							isActive = '" . $_POST['isActive'] . "'";
		// Show a confirmation of entered data...
		if(@mysql_query($news_query))
		{
			//Open the table and form.
			include("includes/form_start.php");
			//Open table-row wrapper.
			echo("<tr class=\"feedback\" valign=\"top\">\n");
			echo("<td class=\"feedback\" colspan=\"2\>\n");
			//Print confirmation content.
			echo("<div class=\"feedback\">\n");
			echo("<br><p class=\"warning\">Your " . $item . " was added successfully to the database! <br>Here it is what you entered:</p>\n");
			echo("<p class=\"feedback\" style=\"font-weight:bold;font-size:18px;\">" . $_POST['title'] . "</p>\n");
			echo("<p class=\"feedback\">" . nl2br($_POST['main_text']) . "</p>\n");
			echo("<p class=\"feedback\" style=\"color:#000\"><b>Critical Date:</b> " . getMonthName($_POST['REL_monthID']) . " " . $_POST['REL_dateID'] . ", " . $_POST['REL_yearID'] . "</p>\n");
			echo("<p class=\"feedback\" style=\"color:#000\"><b>Show on Website:</b> " . $_POST['isActive'] . "</p>\n");
			echo("&nbsp;&nbsp;<input type=\"button\" name=\"goBack\" value=\" OK \" onclick=\"window.location.href='news_main.php';\"><br><br>");
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
