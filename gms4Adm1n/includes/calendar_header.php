<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>
		<?php 
			echo ("Website Administration - " . ORGANIZATION);
		?>
	</title>
	<meta name="keywords" content="Montessori, montessori, Guelph, Ontario, private, school, primary, elementary, curriculum">
	<meta name="description" content="An AMI certified Montessori school that uses concrete materials to teach children about language, culture, geography, and practical life skills.">
	<!-- Link to stylesheet -->
	<link href="../includes/frontend.css" rel="stylesheet" type="text/css" media="all">
</head>

<body background="../images/bg_texture.gif">

<!-- Image Map / header -->
<img name="h_nav_backend" src="images/h_nav_backend.gif" width="745" height="149" border="0" usemap="#h_nav_backend">
<map name="h_nav_backend">
	<area shape="rect" coords="144,100,254,115" href="event_main.php">
	<area shape="rect" coords="274,100,443,115" href="admin_calendar.php">
	<area shape="rect" coords="460,100,552,115" href="news_main.php">
	<area shape="rect" coords="567,100,616,115" href="index.php">
</map>
<br><br><br>

<div class="rectPageBox" style="width:95%; text-align:left; background-color:#ccc;">

	<table width="100%" cellpadding="3" border="0" cellspacing="0">
	<!-- NOTE: Total number of <td> cells per row is 36. -->
	
	<tr>
		<td colspan="36" nowrap>
			<!-- Calendar Title -->
			<h1 class="formTitle" style="position:relative; left:-10px; top:-10px; padding-top:5px;">
			<?php
				echo ("&nbsp;Edit School-Year Calendar, ");
				
				// Control for one versus two calendar years.
				if (IS_ONE_YEAR)
				{
					echo($systemYear);
				}
				else
				{
					echo($systemYear . "&ndash;" . $nextYear);
				}
			?>
			</h1>
			
			<!-- Calendar Legend -->
			
    <div align="left" id="calLegend" style="position:relative; left:-10px; top:-29px; width:100%;"> 
      <strong>LEGEND:</strong> 
      <?php
				$types_query = "SELECT DISTINCTROW code, type
								FROM event
								ORDER BY code ASC";
				$types_result = mysql_query ($types_query);
				if ($types_result)
				{
					while ($theRow = mysql_fetch_array($types_result))
					{
						echo ('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
						echo ('<span class="calCode">' . $theRow['code']);
						echo ('</span> - ' . $theRow['type'] . "\n");
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
	<tr>
		<td rowspan="2">&nbsp;</td> <!-- Leave top-left corner blank. -->
		<th class="weekHeader" colspan="7">Week 1</th>
		<th class="weekHeader" colspan="7">Week 2</th>
		<th class="weekHeader" colspan="7">Week 3</th>
		<th class="weekHeader" colspan="7">Week 4</th>
		<th class="weekHeader" colspan="7">Week 5</th>
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
	</tr>
	