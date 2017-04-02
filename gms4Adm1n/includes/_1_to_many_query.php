
<?php
/*
**	MODEL QUERY FOR GETTING DATA MATCHED BETWEEN TABLES 'event' and
**	'event_start' OR 'event_end'.
*/
	// Get $start_month_name that matches this event record's $REL_startID.
	$monthName_query = "	SELECT	start_month_name 
							FROM	event_start 
							WHERE	PK_startID = '$REL_startID' ";
	$monthName_result = mysql_query($monthName_query);
	if($month_row = mysql_fetch_array($monthName_result))
	{
		// This var is used below.
		$thisMonthName = $month_row['start_month_name'];
	}
?>