<?php
$title = "Columns in the 'event' table";
include("includes/header.php");
echo("<h1>" . $title . "</h1>");

// MySQL test starts.
$sql = "DESCRIBE event";
$sql_result = mysql_query ($sql);

if ($sql_result)
{
	for ($i = 0; $i <= 7; $i++)
	{
		echo (mysql_result($sql_result, $i) . '<br>');
	}
	//while ($row = mysql_fetch_array ($sql_result))
	//{
	//	echo ($row['title'] . '<br>');
	//}
}
else
{
	echo ('<p class="error">The query returned FALSE.</p>');
}
// MySQL test ends.


include ("includes/footer.php");
?>
