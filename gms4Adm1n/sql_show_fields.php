<?php
// **********************************************************
// QuickAdmin

// Developed by:  Robert B. Young

// Written:       October 2003
// Modified:      6-Oct-2003.

// Contact:       youngdev@canada.com

// The quick_admin.php page is a bare-bones admin tool,
// showing tables & fields. You must hardcode the database's
// name into a variable below. Table names are shown auto-
// matically; the user enters a tablename to view the fields
// in that table. Verify that you have a similar path to the
// config.php file, or modify the code as per your directory
// setup.

// **********************************************************
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>
<head>
<title>SQL Database Syntax</title>
</head>

<body>

<?php
// Connect to database 'guelphm_web'.
include ("../../config.php");
$databaseLink = mysql_connect ($host, $username, $password);

// Define variables
$databaseName = "guelphm_web";
// Show page title
echo ("<h3>Database <i style=\"color:Brown;\">" . $databaseName . "</i></h3>\n");

// User has clicked 'submit', so show the fields for the table name submitted.
if (isset ($submit))
{
	$tableName = $_POST['table'];
	// Table with header row (field attribute names)
	echo ('<table bgcolor="LightGrey" cellpadding="4" border="1">' . "\n");
	echo ('<tr>');
	echo ('<th colspan="6" style="color:White; background-color:Black;">');
	echo ("Table <i>" . $tableName . "</i></th>");
	echo ('</tr>');
	echo ('<tr>' . "\n");
	showHeaderCell ("Field");
	showHeaderCell ("Type");
	showHeaderCell ("Attributes");
	showHeaderCell ("Key");
	showHeaderCell ("Default");
	showHeaderCell ("Extra");
	echo ('</tr>' . "\n");
	
	// Make query and show results.
	$query = "SHOW COLUMNS FROM " . $tableName . " FROM " . $databaseName;
	$result_set = mysql_query ($query);
	
	if ($result_set)
	{
		// Loop thru resulting rows, printing each field's attribute values.
		$rowsReturned = mysql_num_rows ($result_set);
		for ($count = 1; $count <= $rowsReturned; $count++)
		{
			echo ("<tr>");
			$rowArray = mysql_fetch_row ($result_set);
	
			foreach ($rowArray as $fieldSpec)
			{
				// If this field attribute is null, place a non-breaking space
				// in the table cell; otherwise show the attribute's value.
				if ($fieldSpec == "")
				{
					echo ("<td>&nbsp;</td>");
				}
				else
				{
					echo ("<td>" . $fieldSpec . "</td>");
				}
			}
	
			echo ("</tr>");
		}
	}
	else
	{
		echo('Error in $query!');
	}
	echo ("</table>");
}


/*
** Always let the user enter a table-name.
*/
// Query and show the database's tables.
$query = "SHOW TABLES FROM " . $databaseName;
$table_set = mysql_query ($query);
if ($table_set)
{
	echo ("<p><b>Tables in database</b> " . $databaseName . "</p>\n");
	$numberOfRows = mysql_num_rows ($table_set);
	for ($count = 1; $count <= $numberOfRows; $count++)
	{
		$row = mysql_fetch_row ($table_set);
		foreach ($row as $tableName)
		{
			echo ("<i>" . $tableName . "</i><br />\n");
		}
	}
}
else
{
	echo('Error in $query!');
}
// Show the table-name input form.
echo ('<hr><form action="sql_show_fields.php" method="post">
<p>Referring to the table list above, enter a table name to see its fields (and their attributes).</p>
<input type="text" name="table" />
<input type="submit" name="submit" value="View fields" />
</form>');

// Close connection to database.
mysql_close ($databaseLink);

/*
** Shows a table cell containing a field attribut.
*/
function showHeaderCell ($field_attribute)
{
	echo ("\t" . '<td style="font-weight:bold; color:white; background-color:brown;">');
	echo ($field_attribute);
	echo ("</td>\n");
}
?>

</body>
</html>

