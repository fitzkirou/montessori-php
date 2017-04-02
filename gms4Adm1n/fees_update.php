<?php
	/*
	** Project: /admin - Guelph Montessori School
	** File: fees_update.php
	** Purpose: Takes user input and updates ALL fee records into the database.
	** Author: Bob Young, Jan 2006.
	*/
	include("includes/library.php"); //Include shared modules.

	// Define global variables.
	$isViewAllLinked = false; 
	$process = "Edit";
	$item = "tuition &amp; fee";
	$action = $_SERVER['PHP_SELF'];
	
	
	/* **************************************************************************
	** Mainline Logic
	** **************************************************************************
	*/
	prepare($isViewAllLinked,$process,$item,$action);
	
	// process the form only if the submit button has been clicked
	if (isset($_POST['submit']))
		updateFees();
	// otherwise get all fee records and populate the form fields.
	else 
		include_once('includes/fields_fees.php');

	finishUp();
	
	
	/* **************************************************************************
	** Custom module definitions
	** **************************************************************************
	*/	
	function updateFees()
	{
		// Count the records in the 'fee' table.
		$rsltAllRecords = mysql_query('SELECT COUNT(*) FROM fee');
		if ($row = mysql_fetch_row($rsltAllRecords)) 
			$numberOfRecords = $row[0];
		else
			die('ERROR: Due to a mySQL query error, the fee records could not be counted.');
		
		// Loop to update each fee record's 'amount' field.
		for ($i=1; $i<=$numberOfRecords; $i++) 
		{
			// Build the query.
			$qryUpdate  =  'UPDATE	fee';
			$qryUpdate .=  ' SET	amount=' . $_POST["amount_{$i}"];
			$qryUpdate .=  ' WHERE	fee_id=' . $i;
			// Run the query.
			$result = mysql_query($qryUpdate);
			// Exit if query failed.
			if (! $result) {
				die('ERROR: No records updated. <br><br>MySQL said: ' . mysql_error());
			}
			// Destroy the $qryUpdate var.
			unset($qryUpdate);
		}
		confirmUpdate();
	}
	
	
	function confirmUpdate()
	{
		// --------------------------------------
		// Show a confirmation of entered data...
		// --------------------------------------
		//Open the table and form.
		include("includes/form_start.php");
		//Open table-row wrapper.
		echo("<tr class=\"feedback\" valign=\"top\">\n");
		echo("<td class=\"feedback\" colspan=\"2\>\n");
		//Print confirmation content.
		echo("<div class=\"feedback\"><br><br>\n");
		echo 'SUCCESS! The Guelph Montessori fees were updated. Browse to the ';
		echo 'public website to verify the amounts:<br><br> ';
		echo '<a target="_blank" href="http://guelphmontessori.com/fees.php">guelphmontessori.com/fees.php</a>';
		echo '<br><br><br><br><br><br><a href="index.php">&lt;&lt; Home/Help</a>';
		echo "<br><br></div>\n";
		//Close table-row wrapper.
		echo("</td></tr>\n");
		//Close the table and form.
		include("includes/form_end.php");
	}
	
?>
