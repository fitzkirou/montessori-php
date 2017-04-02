<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>
		<?php 
			echo ("Events Calendar - " . ORGANIZATION);
		?>
	</title>
	<meta name="keywords" content="Montessori, montessori, Guelph, Ontario, private, school, primary, elementary, curriculum">
	<meta name="description" content="An AMI certified Montessori school that uses concrete materials to teach children about language, culture, geography, and practical life skills.">
	<!-- Link to stylesheet -->
	<link href="includes/frontend.css" rel="stylesheet" type="text/css" media="all">

	<script language="JavaScript" type="text/javascript">
		// Open a window for the event detail text.
		function openEventDetail (the_event_ID, event_type) {
			// Build the event's URL.
			eventURL = "event_detail.php?PK_eventID=";
			eventURL = eventURL + the_event_ID;
			// Launch the window.
			theWindow = window.open(eventURL,"eventDetail","width=324,height=200,scrollbars=auto");
		}
	</script>
</head>

<body bgcolor="#E0E9F2" background="images/bg_texture.gif">

<!-- Set width to not requrire horizontal scrolling -->
<!-- on an 800x600-pixel resolution monitor. -->

<div class="rectPageBox">

	<!-- Comment out "Close calendar" button because not relevant to context. -->
	<!-- <a class="code" href="javascript:window.close();">&nbsp;Close calendar&nbsp;</a> -->
	
	<!-- Single-row, two-column table for calendar title and legend. -->
	<table width="100%" cellpadding="0" border="0" cellspacing="0">
		<tr>
			<td valign="bottom">
				<!-- Calendar Title -->
				<h1>
				<?php
					echo (ORGANIZATION . "<br />");
					
					// Control for one versus two calendar years.
					if (IS_ONE_YEAR)
					{
						echo($thisYear);
					}
					else
					{
						$nextYear = $thisYear + 1;											
						echo($thisYear . "&ndash;" . $nextYear);
					}
					
					echo (" Calendar");
				?>
				</h1>
			</td>
			<td align="right" valign="bottom">
			
			<!-- Calendar Legend -->
			<div align="left" id="calLegend">
				<strong>LEGEND</strong><br />
				<?php
				$types_query = "SELECT DISTINCTROW code, type
								FROM event
								ORDER BY code ASC";
				$types_result = mysql_query ($types_query);
				if ($types_result)
				{
					while ($theRow = mysql_fetch_array($types_result))
					{
						echo ('<span class="calCode">' . $theRow['code']);
						echo ('</span> - ' . $theRow['type'] . "<br />\n");
					}
				}
				else
				{
					echo ('<p class="error">ERROR: There\'s been a system error in querying the database.</p>');
					exit;
				}
				?>
			</div>

			</td>
		</tr>
	</table>
	<br />
	
	<!-- Calendar's two header rows -->
	<!-- NOTE: Total number of <td> cells per row was ORIGINALLY 36. -->
	<table width="100%" cellpadding="3" border="0" cellspacing="0">
	<tr>
		<td>&nbsp;</td>
		<td colspan="36" style="font-size:11px;">
			<!--"Plug in to Calendar" blurb-->
        	<p>
        		<a href="http://guelphmontessori.com/plug_calendar.php"><img align="left" style="margin-right:7px;" src="images/Plug_and_outlet.gif" title="Plug in your calendar"  alt="Plug in your calendar" border="0"></a>
        		<p>Never miss a GMS event!<br>
        		<a href="http://guelphmontessori.com/plug_calendar.php">Plug into our online calendar</a>
        		<br>with your calendaring software and/or email program.</p>
        	</p>
			
			NOTE: The following event dates are subject to change. Use this 
			calendar frequently to verify dates as the year progresses.
		</td>
	</tr>
	<tr>
		<td rowspan="2">&nbsp;</td> <!-- Leave top-left corner blank. -->
		<th class="weekHeader" colspan="7">Week 1</th>
		<th class="weekHeader" colspan="7">Week 2</th>
		<th class="weekHeader" colspan="7">Week 3</th>
		<th class="weekHeader" colspan="7">Week 4</th>
		<th class="weekHeader" colspan="7">Week 5</th>
		<!-- Blank (for Sunday, Monday) -->
		<th class="weekHeader" colspan="7">&nbsp;</th>
	</tr>
	<tr>
		<td class="weekendDay">S</td>
		<td class="daysHeader">M</td>
		<td class="daysHeader">T</td>
		<td class="daysHeader">W</td>
		<td class="daysHeader">T</td>
		<td class="daysHeader">F</td>
		<td class="weekendDay">S</td>
		<td class="weekendDay">S</td>
		<td class="daysHeader">M</td>
		<td class="daysHeader">T</td>
		<td class="daysHeader">W</td>
		<td class="daysHeader">T</td>
		<td class="daysHeader">F</td>
		<td class="weekendDay">S</td>
		<td class="weekendDay">S</td>
		<td class="daysHeader">M</td>
		<td class="daysHeader">T</td>
		<td class="daysHeader">W</td>
		<td class="daysHeader">T</td>
		<td class="daysHeader">F</td>
		<td class="weekendDay">S</td>
		<td class="weekendDay">S</td>
		<td class="daysHeader">M</td>
		<td class="daysHeader">T</td>
		<td class="daysHeader">W</td>
		<td class="daysHeader">T</td>
		<td class="daysHeader">F</td>
		<td class="weekendDay">S</td>
		<td class="weekendDay">S</td>
		<td class="daysHeader">M</td>
		<td class="daysHeader">T</td>
		<td class="daysHeader">W</td>
		<td class="daysHeader">T</td>
		<td class="daysHeader">F</td>
		<td class="weekendDay">S</td>
		<!-- Additional days in "week 6". -->
		<td class="weekendDay">S</td>
		<td class="daysHeader">M</td>
		<td class="daysHeader">T</td>
	</tr>
	