<?php

	/*
	** Project: WEBadmin - Guelph Montessori School
	** Version: 1.0
	** File: test_event_type.php
	** Purpose: Test output of a simple SELECT query on the 'event_type' table.
	** Author: Bob Young, September 2003.
	*/
	error_reporting(E_ALL);
	
	
	function getAllTypes()
	// SQL query to return all records (in all fields) from 'event' table.
	{
		$sql = 'SELECT * ';
		$sql .= 'FROM event';
		$the_result_set = mysql_query ($sql);

		if ($the_result_set != FALSE)
		{
			return ($the_result_set);
		}
		else
		{
			echo ('<p style="color:red; font-weight:bold; background-color:white;">');
			echo ('ERROR: the query \'$sql\' failed.');
			echo ('</p>');
			exit;
		}
	}
	
	
	function showTypes ($query_result)
	// Show all rows, with fields separated by a comma and space.
	{
		while ($row = mysql_fetch_array($query_result))
		{
			echo ('<p style="color:black; background-color:white;">');
			echo($row['PK_eventID'] . ", " . $row['title'] . ", " . $row['isDifferentEnd']);
			echo ('</p>');
		}
	}
	
	
	/*	------------------------------------------------------------------
		MAINLINE LOGIC
		------------------------------------------------------------------ */
	include("includes/library.php"); //Include shared modules.
	$isViewAllLinked = true; //Define global variables.
	$process = "Add";
	$item = "upcoming date";
	$action = "event_add.php";
	
	// Include header.php, open MySQL connection, and select 'guelphm_web' database.
	prepare($isViewAllLinked, $process, $item, $action);
	
	echo ('<h2 style="color:black;">Output from SELECT query on \'event\'</h2>');
	
	$query_result = getAllTypes();
	showTypes($query_result);
	
	// Include footer.php and close the connection to MySQL server.
	finishUp();
	
?>
