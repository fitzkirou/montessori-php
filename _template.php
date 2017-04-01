<!-- TEMPLATE FOR ROOT-LEVEL FILES - guelphmontessori.com -->
<?php
$title = "Home";
include("includes/header.php");
include("gms4Adm1n/includes/library.php");

// S A M P L E   Q U E R Y   A N D   H T M L   O U T P U T.
// Query to retreive ACTIVE news records.
$active_query = "SELECT		*
				 FROM		news_item
				 WHERE		isActive='yes'
				 ORDER BY	REL_yearID ASC, REL_monthID ASC, REL_dateID ASC";
$active_result = mysql_query($active_query);
// Find the number of returned rows.
if ($active_result)
{
	$active_rows = mysql_num_rows($active_result);
}
else
{
	echo("Error in SELECT query: " . mysql_error());
}
// Show the data if we have at least one row returned.
if ($active_rows > 0)
{
	// Loop thru returned rows, displaying title & a bit of the text.
	while ($row = mysql_fetch_array($active_result,MYSQL_ASSOC))
	{
		echo("<p class=\"teaser\">\n");
		
		echo("<span class=\"featureTitle\">" . $row['title'] . "</span><br>\n");
		//Truncate $teaser to 120 characters and show it.
		$teaser = substr($row['main_text'],0,120);
		echo($teaser);

		// Add a closing bold tag </b> if $teaser contains an opening angle bracket "<".
		$teaserLength = strlen($teaser);
		for ($i = 0; $i < $teaserLength; $i++)
		{
			$character = substr($teaser, $i, 1);
			if ($character == "<")
			{
				echo ("</b>\n");
			}
		}
		
		echo(" ... <a class=\"teaserLink\"");
		// Append this item's ID as a GET variable to the detail page.
		echo (" href=\"news_detail.php?PK_newsID=" . $row['PK_newsID'] . "\">More</a>");
		
		echo("</p>\n");
	}
}
// Indicate if there are no records.
else
{
	echo("Currently, there are no news items.\n");
}
?>

<?PHP
	include ("includes/footer.php");
	mysql_close($dbh);
?>
