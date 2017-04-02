<?php
// *****************************************************************
// The file calendar.php automatically displays the current month
// in calendar format. There's also a form that allows you to view
// other months in this or other years.

// Source: Ullman, Larry. PHP for the World Wide Web (Berkeley, CA: 
// Peachpit Press, 2001): 219-224.
// *****************************************************************

// -----------------------------------------------------------------
// If the $_GET['Month'] and $Year values don't exist,
// make them the current month and year.
// -----------------------------------------------------------------
if ((!$_GET['Month']) && (!$_GET['Year']))
{
	$_GET['Month'] = date ("m");
	$_GET['Year'] = date ("Y");
}

/*	------------------------------------------------------------------
	Calculate the viewed month.
	------------------------------------------------------------------ */
$Timestamp = mktime (0, 0, 0, $_GET['Month'], 1, $_GET['Year']);
$MonthName = date ("F", $Timestamp);
	
/*	------------------------------------------------------------------
	Make a table with the proper month as header.
	------------------------------------------------------------------ */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
	<title>Calendar - Guelph Montessori</title>
	<!-- Link to stylesheet. -->
	<link href="includes/web_mgr.css" rel="stylesheet">
</head>

<body id="calBody">

<table style="border:2px solid black" width="100%" align="center" border="0" cellpadding="3" cellspacing="0">
	<!-- Current-month Header -->
	<tr>
		<td colspan="7" class="calHeader" style="font-size:14pt;">
			<strong>
				<?php echo ($MonthName . " " . $_GET['Year']) ?>
			</strong>
		</td>
	</tr>
	<!-- Days-of-Week Header -->
	<tr class="calHeader" style="color:white">
		<td width="20" style="color:white">Su</td>
		<td width="20" style="color:white">M</td>
		<td width="20" style="color:white">Tu</td>
		<td width="20" style="color:white">W</td>
		<td width="20" style="color:white">Th</td>
		<td width="20" style="color:white">F</td>
		<td width="20" style="color:white">Sa</td>
	</tr>
	
<?php


/*	------------------------------------------------------------------
	Determine values for:	*on what day of the week this month starts
							*the number of days in this month
	------------------------------------------------------------------ */

$MonthStart = date ("w", $Timestamp); // integer day-of-the-week format

// If the month begins on a Sunday, then convert variable $MonthStart
// --whose value will be zero--to 7, so it can work with rest of script.
if ($MonthStart == 0)
{
	$MonthStart = 7;
}

// Use additive inverse of actual start-date
// to help place the "1st" on the calendar.
$StartDate = -$MonthStart;
$LastDay = date ("t", $Timestamp); // number of days in this month



/*	------------------------------------------------------------------
	Loop to print out the calendar's body.
	------------------------------------------------------------------ */

for ($row = 1; $row <= 6; $row++) // six rows
{
	echo ('<tr class="calDates">');
	for ($day = 1; $day <= 7; $day++) // seven columns (days)
	{
		$StartDate++; // increment the printed date in each iteration
		// Print a coloured blank cell for out-of-range date values;
		// otherwise print the date.
		if (($StartDate <= 0) OR ($StartDate > $LastDay))
		{
			echo ('<td class="outOfRange">&nbsp;</td>');
		}
		elseif (($StartDate >= 1) AND ($StartDate <= $LastDay))
		{
			echo ('<td class="inRange">' . $StartDate . '</td>');
		}
	}
	echo ('</tr>');
}

?>

<!-- Close the table. -->
</table>


<!-- ----------------------------------------------------------------- -->
<!-- Make the form (to submit back to this page).                      -->
<!-- ----------------------------------------------------------------- -->
<br>

<form id="newMonth" action="calendar.php" method="get" style="background-color:#c6dbef;">
	<span style="font-size:12px; color:Black; font-weight:bold;">
		Select a new month to view:
	</span><br>
	<select name="Month">
		<option value="1">January</option>
		<option value="2">February</option>
		<option value="3">March</option>
		<option value="4">April</option>
		<option value="5">May</option>
		<option value="6">June</option>
		<option value="7">July</option>
		<option value="8">August</option>
		<option value="9">September</option>
		<option value="10">October</option>
		<option value="11">November</option>
		<option value="12">December</option>
	</select>
	<select name="Year"> &nbsp;
	<?php
		// Show the year options dynamically (w/ $thisYear selected).
		$thisYear = date ("Y");
		$lastYear = $thisYear - 1;
		$nextYear = $thisYear + 1;
		$beyond = $thisYear + 2;
		echo ('<option value="' . $lastYear . '">' . $lastYear . '</option>');
		echo ('<option selected value="' . $thisYear . '">' . $thisYear . '</option>');
		echo ('<option value="' . $nextYear . '">' . $nextYear . '</option>');
		echo ('<option value="' . $beyond . '">' . $beyond . '</option>');
		echo ('<option value="' . ($beyond + 1) . '">' . ($beyond + 1) . '</option>');
		echo ('<option value="' . ($beyond + 2) . '">' . ($beyond + 2) . '</option>');
		echo ('<option value="' . ($beyond + 3) . '">' . ($beyond + 3) . '</option>');
	?>
	</select>
	<br><br><input type="Submit" name="submit" value="View month"> 
	<input type="Button" name="close" value="Close" onclick="window.close();">
</form>

</body>
</html>