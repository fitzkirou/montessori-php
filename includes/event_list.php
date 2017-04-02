<?php
	/* ***********************************************************
	** Show the title, date/time, and location of each event.
	** ***********************************************************
	*/
	
	include("gms4Adm1n/includes/library.php");
	
	/*
	** ******************** Mainline Logic ********************
	*/
	$events_result = getEvents();
	loopThruEvents($events_result);
	
	/*
	** ******************** Function Definitions ********************
	*/
	/*
	** Retrieve the active event records.
	*/
	function getEvents()
	{
		//Find the events whose isActive field is flagged 'yes',
		//and limit results to matching event IDs and start/end IDs.
		$events_query = "	SELECT		e.*, s.*, f.* 
							FROM		event		AS e, 
										event_start AS s, 
										event_end	AS f 
							WHERE 		s.PK_startID = e.REL_startID 
							AND			f.PK_endID = e.REL_endID 
							AND			e.isActive='yes'
							ORDER BY	s.start_year, 
										s.start_month_num, 
										s.start_date_num
						";
		$events_result = mysql_query($events_query);
		if($events_result)
		{
			//check num rows
			$numRows = mysql_num_rows($events_result);
			if($numRows == 0)
			{
				echo("<p>Currently, there are no upcoming school dates.</p>");
				return;
			}
			else
			{
				//We've got at least one row, so return the result.
				return($events_result);
			}
		}
		else
		{
			echo("<p class=\"error\">Error in query named 'events_query'.</p>");
			return;
		}
	}
	
	/*
	** Loop thru the result set, printing each event to the screen.
	*/
	function loopThruEvents($events_result)
	{
		while($event_row = mysql_fetch_array($events_result))
		{
			showEvent($event_row);
		}
	}
	
	/*
	** Output and format the event.
	*/
	function showEvent($event_row)
	{
		echo("<p>");
		echo("<span class=\"eventTitle\">" . $event_row['title'] . "</span><br>");
		//next 2 functions are in gms4Adm1n/includes/library.php
		showDateTime($event_row);
		showLocation($event_row);
		echo("</p>");
	}
?>