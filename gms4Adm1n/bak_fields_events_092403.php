<?php
	//set up the form, title, and subtitle:
	include("includes/form_start.php");
?>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" valign="top">

			<!-- ------------------------------------------------------ -->
			<!-- Subtable for radio buttons and event-type SELECT list. -->
			<!-- ------------------------------------------------------ -->
			
			<table cellspacing="0" cellpadding="0" border="0">
			<tr>
				<td valign="top" align="right">
					&nbsp;&nbsp;&nbsp;&nbsp;
					<strong>Show on website?</strong>
				</td>
				
				<td valign="top">
				
			<?php
			// Only do dynamic radio-buttons if we're updating and have a GET variable
			// I.e., we're updating an existing record
			if(isset($thisEventID))
			{
				//Show correct isActive choice from the record
				if($isActive == "yes")
				{
					echo("<input type=\"radio\" name=\"isActive\" value=\"yes\" checked>");
					echo("Yes<br>");
					echo("<input type=\"radio\" name=\"isActive\" value=\"no\">");
					echo("No");
				}
				elseif($isActive == "no")
				{
					echo("<input type=\"radio\" name=\"isActive\" value=\"yes\">");
					echo("Yes<br>");
					echo("<input type=\"radio\" name=\"isActive\" value=\"no\" checked>");
					echo("No");
				}
			}
			//Otherwise just default isActive to "yes"
			else
			{ 
			?>
				<input type="radio" name="isActive" value="yes" checked>Yes<br><input type="radio" name="isActive" value="no">No
			<?php
			}
			?>
				</td>
				
				<td>
					<!-- White space to help aling the "Type" list-box: -->
					&nbsp;&nbsp;&nbsp;&nbsp;
				</td>
				
				<td align="right" valign="top">
					<strong>Type:</strong>
				</td>
				
				<td valign="top">
				<select name="eventList" size="1" onblur="checkEventType(this);">
		<?php
			// Only show a SELECTED <option> if we're updating 
			// and have the GET variable '$thisEventID'.
			if(isset($thisEventID))
			{
				echo("<strong>[The coding for this hasn't been done yet!]</strong>\n");
			}
			// Otherwise, just show the list; don't show any SELECTED option.
			else
			{
				$types_query = "SELECT DISTINCTROW code, type
								FROM event
								ORDER BY code ASC";
				$types_result = mysql_query ($types_query);
				if ($types_result)
				{
					while ($theRow = mysql_fetch_array($types_result))
					{
						echo ('<option value="' . $theRow['code'] . '">');
						echo ($theRow['type'] . "</option>\n");
					}
				}
				else
				{
					echo ('<p class="error">ERROR: There\'s been a system error in querying the database.</p>');
					exit;
				}
			}
		?>
			</select>
				
				</td>
			</tr>
			</table>
			<!-- ------------------------------------------------------ -->
			<!-- Subtable ends.---------------------------------------- -->
			<!-- ------------------------------------------------------ -->

		</td>
	</tr>
	<tr>
		<td class="formLabel">Title: </td>
		<td>
		<?php
			// Only populate the field w/ data if we're updating and have the GET variable '$thisEventID'.
			if(isset($thisEventID))
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
	<tr>
		<td class="formLabel">Location (optional): </td>
		<td>
		<?php
			// Only populate the field w/ data if we're updating and have the GET variable '$thisEventID'.
			if(isset($thisEventID))
			{
				echo("<input name=\"location\" type=\"text\" size=\"50\" value=\"". $location ."\">");
			}
			else
			{
				echo("<input name=\"location\" type=\"text\" size=\"50\" value=\"\">");
			}
		?>
		</td>
	</tr>
	<tr><!-- Vertical white space -->
		<td colspan="2">
			&nbsp;
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
	
	<!-- ------------------------------------------------------- -->
	<!-- ---------------- START-OF-EVENT FIELDS ---------------- -->
	<!-- ------------------------------------------------------- -->
	<tr>
		<td class="formLabel">Start of Event: </td>
		<td>
			<select name="start_day">
		<?php
			//Make an array of the days of the week.
			$startDayName = array(1=>"Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
			//only append the "selected" attribute if we've got the GET variable $thisEventID
			if(isset($thisEventID))
			{
				// Get the $start_day that matches this event record's $REL_startID.
				$tableDay_query = "	SELECT	start_day 
									FROM 	event_start 
									WHERE	PK_startID = '$REL_startID' ";
				$tableDay_result = mysql_query($tableDay_query);
				// Loop thru table rows to get month options.
				if($tableDay_result)
				{
					// Append the 'selected' attribute if the row matches table record's $REL_startID.
					if($table_row = mysql_fetch_array($tableDay_result))
					{
						foreach($startDayName as $value)
						{
							// Append 'selected'.
							if($value == $table_row['start_day'])
							{
								echo("\t<option value=\"" . $value . "\" selected>" . $value . "</option>\n");
							}
							// Don't append 'selected'.
							else
							{
								echo("\t<option value=\"" . $value . "\">" . $value . "</option>\n");
							}
						}
					}
				}
				// Show error on bad query result.
				else
				{
					echo("<p class=\"error\">There's a problem with the SELECT query named 'tableDay_query': " . mysql_error() . "</p>\n");
				}
			}
			//If we're adding a new record, simply loop through the $startDayName array.
			else
			{
				foreach($startDayName as $value)
				{
					// Append the 'selected' attribute to the current day name.
					if ($value == date("l"))
					{
						echo("\t<option value=\"" . $value . "\" selected>" . $value . "</option>\n");
					}
					else
					{
						echo("\t<option value=\"" . $value . "\">" . $value . "</option>\n");
					}
				}
			}
		?>
			</select>&nbsp;
			
			<select name="start_month_num">
			<!-- Populate the month option list. -->
		<?php 
			
			// Get all the rows in the 'month' database table.
			$allMonths = "SELECT month_num, month_name FROM month";
			$allMonths_result = mysql_query($allMonths);
			//only append the "selected" attribute if we've got the GET variable $thisEventID
			if(isset($thisEventID))
			{
				// Get the $start_month_num that matches this event record's $REL_startID.
				$monthNum_query = "		SELECT	start_month_num 
										FROM	event_start 
										WHERE	PK_startID = '$REL_startID' ";
				$monthNum_result = mysql_query($monthNum_query);
				if($month_row = mysql_fetch_array($monthNum_result))
				{
					$thisMonthNum = $month_row['start_month_num']; // this var is used below.
				}
				// Proceed if we've got a good $allMonths query.
				if($allMonths_result)
				{
					// Loop thru table rows to get month options.
					while ($allMonthsRow = mysql_fetch_array($allMonths_result,MYSQL_ASSOC))
					{
						// Append the 'selected' attribute if the row matches this record's $REL_startID.
						if($allMonthsRow['month_num'] == $thisMonthNum)
						{
							echo("\t<option value=\"" . $allMonthsRow['month_num'] . "\" selected>" . $allMonthsRow['month_name'] . "</option>\n");
						}
						else
						{
							echo("\t<option value=\"" . $allMonthsRow['month_num'] . "\">" . $allMonthsRow['month_name'] . "</option>\n");
						}
					}
				}
				// If bad $allMonths query, show an error.
				else
				{
					echo("<p class=\"error\">Error in month SELECT query: " . mysql_error() . "</p>\n");
				}
			}
			//If we're adding a new record, simply loop through the date-number list
			else
			{
				while ($allMonthsRow = mysql_fetch_array($allMonths_result,MYSQL_ASSOC))
				{
					// Append the 'selected' attribute to the current month.
					if ($allMonthsRow['month_num'] == date("n"))
					{
						echo("\t<option value=\"" . $allMonthsRow['month_num'] . '\" selected>' . $allMonthsRow['month_name'] . "</option>\n");
					}
					else
					{
						echo("\t<option value=\"" . $allMonthsRow['month_num'] . "\">" . $allMonthsRow['month_name'] . "</option>\n");
					}
				}
			}
		?>
			</select>
			&nbsp;
			<select name="start_date_num">
			<!-- Populate the date option list. -->
		<?php 
			// Get all the rows in the 'date' database table.
			$allDates = "SELECT date FROM date";
			$allDates_result = mysql_query($allDates);
			//only append the "selected" attribute if we've got the GET variable $thisEventID
			if(isset($thisEventID))
			{
				// Get the $start_date_num that matches this event record's $REL_startID.
				$thisDate_query = "	SELECT	start_date_num 
									FROM	event_start 
									WHERE	PK_startID = '$REL_startID' ";
				$thisDate_result = mysql_query($thisDate_query);
				if($this_row = mysql_fetch_array($thisDate_result))
				{
					$thisDateNum = $this_row['start_date_num']; // this var is used below.
				}
				// Proceed if we've got a good $allDates query.
				if($allDates_result)
				{
					// Loop thru table rows to get date options.
					while ($allDatesRow = mysql_fetch_array($allDates_result,MYSQL_ASSOC))
					{
						// Append the 'selected' attribute if the row matches this record's $REL_startID.
						if($allDatesRow['date'] == $thisDateNum)
						{
							echo("\t<option value=\"" . $allDatesRow['date'] . "\" selected>" . $allDatesRow['date'] . "</option>\n");
						}
						else
						{
							echo("\t<option value=\"" . $allDatesRow['date'] . "\">" . $allDatesRow['date'] . "</option>\n");
						}
					}
				}
				// If bad $allDates query, show an error.
				else
				{
					echo("<p class=\"error\">Error in month SELECT query: " . mysql_error() . "</p>\n");
				}
			}
			//If we're adding a new record, simply loop through the date-number list
			else
			{
				for ($date = 1; $date <= 31; $date++)
				{
					// Append "selected" attribute to the current date value.
					if ($date == date("j"))
					{
						echo("\t<option value=\"" . $date . '\" selected>' . $date . "</option>\n");
					}
					else
					{
						echo("\t<option value=\"" . $date . "\">" . $date . "</option>\n");
					}
				}
			}
		?>
			</select>
			&nbsp;
			<?php
			// Only populate the field w/ data if we're updating and have the GET variable '$thisEventID'.
			if(isset($thisEventID))
			{
				// Get $start_time that matches this event record's $REL_startID.
				$startYear_query = "	SELECT	start_year 
										FROM 	event_start 
										WHERE 	PK_startID = '$REL_startID' ";
				$startYear_result = mysql_query($startYear_query);
				if($startYear_row = mysql_fetch_array($startYear_result))
				{
					// This var is used below.
					$recStartYear = $startYear_row['start_year'];
				}
				//Show year from the record.
				echo("<input type=\"text\" name=\"start_year\" size=\"4\" maxlength=\"4\" value=\"" . $recStartYear . "\">");
			}
			//Otherwise, just show the current year.
			else
			{
				echo("<input type=\"text\" name=\"start_year\" size=\"4\" maxlength=\"4\" value=\"" . date("Y") . "\">");
			}
		?>
		</td>
	</tr>
	<tr>
		<td class="formLabel" align="right">Time (hh:mm): </td>
		<td>
		<?php
			// Only populate the field w/ data if we're updating
			// and have the GET variable '$thisEventID'.
			if(isset($thisEventID))
			{
				// Get $start_time that matches this event record's $REL_startID.
				$thisStart_query = "	SELECT	start_time 
										FROM 	event_start 
										WHERE 	PK_startID = '$REL_startID' ";
				$thisStart_result = mysql_query($thisStart_query);
				if($start_row = mysql_fetch_array($thisStart_result))
				{
					// This var is used below.
					$thisStartTime = $start_row['start_time'];
					//Lop the seconds off the time string.
					$start_HHMM = substr($thisStartTime,0,5);
				}
				echo("<input onblur=\"checkTime(this,'start');\" name=\"start_time\" type=\"text\" size=\"6\" value=\"". $start_HHMM ."\" maxlength=\"5\">");
			}
			else
			{
				// Use JavaScript function to validate new dates.
				echo("<input onblur=\"checkTime(this,'start');\" name=\"start_time\" type=\"text\" size=\"6\" value=\"\" maxlength=\"5\">");
			}
		?>
			&nbsp; 
		<?php
			// Only do dynamic radio-buttons if we're updating and have a GET variable
			if(isset($thisEventID))
			{
				//First get the value of $StartAmPm for this record.
				$amPm_query = "	SELECT	start_AmPm 
								FROM	event_start 
								WHERE 	PK_startID = '$REL_startID' ";
				$amPm_result = mysql_query($amPm_query);
				if ($amPm_row = mysql_fetch_array($amPm_result))
				{
					// This var is used below.
					$startAmPm = $amPm_row['start_AmPm'];
				}
				//Show correct $StartAmPm choice among the radio buttons.
				if($startAmPm == "a.m.")
				{
					echo("<input type=\"radio\" name=\"start_AmPm\" value=\"a.m.\" checked>a.m. &nbsp;");
					echo("<input type=\"radio\" name=\"start_AmPm\" value=\"p.m.\">p.m.");
				}
				elseif($startAmPm == "p.m.")
				{
					echo("<input type=\"radio\" name=\"start_AmPm\" value=\"a.m.\">a.m. &nbsp;");
					echo("<input type=\"radio\" name=\"start_AmPm\" value=\"p.m.\" checked>p.m.");
				}
			}
			// Otherwise just default to 'a.m.' being selected by default.
			else
			{
				echo("<input type=\"radio\" name=\"start_AmPm\" value=\"a.m.\" checked>a.m. &nbsp;");
				echo("<input type=\"radio\" name=\"start_AmPm\" value=\"p.m.\">p.m.");
			}
			// Indicate that the time fields are optional.
			echo("<span class=\"formNote\">(NOTE: Entering a time is optional.)</span>");
		?>
		</td>
	</tr>
	<tr><!-- Vertical white space -->
		<td colspan="2">
			&nbsp;
		</td>
	</tr>
	
	<!-- ----------------------------------------------------- -->
	<!-- ---------------- END-OF-EVENT FIELDS ---------------- -->
	<!-- ----------------------------------------------------- -->
	<tr>
		<td class="formLabel">End of Event: </td>
		<td>
			<script language="JavaScript" type="text/javascript">
				/*
				** function toggleView() --
				** Toggle the display of the "end of event" fields on-click.
				*/
				function toggleView(isDifferentEnd)
				{
					if (isDifferentEnd.value == "yes")
					{
						document.all.endDate.style.display = "block";
						document.all.endTime.style.display = "block";
					}
					else if (isDifferentEnd.value == "no")
					{
						document.all.endDate.style.display = "none";
						document.all.endTime.style.display = "none";
					}
				}
			</script>
			<!-- Radio buttons to toggle visibility of end-of-event fields. -->
			<?php
				// Only do dynamic radio-buttons if we're updating and have a GET variable
				if(isset($thisEventID))
				{
					// First get the value of 'isDifferentEnd' field for this record.
					$isDifferentEnd = getIsDifferentEnd($thisEventID);
					// Now append the 'checked' attribute to the correct radio button.
					if($isDifferentEnd == "no")
					{
						echo("<input type=\"radio\" name=\"isDifferentEnd\" value=\"no\" checked onclick=\"toggleView(this);\">Same as start&nbsp;");
						echo("<input type=\"radio\" name=\"isDifferentEnd\" value=\"yes\" onclick=\"toggleView(this);\">Different");
					}
					else if($isDifferentEnd == "yes")
					{
						echo("<input type=\"radio\" name=\"isDifferentEnd\" value=\"no\" onclick=\"toggleView(this);\">Same as start&nbsp;");
						echo("<input type=\"radio\" name=\"isDifferentEnd\" value=\"yes\" checked onclick=\"toggleView(this);\">Different");
					}
				}
				// Otherwise, just show the radio-buttons with "no" ("same as start") as default.
				else
				{
			?>
					<input type="radio" name="isDifferentEnd" value="no" checked onclick="toggleView(this);">Same as start&nbsp;
					<input type="radio" name="isDifferentEnd" value="yes" onclick="toggleView(this);">Different
			<?php
				}
			?>
		</td>
	</tr>
	
		<!-- Date fields are not displayed by default. -->
		<?php
			//We're updating a record:
			if(isset($thisEventID))
			{
				// First get the value of 'isDifferentEnd' field for this record.
				$isDifferentEnd = getIsDifferentEnd($thisEventID);
				//control the CSS display/block properties
				if($isDifferentEnd == "no")
				{
					echo("<tr id=\"endDate\" style=\"display:none;\">");
				}
				else
				{
					echo("<tr id=\"endDate\" style=\"display:block;\">");
				}
			}
			//We're creating a brand new record.
			else
			{
				echo("<tr id=\"endDate\" style=\"display:none;\">");
			}
		?>
		<td class="formLabel">&nbsp;</td>
		<td>
			<select name="end_day">
		<?php
			//Make an array of the days of the week.
			$endDayName = array(1=>"Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
			//only append the "selected" attribute if we've got the GET variable $thisEventID
			if(isset($thisEventID))
			{
				// Get the $end_day that matches this event record's $REL_endID.
				$tableDay_query = "	SELECT	end_day 
									FROM 	event_end 
									WHERE	PK_endID = '$REL_endID' ";
				$tableDay_result = mysql_query($tableDay_query);
				// Loop thru table rows to get month options.
				if($tableDay_result)
				{
					// Append the 'selected' attribute if the row matches table record's $REL_endID.
					if($table_row = mysql_fetch_array($tableDay_result))
					{
						foreach($endDayName as $value)
						{
							// Append 'selected'.
							if($value == $table_row['end_day'])
							{
								echo("\t<option value=\"" . $value . "\" selected>" . $value . "</option>\n");
							}
							// Don't append 'selected'.
							else
							{
								echo("\t<option value=\"" . $value . "\">" . $value . "</option>\n");
							}
						}
					}
				}
				// Show error on bad query result.
				else
				{
					echo("<p class=\"error\">There's a problem with the SELECT query named 'tableDay_query': " . mysql_error() . "</p>\n");
				}
			}
			//If we're adding a new record, simply loop through the $endDayName array.
			else
			{
				foreach($startDayName as $value)
				{
					// Append the 'selected' attribute to the current day name.
					if ($value == date("l"))
					{
						echo("\t<option value=\"" . $value . "\" selected>" . $value . "</option>\n");
					}
					else
					{
						echo("\t<option value=\"" . $value . "\">" . $value . "</option>\n");
					}
				}
			}
		?>
			</select>&nbsp;
		
			<select name="end_month_num">
			<!-- Populate the month option list. -->
		<?php 
			// Get all the rows in the 'month' database table.
			$allMonths = "SELECT month_num, month_name FROM month";
			$allMonths_result = mysql_query($allMonths);
			//only append the "selected" attribute if we've got the GET variable $thisEventID
			if(isset($thisEventID))
			{
				// Get the $end_month_num that matches this event record's $REL_endID.
				$monthNum_query = "		SELECT	end_month_num 
										FROM	event_end 
										WHERE	PK_endID = '$REL_endID' ";
				$monthNum_result = mysql_query($monthNum_query);
				if($month_row = mysql_fetch_array($monthNum_result))
				{
					$thisMonthNum = $month_row['end_month_num']; // this var is used below.
				}
				// Proceed if we've got a good $allMonths query.
				if($allMonths_result)
				{
					// Loop thru table rows to get month options.
					while ($allMonthsRow = mysql_fetch_array($allMonths_result,MYSQL_ASSOC))
					{
						// Append the 'selected' attribute if the row matches this record's $REL_endID.
						if($allMonthsRow['month_num'] == $thisMonthNum)
						{
							echo("\t<option value=\"" . $allMonthsRow['month_num'] . "\" selected>" . $allMonthsRow['month_name'] . "</option>\n");
						}
						else
						{
							echo("\t<option value=\"" . $allMonthsRow['month_num'] . "\">" . $allMonthsRow['month_name'] . "</option>\n");
						}
					}
				}
				// If bad $allMonths query, show an error.
				else
				{
					echo("<p class=\"error\">Error in month SELECT query: " . mysql_error() . "</p>\n");
				}
			}
			//If we're adding a new record, simply loop through the month-number list
			else
			{
				while ($allMonthsRow = mysql_fetch_array($allMonths_result,MYSQL_ASSOC))
				{
					// Append the 'selected' attribute to the current month.
					if ($allMonthsRow['month_num'] == date("n"))
					{
						echo("\t<option value=\"" . $allMonthsRow['month_num'] . '\" selected>' . $allMonthsRow['month_name'] . "</option>\n");
					}
					else
					{
						echo("\t<option value=\"" . $allMonthsRow['month_num'] . "\">" . $allMonthsRow['month_name'] . "</option>\n");
					}
				}
			}
		?>
			</select>
			&nbsp;
			<select name="end_date_num">
			<!-- Populate the date option list. -->
		<?php 
			
			// Get all the rows in the 'date' database table.
			$allDates = "SELECT date FROM date";
			$allDates_result = mysql_query($allDates);
			//only append the "selected" attribute if we've got the GET variable $thisEventID
			if(isset($thisEventID))
			{
				// Get the $end_date_num that matches this event record's $REL_endID.
				$thisDate_query = "	SELECT	end_date_num 
									FROM	event_end 
									WHERE	PK_endID = '$REL_endID' ";
				$thisDate_result = mysql_query($thisDate_query);
				if($this_row = mysql_fetch_array($thisDate_result))
				{
					$thisDateNum = $this_row['end_date_num']; // this var is used below.
				}
				// Proceed if we've got a good $allDates query.
				if($allDates_result)
				{
					// Loop thru table rows to get date options.
					while ($allDatesRow = mysql_fetch_array($allDates_result,MYSQL_ASSOC))
					{
						// Append the 'selected' attribute if the row matches this record's $REL_endID.
						if($allDatesRow['date'] == $thisDateNum)
						{
							echo("\t<option value=\"" . $allDatesRow['date'] . "\" selected>" . $allDatesRow['date'] . "</option>\n");
						}
						else
						{
							echo("\t<option value=\"" . $allDatesRow['date'] . "\">" . $allDatesRow['date'] . "</option>\n");
						}
					}
				}
				// If bad $allDates query, show an error.
				else
				{
					echo("<p class=\"error\">Error in month SELECT query: " . mysql_error() . "</p>\n");
				}
			}
			//If we're adding a new record, simply loop through the date-number list
			else
			{
				for ($date = 1; $date <= 31; $date++)
				{
					// Append "selected" attribute to the current date value.
					if ($date == date("j"))
					{
						echo("\t<option value=\"" . $date . '\" selected>' . $date . "</option>\n");
					}
					else
					{
						echo("\t<option value=\"" . $date . "\">" . $date . "</option>\n");
					}
				}
			}
		?>
			</select>
			&nbsp;
			<?php
			// Only populate the field w/ data if we're updating and have the GET variable '$thisEventID'.
			if(isset($thisEventID))
			{
				// Get $end_year that matches this event record's $REL_endID.
				$endYear_query = "	SELECT	end_year 
									FROM 	event_end 
									WHERE 	PK_endID = '$REL_endID' ";
				$endYear_result = mysql_query($endYear_query);
				if($endYear_row = mysql_fetch_array($endYear_result))
				{
					// This var is used below.
					$recEndYear = $endYear_row['end_year'];
				}
				//Show year from the record.
				echo("<input type=\"text\" name=\"end_year\" size=\"4\" maxlength=\"4\" value=\"" . $recEndYear . "\">");
			}
			//Otherwise, just show the current year.
			else
			{
				echo("<input type=\"text\" name=\"end_year\" size=\"4\" maxlength=\"4\" value=\"" . date("Y") . "\">");
			}
		?>
		</td>
	</tr>
	
	<!-- Time fields are not displayed by default. -->
	<?php
		//We're updating a record.
		if(isset($thisEventID))
		{
			// First get the value of 'isDifferentEnd' field for this record.
			$isDifferentEnd = getIsDifferentEnd($thisEventID);
			// Control the CSS block/none display property.
			if($isDifferentEnd == "no")
			{
				echo("<tr id=\"endTime\" style=\"display:none;\">");
			}
			else
			{
				echo("<tr id=\"endTime\" style=\"display:block;\">");
			}
		}
		//We're creating a brand new record.
		else
		{
			echo("<tr id=\"endTime\" style=\"display:none;\">");
		}
	?>
		<td class="formLabel" align="right">Time (hh:mm): </td>
		<td>
		<?php
			// Only populate the field w/ data if we're updating and have the GET variable '$thisEventID'.
			if(isset($thisEventID))
			{
				// Get $end_time that matches this event record's $REL_endID.
				$thisend_query = "	SELECT	end_time 
									FROM 	event_end 
									WHERE 	PK_endID = '$REL_endID' ";
				$thisend_result = mysql_query($thisend_query);
				if($end_row = mysql_fetch_array($thisend_result))
				{
					// This var is used below.
					$thisendTime = $end_row['end_time'];
					//Lop the seconds off the time string.
					$end_HHMM = substr($thisendTime,0,5);
				}
				echo("<input onblur=\"checkTime(this,'end');\" name=\"end_time\" type=\"text\" size=\"6\" value=\"". $end_HHMM ."\" maxlength=\"5\">");
			}
			else
			{
				echo("<input onblur=\"checkTime(this,'end');\" name=\"end_time\" type=\"text\" size=\"6\" value=\"\" maxlength=\"5\">");
			}
		?>
			&nbsp; 
		<?php
			// Only do dynamic radio-buttons if we're updating and have a GET variable
			if(isset($thisEventID))
			{
				//First get the value of $endAmPm for this record.
				$amPm_query = "	SELECT	end_AmPm 
								FROM	event_end 
								WHERE 	PK_endID = '$REL_endID' ";
				$amPm_result = mysql_query($amPm_query);
				if ($amPm_row = mysql_fetch_array($amPm_result))
				{
					// This var is used below.
					$endAmPm = $amPm_row['end_AmPm'];
				}
				//Show correct $endAmPm choice among the radio buttons.
				if($endAmPm == "a.m.")
				{
					echo("<input type=\"radio\" name=\"end_AmPm\" value=\"a.m.\" checked>a.m. &nbsp;");
					echo("<input type=\"radio\" name=\"end_AmPm\" value=\"p.m.\">p.m.");
				}
				elseif($endAmPm == "p.m.")
				{
					echo("<input type=\"radio\" name=\"end_AmPm\" value=\"a.m.\">a.m. &nbsp;");
					echo("<input type=\"radio\" name=\"end_AmPm\" value=\"p.m.\" checked>p.m.");
				}
			}
			// Otherwise just default to 'a.m.' being selected by default.
			else
			{
				echo("<input type=\"radio\" name=\"end_AmPm\" value=\"a.m.\" checked>a.m. &nbsp;");
				echo("<input type=\"radio\" name=\"end_AmPm\" value=\"p.m.\">p.m.");
			}
			// Indicate that the time fields are optional.
			echo("<span class=\"formNote\">(NOTE: Entering a time is optional.)</span>");
		?>
		</td>
	</tr>
	
	<tr><!-- Vertical white space -->
		<td colspan="2">
			&nbsp;
		</td>
	</tr>
	<tr>
		<td class="formLabel">&nbsp;</td>
		<td>
			<!-- Hidden form-field to pass the PK_newsID field value onsubmit. -->
			<input type="hidden" name="PK_eventID" value="<?php echo($PK_eventID); ?>">
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
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
<?php
	include("includes/form_end.php");
?>