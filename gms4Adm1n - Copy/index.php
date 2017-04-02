<?php
	/*
	** Project: WEBadmin - Guelph Montessori School
	** Version: 1.0
	** File: index.php
	** Purpose: This is the help page.
	** Author: Bob Young, May 2003.
	*/

	include("includes/library.php"); //Include shared modules.
	
	$isViewAllLinked = false; //Define global variables.
	$process = "View";
	$item = "Help";
	$action = "";
	
	// Include header file, connect to MySQL and select the db.
	prepare($isViewAllLinked, $process, $item, $action);
	
	//Open the table and form.
	include("includes/form_start.php");
	//Open table-row wrapper.
	echo("<tr class=\"feedback\" valign=\"top\">\n");
	echo("<td class=\"feedback\" colspan=\"2\ valign=\"top\">\n");
?>
<br>

<!-- Open the indent div. -->
<div style="padding-left:85px; padding-right:85px;">
	
	<?php 
		echo '<!-- Show the calendar-update alert. -->' . "\n\n";
		// Assign year and date variables.
		$systemMonth = date ("n"); // get the current system month & year
		$systemYear = date ("Y");
		$nextCalYear = $systemYear + 1; // Set the next calendar year.
		
		// Show the calendar-update alert only in June through August.
		if (($systemMonth >= 6) AND ($systemMonth <= 8))
		{
			echo '<div class="alert">' . "\n\t";
			echo '<strong>CALENDAR-UPDATE ALERT!</strong><br /><br />' . "\n\t";
			echo 'As of July 1, your school-year calendar will show the ' . "\n\t";
			echo $systemYear . '&ndash;' . $nextCalYear . ' academic year. So, you need to ' . "\n\t";
			echo 'edit the Upcoming Dates to reflect your new academic year.' . "\n\t";
			echo "<br /><br />Click on either UPCOMING DATES or SCHOOL-YEAR CALENDAR above. ";
			echo "Then, edit or delete each event as needed. Typically, you'll need to change the year to " . "\n\t";
			echo $nextCalYear . '. ';
			echo 'Also, each event\'s specific date may need to be changed according to where ' . "\n\t";
			echo 'the dates fall in ' . $nextCalYear . ".\n";
			echo '<br /><br /><div style="font-size:11px; color:Black;">(<strong>Note:</strong> Each year, this alert displays from June through August, whether or not you\'ve completed the updating as described above.)<br /><i>Bob Young</i></div>';
			echo '</div>' . "\n";
			echo '<br /><br />' . "\n\n";
		}
	?>
	
	<hr>
	<div class="feedback">

		<span class="introHeader">Yearly Tasks</span><br><br>
	
		<!-- Put CSS-styled buttons into a 2-column table. -->
		<table style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="2">
		<tbody>
			<tr><!-- border-right: 1px solid #000; -->
				<td style="vertical-align: top; width: 50%;">
	    			<a href="fees_update.php">Edit fees</a>
	    			<br><br>Revise tuition and other fees for the current school year.
				</td>
				<td style="vertical-align: top; width: 50%;">
					<!-- N.B. Must add Javascript alert-box to prevent accidental sends. -->
					<a href="pws31aster.php">Email parent passwords</a>
					<br><br>Using the current master-list of parents, email each parent a 
					password to access the Parent Tools area.
				</td>
			</tr>
		</tbody>
		</table>
	
	</div>

    <hr>
	<div class="feedback">
		<span class="introHeader">How to get bold text in News Items</span><br />
		You have to use a little HTML code. Don't worry: it's very simple. Say you have typed the 
		phrase <em>education highlights</em> and want it to be bold.
		<br><br>
		Simply add <code>&lt;b&gt;</code> before the 
		phrase and <code>&lt;/b&gt;</code> after it. That is, type <code>&lt;b&gt;education highlights&lt;/b&gt;</code>. 
		The result will look like this: <strong>education highlights</strong>.
		<br><br>
	</div>
	
	<div class="feedback">
		<span class="introHeader">How to use the automatic newsletter</span><br />
		Basically, you don't have to do anything at all! As long as your News 
		Items and Upcoming Dates are up to date, then the printable 
		newsletter is ready to go. The newsletter automatically displays the 
		following items:
		<ul>
			<li>the phrase <em>GMS NEWS</em> as an attractive graphic header</li>
			<li>a seasonal graphic (e.g., a red maple leaf for autumn) as a focal point on page 1</li>
			<li>all news items (which you've selected to show on the website)</li>
			<li>among the news items, inspirational quotations appearing with every 4th news item</li>
			<li>all upcoming dates (which you've selected to show on the website)</li>
			<li>an e-mail link (guelphmontessori@rogers.com) for feedback</li>
		</ul>
		<span style="font-weight:bold;">Automatic Date-Ordering of Items</span>
		<br>
		Both the news items and upcoming dates are ordered by ascending date. 
		To reiterate, by keeping your website's news items and upcoming dates 
		up to date, you'll always <em>also</em> have an up-to-date, time-sensitive
		newsletter for site visitors to view online or print out!
		<br><br>
		<span style="font-weight:bold;">Paper Versus The Web</span>
		<br>
		You may wish to print out the newsletter and photocopy it for 
		distribution to parents. This is just in case some parents don't have 
		Internet access or don't visit the website often.
		<br><br>
		However, you should encourage parents toward an exclusive online 
		newsletter policy. Doing this would reduce unnecessary use of paper, 
		save you time, and save you money!
		<br><br>
	</div>
	
	<p class="feedback">
		<span class="introHeader">How to check your work</span><br />
		The changes that you make 
		to Upcoming Dates and News Items  
		are reflected immediately. Your changes and additions are also reflected immediately in the 
		printable newsletter on your public website.
		<br><br>
		So, please verify changes you've made by visiting 
		the Guelph Montessori website; just click the button below to see your new or revised content:<br><br>
		<a href="http://guelphmontessori.com/index.php" target="_blank">guelphmontessori.com/index.php</a>
	</p>
	<br>

<!-- Close the indent div. -->
</div>

<?php
	//Close table-row wrapper.
	echo("</td></tr>\n");
	//Close the table and form.
	include("includes/form_end.php");
	// Include footer.php and close the connection to MySQL server.
	finishUp();
?>