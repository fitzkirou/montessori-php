<?php
			// Show the News heading
			print ("<h1 class=\"homeSubhead\">News Items</h1>");
			
			/* ***********************************************************
			** Show the title and first sentence of each active news item.
			** ***********************************************************
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
				// Loop thru returned rows, displaying title & first sentence.
				while ($row = mysql_fetch_array($active_result,MYSQL_ASSOC))
				{
					echo("<p class=\"teaser\">");
					echo("<span class=\"featureTitle\">" . $row['title'] . "</span><br>");
					//Try truncation
					$teaser = substr($row['main_text'],0,120);
					echo($teaser . "... <a class=\"teaserLink\"");
					// Append this item's ID as a GET variable to the detail page.
					echo (" href=\"news_detail.php?PK_newsID=" . $row['PK_newsID'] . "\">More</a>");
					echo("</p>");
				}
			}
			// Indicate if there are no records.
			else
			{
				echo("Currently, there are no news items.");
			}
		?> 