<?php
	/*
	** Project: WEBadmin - Guelph Montessori School
	** Version: 1.0
	** File: news_add.php
	** Purpose: Takes user input and inserts news-item records into the database.
	** Author: Bob Young, Symcor Inc., May 2003.
	*/
	
	// Define global variables.
	$screenTitle = "NEWS ITEMS &gt; ADD";
	include("header.php");
?>

<!-- Sub-navigation links -->
<a href="../news_main.php">View all</a> | Add a news item

<!--Input form starts-->
<form>
	<table width="586" cellpadding="0" cellspacing="0">
	</table>
</form>
<!--Input form ends-->

<?php
// ****************************
// Finish up interface display.
// ****************************
include ("footer.php");
?>
