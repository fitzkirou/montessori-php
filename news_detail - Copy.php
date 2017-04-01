<?php
	//Global Variables:
	$area = date('F Y') . " News";
	$title = "News Item";
	//Start the HTML wrapper.
	include("includes/header.php");

	
/* -------------------------------------------------------------------
Query the database for the passed news item ID.
---------------------------------------------------------------------- */
	
	// First, protect against an SQL injection attack by letting ONLY
	// numeric GET variables through; otherwise, stop PHP altogether.
	if (!is_numeric ($_GET['PK_newsID']))
	{
		echo("<p class=\"error\">SQL injection attack detected. Aborting.</p>");
		die;
	}
	else
	{
		$itemID = $_GET['PK_newsID'];
	}
	
	// If $_GET variable is clean, then do the query:
	$news_query = " SELECT *
					FROM 	news_item
					WHERE 	PK_newsID='$itemID'";
	$news_result = mysql_query($news_query);

	
/* -------------------------------------------------------------------
Display the content.
---------------------------------------------------------------------- */
	
	//Show an error on query failure and exit.
	if(!$news_result) {
		echo("<h1>Error</h1>");
		echo("<p>There was a problem querying the Guelph ");
		echo('Montessori database. Name of query: $news_query. ');
		echo("Please report this problem to the ");
		echo("<a href=\"mailto:bobyoung@sgci.com\">webmaster</a>.</p>");
		echo("<a href=\"javascript:window.history.back();\">Home page</a>");
		//Finish up HTML wrapper.
		include ("includes/footer.php");
		exit();
	}

	//Show the news item's content.
	while ($row = mysql_fetch_array($news_result)) {
		echo("<div class=\"areaFolio\">" . $area . "</div>");
		echo("<h1>" . $row['title'] . "</h1>");
		//Convert 'newline' characters to <br />, so that paragraphs show.
		$theText = $row['main_text'];
		echo (nl2br($theText));
		//Link back to home.
		echo("<p><a href=\"javascript:window.history.back();\">Home page</a></p>");
	}

	//Finish up HTML wrapper.
	include ("includes/footer.php");
?>
