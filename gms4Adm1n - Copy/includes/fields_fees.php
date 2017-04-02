<?php
	/*	------------------------------------------------------------------
		Set up the HTML form (including the ACTION attribute).
		------------------------------------------------------------------ */
	include("includes/form_start.php");
	
	// String matching module (Used in function just below.)
	function isDayString($feeName)
	{
		// 2nd logical condition refers to 'Days/Week' cases.
		if ( ereg(' Day',$feeName) AND !ereg('Days',$feeName) )
			return true;
		else 
			return false;
	}
	
	// Module (called below) for this page only.
	// Build HTML table-row for each fee in the 'fee' db table.
	function showFees()
	{	
		// Row for user guidlines.
		$html  = '<tr><td colspan="2" style="position:relative; left:6px;">';
		$html .= '<br><span style="color:#C00;"><b>NOTE 1:</b> Enter your fees to the nearest dollar.<br>Do <em>not</em> use dollar-signs, commas, or decimal points.<br><b>NOTE 2:</b> Enter the academic years in the last two rows below.</span><br><hr width="98%" align="left">';
		$html .= '</td></tr>' . "\n";
		
		// Query the database's "fee" table.
		$getAllFees  = 'SELECT * 	FROM fee';
		$getAllFees .= ' ORDER BY   fee_id ASC';
		$result = mysql_query($getAllFees);

		// To control $-sign display in loop below, count the records in the 'fee' table.
		$rsltAllRecords = mysql_query('SELECT COUNT(*) FROM fee');
		if ($row = mysql_fetch_row($rsltAllRecords)) 
			$numberOfRecords = $row[0];
		else
			die('ERROR: Due to a mySQL query error, the fee records could not be counted.');

		// Loop to show each fee's name and current value.
		// N.B.  NAME TEXT FIELDS SEQUENTIALLY WITH APPENDED $iteration NUMBER.
		$iteration = 1;			
		while ( $row = mysql_fetch_array($result) )
		{
			// Start row, and show fee-name column
			$html .= "\n" . '<tr><td>' . "\n\t";      //<td class="formLabel" ...
			// Prepend "Primary " where appropriate.
			if ( isDayString($row['fee_name']) ) {
				$html .= 'Primary ';
			}
			$html .= $row['fee_name'] . '&nbsp;&nbsp;&nbsp;</td>';
			// Show amount.
			$html .= "\n\t<td>";
			$html .= '<input class="dollarBox" type="text"';
			$html .= ' size="5" maxlength="5" ';
			$html .= 'name="amount_'.$iteration.'" value="'.$row['amount'].'">';
			// For unit-based fees, append the unit basis:
			if ($row['isUnitBased'] == 1)
				$html .= ' per ' . $row['unit'] . '.';
			// End right-hand column & the row.
			$html .= "</td>\n</tr>\n\n";
			// Increment the counter.
			$iteration++;
		}
		return $html;
	}
	
	// Display all fields and their values.
	echo showFees();
?>

	<!-- Submit-button row -->
	<tr valign="top">
		<td colspan="2">
			<hr width="98%" align="left">
			<?php
				// For the submit button, set the value of the name
				// attribute based on the $process variable's value.
				if($process == "Add") 
					echo("<input type=\"submit\" name=\"submit\" value=\"Add fee\">");
				elseif($process == "Edit") 
					echo("<input type=\"submit\" name=\"submit\" value=\"Update values\">");
			?>
			<!-- "Cancel" button functions as a "Back" button. -->
			&nbsp;<input name="cancel" type="button" onClick="window.history.back();" value="Cancel">
			<br><br>
		</td>
	</tr>

<!-- -------------------------------- -->
<!-- Include the 'form_end.php' file. -->
<!-- -------------------------------- -->
<?php
	include("includes/form_end.php");
?>