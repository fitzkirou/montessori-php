<!--Input form starts-->
<form action="<?php echo($action); ?>" method="post">
	<table class="inputTable" width="586" cellpadding="0" cellspacing="0">
	<tr>
		<td class="areaTitle" colspan="2">
		<div class="areaTitle">
			<?php echo($item . "s"); ?>
		</div>
		</td>
	</tr>
	<tr>
		<td class="formTitle" colspan="2">
			<div class="formTitle">
				<?php 
				//Show the form's title.
				echo($process);
				if($item=="news item") {
					echo(" a ");
				}
				elseif($item=="upcoming date") {
					echo(" an ");
				}
				else {
					echo(" a ");
				}
				echo($item);
				?>
			</div>
		</td>
	</tr>
	<tr valign="top">
		<td class="formLabel">Show on website? </td>
		<td> 
			<label class="formText">
			<input type="radio" name="isActive" value="yes" checked>
			Yes</label>
			<br>
			<label class="formText">
			<input type="radio" name="isActive" value="no">
			No</label>
		</td>
	</tr>
	<tr valign="top">
		<td class="formLabel">Headline: </td>
		<td>
			<input name="title" type="text" size="50">
		</td>
	</tr>
	<tr valign="top">
		<td class="formLabel">First sentence: </td>
		<td>
			<textarea name="first_sentence" cols="50" rows="3"></textarea>
		</td>
	</tr>
	<tr valign="top">
		<td class="formLabel">Body text: </td>
		<td>
			<textarea name="main_text" cols="50" rows="7"></textarea>
		</td>
	</tr>
	<tr valign="top">
		<td class="formLabel">Critical date: </td>
		<td>
			<select name="REL_monthID">
			<!-- Populate the month option list. -->
			<?php 
				// Get all the rows in the 'month' database table.
				$allMonths = "SELECT month_num, month_name FROM month";
				$allMonths_result = mysql_query($allMonths);
				if($allMonths_result)
				{
					// Loop thru table rows to get month options.
					while ($row = mysql_fetch_array($allMonths_result,MYSQL_ASSOC))
					{
						echo("\t<option value=\"" . $row['month_num'] . "\">" . $row['month_name'] . "</option>\n");
					}
				}
				else
				{
					echo("<p class=\"error\">Error in month SELECT query: " . mysql_error() . "</p>");
				}
			?>
			</select>
			&nbsp;
			<select name="REL_dateID">
			<!-- Populate the date option list. -->
			<?php 
				// Get all the rows in the 'date' database table.
				$allDates = "SELECT date FROM date";
				$allDates_result = mysql_query($allDates);
				if($allDates_result)
				{
					// Loop thru table rows to get month options.
					while ($row = mysql_fetch_array($allDates_result,MYSQL_ASSOC))
					{
						echo("\t<option value=\"" . $row['date'] . "\">" . $row['date'] . "</option>\n");
					}
				}
				else
				{
					echo("<p class=\"error\">Error in date SELECT query: " . mysql_error() . "</p>");
				}
			?>
			</select>
			&nbsp;
			<select name="REL_yearID">
			<!-- Populate the year option list. -->
			<?php 
				// Get all the rows in the 'year' database table.
				$allYears = "SELECT year FROM year";
				$allYears_result = mysql_query($allYears);
				if($allYears_result)
				{
					// Loop thru table rows to get month options.
					while ($row = mysql_fetch_array($allYears_result,MYSQL_ASSOC))
					{
						echo("\t<option value=\"" . $row['year'] . "\">" . $row['year'] . "</option>\n");
					}
				}
				else
				{
					echo("<p class=\"error\">Error in year SELECT query: " . mysql_error() . "</p>");
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
			<input type="submit" name="submit" value="Add"> <input name="cancel" type="button" onClick="window.history.back();" value="Cancel">
		</td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	</table>
</form>
<!--Input form ends-->