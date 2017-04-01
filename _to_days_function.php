<?php
$title = "MySQL to_days(date) function - Test";
include("includes/header.php");
echo("<h1>" . $title . "</h1>");



$UnixDays_result = mysql_query ("SELECT to_days('1972')");

if ($UnixDays_result)
{
	echo ('Result of <em>to_days(1972)</em>: ' . mysql_result($UnixDays_result, 0));
}
else
{
	echo ("<p style=\"color:red\">There's been a system error!</p>");
}

include ("includes/footer.php");
?>
