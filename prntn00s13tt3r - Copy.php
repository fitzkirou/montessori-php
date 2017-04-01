<?php
	/*
	** File: prntn00s13tt3r.php
	** Purpose: Uses the file print.css to produce a conventional printable newsletter.
	** Copyright Robert B. Young 2003.
	*/
	
	// Kick out illegal HTTP requests for Parent Tools files.
	session_start();
	$isPrivate = true;
	if ($isPrivate && !$_SESSION['isSignedIn']) { 
		die ("<html><body><h1>Authorization required.</h1></body></html>");
	}
	
	/* ---------------------------------------------------------------------
	** Mainline Logic
	** ---------------------------------------------------------------------
	*/
	configAndConnect();
	showHeader();
	showEdition();
	showSeasonalImage(date("n"));	//date("n") passes the current month no.
	showArticles();
	showDates();
	showEditors();
	endHTMLAndDB();
	
	/* ---------------------------------------------------------------------
	** Function Definitions
	** ---------------------------------------------------------------------
	*/
	function configAndConnect()
	{
		include("../config.php");
		// Connect to MySQL server.
		$dbh = @mysql_connect ($host, $username, $password) 
			or die ( 'Webpage cannot connect to the database because: ' . mysql_error() );
		// Select the database to use.
		mysql_select_db ($database);
		#include("includes/library.php");
	}
	
	function showHeader()
	{
		include("includes/print_header.php");
	}
	
	function showEdition()
	{
		echo("<h1>" . date("F Y") . "</h1>");
	}
	
	/*
	** Show a left-aligned, seasonal graphic -- based on month number.
	*/
	function showSeasonalImage($month)
	{
		echo("<img src=\"images/news_");	// Open the image tag.
		// August or September
		if(($month=="8") OR ($month=="9"))
		{
			echo("autumn.gif\" alt=\"Autumn\" ");
		}
		// October
		else if($month=="10")
		{
			echo("halloween.gif\" alt=\"Halloween\" ");
		}
		// Novembmer or December
		else if(($month=="11") OR ($month=="12"))
		{
			echo("xmas.jpg\" alt=\"Happy Holidays!\" ");
		}
		// January or February
		else if(($month=="1") OR ($month=="2"))
		{
			echo("winter.jpg\" alt=\"Winter\" ");
		}
		// March, April, or May
		else if(($month=="3") OR ($month=="4") OR ($month=="5"))
		{
			echo("spring.gif\" alt=\"Spring and Summer\" ");
		}
		// June or July
		else
		{
			echo("spring.gif\" alt=\"Spring and Summer\" ");
		}
		echo("align=\"left\" border=\"0\">");	// Close the image tag.
	}
	
	/*
	** Print all current news items/articles to the screen.
	*/
	function showArticles()
	{
		$articlesSet = getActiveArticles(); // get SQL result set.
		$itemCount = 0; // Initialize counter re: the pull quote(s).
		if(mysql_num_rows($articlesSet) >= 1)
		{
			while($row = mysql_fetch_array($articlesSet))
			{
				showContent($row, $itemCount);
				$itemCount++; // Increment the counter.
			}
		}
		else
		{
			echo("<p>There are currently no active news items.</p>");
		}
	}

	/*
	** SQL to retrieve all active news items and return the result set.
	*/
	function getActiveArticles()
	{
		$active_query = "SELECT		*
						 FROM		news_item
						 WHERE		isActive='yes'
						 ORDER BY	REL_yearID ASC, REL_monthID ASC, REL_dateID ASC";
		$active_result = mysql_query($active_query);
		if($active_result)
		{
			return($active_result);
		}
		else
		{
			echo('<p class=\"error\">Error in SELECT query named \'$active_query\'</p>');
			exit;
		}
	}

	/*
	** Print this news item's title and body text to the screen.
	** Every 2nd call to this function, show a random pullquote.
	*/
	function showContent($row, $itemCount)
	{
		echo("<div>");
		
		if (	($itemCount == 2) OR ($itemCount == 4) OR ($itemCount == 6) 
				OR ($itemCount == 8) OR ($itemCount == 10) OR ($itemCount == 12)
			)
		{
			$quote = getRandomQuote();
			echo("<div class=\"pullquote\">");
			echo($quote);
			echo("</div>");
		}
		
		//show title
		echo("<h2>" . $row['title'] . "</h2>");
		//show body text
		$theText = $row['main_text'];
		echo (nl2br($theText));
		echo("</div>");
	}
	
	/* ---------------------------------------------------------------------------------
	** From an array of quotations, return one at random.
	** ---------------------------------------------------------------------------------
	*/
	function getRandomQuote()
	{
		//create array (22 elements currently)
		$quotations[] = "Most children are given far too much praise for their early drawings, so much so that they rarely learn the ability to refine their first crude efforts the way their early attempts at language are corrected. (Charles de Lint)";
		$quotations[] = "Creativity flourishes when we have a sense of safety and self-acceptance. (Julia Cameron)";
		$quotations[] = "\"I can't do it\" never yet accomplished anything; \"I will try\" has performed wonders. (George P. Burnham)";
		$quotations[] = "What you believe, you can achieve. (Mary Kay Ash)";
		$quotations[] = "The roots of education are bitter, but the fruit is sweet. (Aristotle)";
		$quotations[] = "Teaching is not a lost art, but the regard for it is a lost tradition. (Jacques Martin Barzun)";
		$quotations[] = "Education is the movement from darkness to light. (Allan Bloom)";
		$quotations[] = "The real object of education is to have a man in the condition of continually asking questions. (Bishop Creighton)";
		$quotations[] = "Poor is the pupil who does not surpass his master. (Leonardo da Vinci)";
		$quotations[] = "There is no education like adversity. (Disraeli)";
		$quotations[] = "All education must be self-education. (Robert Henri)";
		$quotations[] = "Education is the mother of leadership. (Wendell L. Willkie)";
		$quotations[] = "Teachers open the door, but you must enter by yourself. (Chinese Proverb)";
		$quotations[] = "The worst bankruptcy in the world is the person who has lost his enthusiasm. (H. W. Arnold)";
		$quotations[] = "We are what we repeatedly do. Excellence, then, is not an act, but a habit. (Aristotle)";
		$quotations[] = "A man's mind may be likened to a garden, which may be intelligently cultivated or allowed to run wild; but whether cultivated or neglected, it must, and will bring forth. If no useful seeds are put into it, then an abundance of useless weed-seeds will fall therein, and will continue to produce their kind. (James Allen)";
		$quotations[] = "Neither a lofty degree of intelligence nor imagination nor both together go to the making of genius. Love, love, love, that is the soul of genius. (Wolfgang Amadeus Mozart)";
		$quotations[] = "What answer to the meaning of existence should one require beyond the right to exercise one's gifts? (W. H. Auden)";
		$quotations[] = "There are only two ways to live your life. One is as though nothing is a miracle. The other is as though everything is a miracle. (Albert Einstein)";
		$quotations[] = "When we do the best we can, we never know what miracle is wrought in our life, or in the life of another. (Helen Keller)";
		$quotations[] = "Never give up your right to be wrong, because then you will lose the ability to learn new things and to move forward with your life. (Dr. David M. Burns)";
		$quotations[] = "When we are motivated by goals that have deep meaning, by dreams that need completion, by pure love that needs expressing, then we truly live life. (Greg Anderson)";
		
		//pick a random index in the array, and return this to showContent().
		shuffle($quotations);
		$quote = $quotations[0]; //get first element of the shuffled array.
		return($quote);
	}
	
	function showDates()
	{
		echo("<br><br>");
		echo("<div class=\"dateBoard\">");
		echo('<h2 style="border-top:0px solid #C90;">Upcoming School Dates</h2><br>');
		include("includes/event_list.php");
		echo("</div>");
		echo("<br><a style=\"font-size:8pt;\" href=\"#top\">^ Back to top</a>");
	}
	
	function showEditors()
	{
		echo("<br><br>");
		echo("<div class=\"footer\">");
		echo("<em>GMS News</em> is published by the administrators of Guelph Montessori School. We welcome your feedback. Please contact the editors--Bridget Young or Amir Gutman--at the school, or e-mail us at <a 
style=\"color:blue; text-decoration: underline\" 
href=\"mailto:guelphmontessori@rogers.com\">guelphmontessori@rogers.com</a>.");
		echo("</div>");
	}
	
	function endHTMLAndDB()
	{
		echo("</td></tr>");
		echo("</table>");
		echo("</body>");
		echo("</html>");
		mysql_close();
	}
?>