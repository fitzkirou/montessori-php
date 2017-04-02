<?php
	/*
	** Project: WEBadmin - Guelph Montessori School
	** Version: 1.0
	** File: news_delete.php
	** Purpose: From a passed GET variable, displays the content of a news
	** 			item; buttons will execute deletion or allow user to back out.
	** Author: Bob Young, June 2003.
	*/
	
	/* **************************************************************************
	** Mainline Logic
	** **************************************************************************
	*/
	include("includes/library.php"); //Include shared modules.
	$isViewAllLinked = true; //Define global variables.
	$process = "Delete";
	$item = "news item";
	$action = "news_delete.php";
	
	prepare($isViewAllLinked,$process,$item,$action);
	
	// Delete the item on submit; otherwise just show a delete form.
	if (isset($_POST['submit'])) {
		$isDeleted = deleteNewsItem($_POST['PK_newsID']);
		showDeleteConfirmation($isDeleted);
	}
	else {
		showDeleteForm($_GET['PK_newsID']);
	}
	
	finishUp();

	/* **************************************************************************
	** Module definitions
	** **************************************************************************
	*/
	
	function showDeleteForm($id)
	{
		global $isViewAllLinked;
		global $process;
		global $item;
		global $action;
		// Get the fields for this news item.
		$item_query =  "SELECT * 
						FROM news_item 
						WHERE PK_newsID = '$id'";
		$item_result = mysql_query($item_query);
		// Display the full content to the user.
		if($row = mysql_fetch_array($item_result))
		{
			//Open the table and form.
			include("includes/form_start.php");
			//Open table-row wrapper.
			echo("\t<tr class=\"feedback\" valign=\"top\">\n");
			echo("\t<td class=\"feedback\" colspan=\"2\>\n");
			//Print confirmation content.
			echo("\t\t<div class=\"feedback\">\n");
			echo("\t\t\t<br><p class=\"feedback\" style=\"font-weight:bold;font-size:18px;\">" . $row['title'] . "</p>\n");
			echo("\t\t\t<p class=\"feedback\">" . nl2br($row['main_text']) . "</p>\n");
			echo("\t\t\t<p class=\"feedback\" style=\"color:#000\"><b>Critical Date:</b> " . getMonthName($row['REL_monthID']) . " " . $row['REL_dateID'] . ", " . $row['REL_yearID'] . "</p>\n");
			echo("\t\t\t<p class=\"feedback\" style=\"color:#000\"><b>Show on Website:</b> " . $row['isActive'] . "</p>\n");
			//Give warning message.
			echo("\t\t\t<div class=\"warning\">Are you sure you want to delete the " . $item . " above?</div>\n");
			//Put $id in a hidden field.
			echo("<input type=\"hidden\" name=\"PK_newsID\" value=\"$id\">");
			//Show buttons.
			echo("\t\t\t&nbsp;&nbsp;<input type=\"submit\" name=\"submit\" value=\"Yes\">&nbsp;\n");
			echo("\t\t\t<input type=\"button\" value=\"No\" onclick=\"window.history.back();\">\n");
			echo("\t\t\t<br><br>");
			echo("\t\t</div>\n");
			//Close table-row wrapper.
			echo("\t</td></tr>\n");
			//Close the table and form.
			include("includes/form_end.php");
		}
	}
	
	function deleteNewsItem($id)
	{
		//Perform delete query
		$delete_query = "DELETE FROM news_item 
						 WHERE PK_newsID = '$id'";
		$delete_result = mysql_query($delete_query);
		if($delete_result)
		{
			return(true);
		}
		else
		{
			echo("<br><br><p class=\"error\">Error in DELETE query: " . mysql_error() . "</p>\n");
			return(false);
		}
	}
	
	function showDeleteConfirmation($isDeleted)
	{
		//Bring in the global variables.
		global $isViewAllLinked;
		global $process;
		global $item;
		//Action should be null because we're done.
		$action = ""; 
		//Open the table and form.
		include("includes/form_start.php");
		
		//Open table-row wrapper.
		echo("\t<tr class=\"feedback\" valign=\"top\">\n");
		echo("\t<td class=\"feedback\" colspan=\"2\>\n");
		//Show whether the DELETE was successfull or not.
		echo("<div class=\"feedback\">");
		if($isDeleted == true)
		{
			echo("<p class=\"feedback\"><br><br>The selected news item was deleted successfully!</p>");
			echo("&nbsp;&nbsp;<input type=\"button\" name=\"goBack\" value=\" OK \" onclick=\"window.location.href='news_main.php'\">");
			echo("<br><br>");
		}
		else
		{
			echo("<p class=\"feedback\"><br><br>There was a problem deleting the news item: " . mysql_error() . "</p>\n");
			echo("&nbsp;&nbsp;<input type=\"button\" name=\"goBack\" value=\" OK \" onclick=\"window.location.href='news_main.php'\">");
			echo("<br><br>");
		}
		echo("</div>");
		//Close table-row wrapper.
		echo("\t</td></tr>\n");
		//Close the table and form.
		include("includes/form_end.php");
	}
?>
