<?php
	/*	------------------------------------------------------------------
		Set up the HTML form (including the ACTION attribute).
		------------------------------------------------------------------ */
	include("includes/form_start.php");
	
	
	/*	------------------------------------------------------------------
		Modules used by this file:
		------------------------------------------------------------------ */
	
	function showMonthOption ($isSelected, $monthNum, $monthName)
	{
		echo ("\t<option value=\"" . $monthNum);
		echo ("\"" . $isSelected . ">" . $monthName . "</option>\n");
	}
?>

	<!-- ---------------------------------------------------------------- -->
	<!-- Show the form fields (dynamically).                              -->
	<!-- ---------------------------------------------------------------- -->

	<tr valign="top">
		<td class="formLabel">Show on website? </td>
		<td>
		<?php
			// Only do dynamic radio-buttons if we have a GET variable
			if(isset($thisItemID))
			{
				//Show correct isActive choice from the record
				if($isActive == "yes")
				{
					echo("<label class=\"formText\">");
					echo("<input type=\"radio\" name=\"isActive\" value=\"yes\" checked>");
					echo("Yes</label>");
					echo("<br>");
					echo("<label class=\"formText\">");
					echo("<input type=\"radio\" name=\"isActive\" value=\"no\">");
					echo("No</label>");
				}
				elseif($isActive == "no")
				{
					echo("<label class=\"formText\">");
					echo("<input type=\"radio\" name=\"isActive\" value=\"yes\">");
					echo("Yes</label>");
					echo("<br>");
					echo("<label class=\"formText\">");
					echo("<input type=\"radio\" name=\"isActive\" value=\"no\" checked>");
					echo("No</label>");
				}
			}
			//Otherwise just default isActive to "yes"
			else
			{ 
		?>
				<label class="formText">
				<input type="radio" name="isActive" value="yes" checked>
				Yes</label>
				<br>
				<label class="formText">
				<input type="radio" name="isActive" value="no">
				No</label>
		<?php
			}
		?>
		</td>
	</tr>
	<tr valign="top">
		<td class="formLabel">Headline: </td>
		<td>
		<?php
			// Only populate the field w/ data if we have the GET variable '$thisItemID'.
			if(isset($thisItemID))
			{
				echo("<input name=\"title\" type=\"text\" size=\"50\" value=\"". $title ."\">");
			}
			else
			{
				echo("<input name=\"title\" type=\"text\" size=\"50\" value=\"\">");
			}
		?>
		</td>
	</tr>
	<tr valign="top">
		<td class="formLabel">Body text: </td>
		<td>
		<?php
			// Only populate the field w/ data if we have the GET variable '$thisItemID'.
			if(isset($thisItemID))
			{
				echo("<textarea name=\"main_text\" cols=\"50\" rows=\"9\">");
				echo($main_text);
				echo("</textarea>");
			}
			else
			{
				echo("<textarea name=\"main_text\" cols=\"50\" rows=\"9\">");
				echo("</textarea>");
			}
		?>
		</td>
	</tr>
	<tr><!-- Calendar icon-hyperlink -->
		<td class="formLabel" valign="top">
			&nbsp;
		</td>
		<td>
			<a id="clearBG" style="font-size:11px" href="#" onclick="openWindow('calendar.php')">
				<img src="images/icon_calendar.gif" alt="Launch calendar" border="0" align="middle">
				&nbsp;Pop-up Calendar
			</a>
		</td>
	</tr>
	<tr valign="top">
		<td class="formLabel">Critical date: </td>
		<td>
		
		<!-- ------------------------------- -->
		<!-- Populate the month SELECT list. -->
		<!-- ------------------------------- -->
		
		<select name="REL_monthID">
		
<?php 
// Get all the rows in the 'month' database table.
$allMonths = "	SELECT	month_num, month_name 
				FROM	month";
$allMonths_result = mysql_query($allMonths) 
					or die("There's a problem with allMonths query.");

if ($allMonths_result)
{
	// Loop thru table rows to get month options.
	while ($theRow = mysql_fetch_array($allMonths_result,MYSQL_ASSOC))
	{
		// Append SELECTED attribute according to whether this is
		// a database insertion or an update.

		// update:
		if(isset($thisItemID))
		{
			if ($theRow['month_num'] == $REL_monthID)
			{
				showMonthOption ("selected", $theRow['month_num'], $theRow['month_name']);
			}
			else
			{
				showMonthOption ("", $theRow['month_num'], $theRow['month_name']);
			}
		}

		// insertion:
		else
		{
			if ($theRow['month_num'] == date("n"))
			{
				showMonthOption ("selected", $theRow['month_num'], $theRow['month_name']);
			}
			else
			{
				showMonthOption ("", $theRow['month_num'], $theRow['month_name']);
			}
		}
	}
}
else
{
	echo("<p class=\"error\">Error in month SELECT query: " . mysql_error() . "</p>\n");
}
?>
			
		</select>&nbsp;
		
		
		<!-- ------------------------------- -->
		<!-- Populate the date SELECT list.  -->
		<!-- ------------------------------- -->

		<select name="REL_dateID">
			
			<!-- Populate the date option list. -->
			
<?php 
// Get all the rows in the 'date' database table.
$allDates = "SELECT date FROM date";
$allDates_result = mysql_query($allDates);
if($allDates_result)
{
	// Loop thru table rows to get date options.
	while ($allDatesRow = mysql_fetch_array($allDates_result,MYSQL_ASSOC))
	{		
		// Append SELECTED attribute according to whether this is
		// a database insertion or an update.

		// update:
		if(isset($thisItemID))
		{
			if($allDatesRow['date'] == $REL_dateID)
			{
				echo("\t<option value=\"" . $allDatesRow['date'] . "\" selected>" . $allDatesRow['date'] . "</option>\n");
			}
			else
			{
				echo("\t<option value=\"" . $allDatesRow['date'] . "\">" . $allDatesRow['date'] . "</option>\n");
			}
		}
		
		// insertion:
		else
		{
			if($allDatesRow['date'] == date("j"))
			{
				echo("\t<option value=\"" . $allDatesRow['date'] . "\" selected>" . $allDatesRow['date'] . "</option>\n");
			}
			else
			{
				echo("\t<option value=\"" . $allDatesRow['date'] . "\">" . $allDatesRow['date'] . "</option>\n");
			}
		}
	}
}
else
{
	echo("<p class=\"error\">Error in date SELECT query: " . mysql_error() . "</p>\n");
}
?>

		</select>&nbsp;
		
		
		<!-- ------------------------------- -->
		<!-- Populate the year SELECT list.  -->
		<!-- ------------------------------- -->

		<select name="REL_yearID">

			<!-- Populate the year option list. -->

<?php 

// Get all the rows in the 'year' database table.
$allYears = "SELECT year FROM year";
$allYears_result = mysql_query($allYears);

if($allYears_result)
{
	// Loop thru table rows to get year options.
	while ($allYearsRow = mysql_fetch_array($allYears_result,MYSQL_ASSOC))
	{
		// Append SELECTED attribute according to whether this is
		// a database insertion or an update.

		// update:
		if(isset($thisItemID))
		{
			if($allYearsRow['year'] == $REL_yearID)
			{
				echo("\t<option value=\"" . $allYearsRow['year'] . "\" selected>" . $allYearsRow['year'] . "</option>\n");
			}
			else
			{
				echo("\t<option value=\"" . $allYearsRow['year'] . "\">" . $allYearsRow['year'] . "</option>\n");
			}
		}
		
		// insertion:
		else
		{
			if($allYearsRow['year'] == date("Y"))
			{
				echo("\t<option value=\"" . $allYearsRow['year'] . "\" selected>" . $allYearsRow['year'] . "</option>\n");
			}
			else
			{
				echo("\t<option value=\"" . $allYearsRow['year'] . "\">" . $allYearsRow['year'] . "</option>\n");
			}
		}
	}
}
else
{
	echo("<p class=\"error\">Error in year SELECT query: " . mysql_error() . "</p>\n");
}

?>
		
			</select>
		
			<br>
			<span class="formText">(If there's no specific date for this news item,
			<br>please select an approximate one.)</span>
			<br><br>
		</td>
	</tr>
	<tr valign="top">
		<td class="formLabel">&nbsp;</td>
		<td>

			<!-- ---------------------------------------------------- -->
			<!-- Hidden form-field to pass the PK_newsID field value. -->
			<!-- ---------------------------------------------------- -->

			<input type="hidden" name="PK_newsID" value="<?php echo($PK_newsID); ?>">

			
			
			<!-- -------------------------------- -->
			<!-- Dynamic SUBMIT button.           -->
			<!-- -------------------------------- -->
		
			<?php
			/*
			** For the submit button, set the value of the name
			** attribute based on the $process variable's value.
			*/
			if($process == "Add")
			{
				echo("<input type=\"submit\" name=\"submit\" value=\"Add\">");
			}
			elseif($process == "Edit")
			{
				echo("<input type=\"submit\" name=\"submit\" value=\"Update\">");
			}
			?>
			
			
			<!-- "Cancel" button functions as a "Back" button. -->
			&nbsp;<input name="cancel" type="button" onClick="window.history.back();" value="Cancel">
		</td>
	</tr>

	
<!-- -------------------------------- -->
<!-- Include the 'form_end.php' file. -->
<!-- -------------------------------- -->

<?php
	include("includes/form_end.php");
?>