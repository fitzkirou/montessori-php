<?php
$title = "Plug into the School Calendar";
include("includes/header.php");
echo("<h1>" . $title . "</h1>");
?>

<p>Do you depend on the calendar on your computer or smart phone? Tired of manually adding 
school events? Well, now you can plug 
directly into Guelph Montessori's online calendar, so that 
events appear automatically in your computer's or smart phone's calendar. So say goodbye to 
typos and save time!</p>

<!--GENERAL INSTRUCTIONS-->
<hr>
<h3>General Instructions</h3>
<p>The two steps below are what you basically need to do. However, if this is unclear, 
scoll down and find the specific instructions for your calendar/email software.</p>
<ol>
	<li>Add a "network" calendar or "subscribe" to an iCal (or .ics) format calendar at <em>http://guelphmontessori.com/calendar.php</em>.</li>
	<li>If there's a read-only option, select that for this calendar.</li>
</ol>

<!--DETAILED INSTRUCTIONS FOR SOFTWARE-->
<hr>
<h3>Instructions for Your Software</h3>
<p>We have compiled detailed instructions for the following calendar/email software. We will 
add instructions for other programs as the need arises.</p>

<p><strong>For Mac Users</strong>
	<ol>
		<li>In iCal, follow the steps to create a new calendar. (You can name it "School Calendar" or whatever.)</li>
		<li>Select the option to "subscribe."</li>
		<li>For the location, copy and paste the following URL: <br><em>http://guelphmontessori.com/calendar.php</em></li>
		<li>Sync your iPhone. (The iCal program will now automatically sync new school events to your calendar.)</li>
	</ol>
</p>

<p><strong>Thunderbird with Lightning</strong><br>
If you use <a href="http://www.mozillamessaging.com/en-US/thunderbird/">Mozilla Thunderbird</a> 
for email and Thunderbird's <a href="http://www.mozilla.org/projects/calendar/">Lightning</a> calendar add-on, follow these steps:
	<ol>
		<li>In the Calendar pane, right-click and select "new calendar."</li>
		<li>Select to create a calendar "on the network."</li>
		<li>Use the "iCalendar (ICS)" option, and use <em>http://www.guelphmontessori.com/calendar.php</em> as the location.</li>
		<li>Type a name for this calendar (e.g., School Calendar), select a colour, and select "none" as the associated emai account. Don't select "show alarms." Then click "Done."</li>
		<li>In the Calendar pane, right-click on the new calendar, select Properties, and select the "read-only" option.</li>
	</ol>
</p>

<!--footer-->
<br><br>
			<div class="copyright">
				Copyright &copy; Guelph Montessori School, <?php echo(date(Y)); ?>.
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
	Guelph Montessori School, 151 Waterloo Avenue, Guelph, ON Canada N1H 3H9<br />
	<strong>(519) 836-3810</strong>. E-mail: <a href="mailto:guelphmontessori@rogers.com">guelphmontessori@rogers.com</a>
</div>

</div>

</body>
</html>

<?PHP
	mysql_close($dbh);
?>