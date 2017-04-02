<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>
<head>
<title>SQL Database Syntax</title>
</head>

<body>

<?php
error_reporting (E_ALL);

// Connect to database 'guelphm_web'.
include ("../../config.php");
$databaseLink = mysql_connect ($host, $username, $password);
// Put the database name in a variable.
$databaseName = "guelphm_web";


// -----------------------------------------------
// ---------------- Query section ----------------
// -----------------------------------------------

$query = "SHOW TABLES FROM " . $databaseName;
$table_set = mysql_query ($query);
if ($table_set)
{
	echo ("<h3>Tables in database '<i>" . $databaseName . "</i>'</h3>");

	$numberOfRows = mysql_num_rows ($table_set);
	for ($count = 1; $count <= $numberOfRows; $count++)
	{
		$row = mysql_fetch_row ($table_set);
		foreach ($row as $tableName)
		{
			echo ($tableName . "<br />\n");
		}
	}
}
else
{
	echo('Error in $query!');
}




// Close connection to database.
mysql_close ($databaseLink);
?>

</body>
</html>

