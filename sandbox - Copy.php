<?php
$title = "Home";
include("includes/header.php");
?>

<!-- This style rule is a hack to get the content sub-table properly aligned. -->
<style type="text/css">
	#contentBox {
		position: relative;
		left: 9px;
	}
</style>
<table id="contentBox" width="560" border="0" cellspacing="0" cellpadding="0">
    <tr><!-- Date heading text & feature links (text and image). -->
        <td class="feature" valign="top" style="background-color:white;" width="270" valign="top">
			
			<p><!--TV Ad link-->
				<a href="tv_anim.html" target="_blank"><img src="images/tv_set.jpg" align="absmiddle" alt="" border="0"></a>&nbsp;
        		<a href="tv_anim.html" target="_blank">Watch our 35 sec. TV ad</a>
        	</p>
			<!-- Upcoming Dates -->
			<div class="feature">
			
				<!-- Show list of active events (upcoming school dates). -->
				<h1 class="homeSubhead">Upcoming School Dates</h1>
<?php
	/* ---------------------------------------------------------------------
	** Show the title, date/time, and location of each event.
	** ---------------------------------------------------------------------
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
							ORDER BY	s.start_year, s.start_month_num, s.start_date_num ";
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

			</div>
		</td>
        <td width="20">&nbsp;</td>
        <td class="feature" valign="top" style="background-color:white;" width="270" valign="top">
        	<!-- Link to Parent Tools sign-in -->
        	<div class="feature" style="padding-bottom: 10px; padding-top: 7px;">
        		<a href="prnt10g1n.php"><img src="images/ptools_teacher.gif" alt="Sign in" align="left" hspace="5" width="41" height="44" border="0"></a>
        		<a href="prnt10g1n.php">Parent Tools</a>.<br>Sign in to view parents-only information.
        	</div>
        
        	<!--"Plug in to Calendar" blurb-->
        	<p>
        		<a href="http://guelphmontessori.com/plug_calendar.php"><img align="right" src="images/Plug_and_outlet.gif" title="Plug in your calendar"  alt="Plug in your calendar" border="0"></a>
        		Never miss a GMS event! 
        		<a href="http://guelphmontessori.com/plug_calendar.php">Plug into our online calendar</a>
        		 with your calendaring software and/or email program.
        		<hr width="100%">
        	</p>
        	<p>
        		<!-- Video link. -->
        		<a href="https://www.youtube.com/watch?v=09Y-huCMjIc&feature=youtu.be" target="_blank"><img src="images/Mont-Morning-Video.jpg" alt="" width="265" height="185" border="0"></a>
 				<br /><br />
				<hr width="100%">
        	</p>
        	        	
			<!-- Show teasers to active news items. -->
			<?php
			// Show the News heading
			print ("<h1 class=\"homeSubhead\">News Items</h1>");
			
			/* ---------------------------------------------------------------------
			** Show the title and first sentence of each active news item.
			** ---------------------------------------------------------------------
			*/
			// Query to retreive ACTIVE news records.
			$active_query = "SELECT		*
							 FROM		news_item
							 WHERE		isActive='yes'
							 ORDER BY	REL_yearID ASC, REL_monthID ASC, REL_dateID ASC";
			$active_result = mysql_query($active_query);
			// Find the number of returned rows.
			if ($active_result)
			{
				$active_rows = mysql_num_rows($active_result);
			}
			else
			{
				echo("Error in SELECT query: " . mysql_error());
			}
			// Show the data if we have at least one row returned.
			if ($active_rows > 0)
			{
				// Loop thru returned rows, displaying title & a bit of the text.
				while ($row = mysql_fetch_array($active_result,MYSQL_ASSOC))
				{
					echo("<p class=\"teaser\">\n");
					
					echo("<span class=\"featureTitle\">" . $row['title'] . "</span><br>\n");
					//Truncate $teaser to 120 characters and show it.
					$teaser = substr($row['main_text'],0,80);
					echo($teaser);

					// Add a closing bold tag </b> if $teaser contains an opening angle bracket "<".
					$teaserLength = strlen($teaser);
					for ($i = 0; $i < $teaserLength; $i++)
					{
						$character = substr($teaser, $i, 1);
						if ($character == "<")
						{
							echo ("</b>\n");
						}
					}
					
					echo(" ... <a class=\"teaserLink\"");
					// Control access for signed-in parents vs. joe visitor.
					// 2ND CLAUSE IS CURRENTLY NOT WORKING. 20-Oct-2011. B. Young.
					if ($_SESSION['isSignedIn']) 
						echo (" href=\"news_detail.php?PK_newsID=" . $row['PK_newsID'] . "\">More</a>");
					else
						echo (" href=\"prnt10g1n.php?isFromHome=1&newsID=" . $row['PK_newsID'] . "\">More</a>");
					
					echo("</p>\n");
				}
			}
			// Indicate if there are no records.
			else
			{
				echo("Currently, there are no news items.\n");
			}
		?>
		</td>
    </tr>
    <tr><!-- White space -->
        <td colspan="3">
        <!--EcoSchools Newsletter link-->
        	<br>
        	<a href="http://www.ontarioecoschools.org/" target="_blank" title="Learn about Eco Schools"><img align="left" src="images/EcoSchool-banner-Mini.gif" style="margin-right:7px; border-right:2px solid #000000; border-bottom:2px solid #000000;" height="35" width="120" alt="View newsletter" border="0"></a>
        	<em>Eco Maniacs</em> <a href="upload/es_news.pdf" target="_blank" title="View newsletter">newsletter</a> 
        	is written and published bi-monthly by the GMS Upper Elementary students.
        	<br><br>
        </td>
    </tr>
    <tr><!-- Mission statement -->
        <td colspan="3" valign="top">
			<h1 class="homeSubhead">Mission Statement</h1>
			<p>At the Guelph Montessori School our Mission is to provide within a nurturing environment a well-balanced instructional Montessori program that will enable all students to reach their highest level of academic success.</p>
			<p>The staff is committed to creating a student-centered educational environment that stresses high expectations and addresses the physical, social and emotional needs of children with a variety of ability levels and learning styles.</p>
			<p>Our goal is to maintain an active partnership involving students, teachers, parents, community and staff to develop a love of learning while embracing our diversity and unique talents in a safe, challenging, respectful and supportive environment.</p>
			<br>
			
			<!-- Affiliations -->
			<h1 class="homeSubhead">
				Affiliations
			</h1>
			<!--Subtable for logos & blurbs-->
			<table style="text-align: left; width: 100%;" border="0" cellpadding="0" cellspacing="0">
				<tbody>
				<tr><!--Logos-->
					<td style="vertical-align: top;" width="48%">
						<a href="http://www.montessori-namta.org/" target="_blank"><img src="images/namta_logo.gif" alt="NAMTA logo" border=0 height=112 width=38 align="left"></a>
						We are members of the North American Montessori Teachers' Association (<a href="http://www.montessori-namta.org/" target="_blank">NAMTA</a>).
					</td>
					<td style="vertical-align: top;" width="4%">&nbsp;<br>
					</td>
					<td style="vertical-align: top;" width="48%">
						<a href="http://www.ontarioecoschools.org/" target="_blank"><img src="images/eco-seal.gif" border="0" height="125" width="125" align="left" hspace="3"></a>
						We have Platinum status with the <a href="http://www.ontarioecoschools.org/" target="_blank">Ontario EcoSchools</a> environmental education program.<!-- A school can be recognized for its annual achievement in 4 key areas: energy conservation, waste minimization, ecological literacy and school ground greening.--></p>
					</td>
				</tr>
				<tr><!--Spacer row-->
					<td style="vertical-align: top;" colspan="3">&nbsp;<br>
				</td>
				</tr>
				<tr><!--Logos-->
					<td style="vertical-align: top;">
						<a href="http://www.bbb.org/canada/" target="_blank"><img src="images/better-biz-bureau-logo.gif" alt="" border="0" height="" width="" align="left"></a>
						We are accredited with the Better Business Bureau. <a href="http://www.bbb.org/canada/" target="_blank">BBB</a> is an unbiased organization that sets and upholds high standards for fair and honest business behavior.
					</td>
					<td style="vertical-align: top;">&nbsp;<br>
					</td>
					<td style="vertical-align: top;">
						&nbsp;
					</td>
				</tr>
				</tbody>
			</table>
			
		</td>
    </tr>
</table>

			<div class="copyright">
				Copyright &copy; Guelph Montessori School, <?php echo(date(Y)); ?><!--Link to EcoSchools upload page:--><a href="http://guelphmontessori.com/upload/admin/">.</a>
			</div>

			<!-- Body content ends. -->
		</td>
		<!-- Right gutter -->
		<td width="75" valign="top">&nbsp;</td>
	</tr>

	<tr><!-- White space below content -->
		<td colspan="3" width="605" valign="top">&nbsp;
			
		</td>
	</tr>
<!-- End of page container table -->
</table>

<div class="footer">

	<style type="text/css">
		.MySQL {
			position: relative;
			top: -7px;
		}
	</style>

	<!-- GMS address info -->
	Guelph Montessori School, 151 Waterloo Avenue, Guelph, ON Canada N1H 3H9<br />
	<strong>(519) 836-3810</strong>. E-mail: <a href="mailto:guelphmontessori@rogers.com">guelphmontessori@rogers.com</a>
	<br />

</div>

</div>

</body>
</html>

<?PHP
	mysql_close($dbh);
?>
