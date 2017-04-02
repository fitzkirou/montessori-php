<?php
	/*
	** Project: WEBadmin - Guelph Montessori School
	** Version: 1.0
	** File: news_add.php
	** Purpose: Takes user input and nserts a news-item record into the database.
	** Author: Bob Young, May 2003.
	*/

	include("includes/library.php"); //Include shared modules.
	$isViewAllLinked = true; //Define global variables.
	$process = "Add";
	$item = "news item";
	$action = "news_add.php";
	
	prepare($isViewAllLinked,$process,$item,$action);
	
	// process the form only if the submit button has been clicked
	if(isset($submit)) {
		insertNewsItem();
	}
	else {
		include("includes/fields_news_new.php");
	}
	finishUp();


	/*
	** Function insertNewsItem() inserts a news item (and, optionally, an
	** image into the database. Data comes from the HTML form.
	*/
	function insertNewsItem()
	{
	
	/*	------------------------------------------------------------------
		Declare global variables.
		------------------------------------------------------------------ */
	
		global $isViewAllLinked, $process, $item, $action;
		// Make posted form-field values available to this scope.
		// Variables of the news item:
		global $title, $main_text, $REL_dateID, $REL_monthID, $REL_yearID, $isActive;
		// Variables of the related image record:
		global $description, $data, $form_data_name, $form_data_size, $form_data_type;


	/*	------------------------------------------------------------------	
		Do the image insert.		
		------------------------------------------------------------------ */

		// Return ID of the inserted image to the variable $imgId.
		$imgId = insertImage ($description, $data, $form_data_name, $form_data_size, $form_data_type);

		echo ('<p>$imgId comes back as: ' . $imgId . '</p>'); // DEBUGGING

		// Print error and exit if there's no result from the image-insert query.
		if ($imgId == FALSE)
		{
			exit ('<p style="color:red">Error: There\'s a problem with query "$img_query".</p>');
		}
		
		
	/*	------------------------------------------------------------------
		Do the news-item insert.
		------------------------------------------------------------------ */
		
		// Then insert the appropriate variables in the 'news_item' table.
		$news_query =  "INSERT INTO news_item 
						SET title='$title',
							main_text='$main_text',
							REL_dateID='$REL_dateID',
							REL_monthID='$REL_monthID',
							REL_yearID='$REL_yearID',
							isActive='$isActive',
							REL_imageID = '$imgId'";
		
		
	/*	------------------------------------------------------------------
		Show a confirmation of entered data.
		------------------------------------------------------------------ */

		if(@mysql_query($news_query))
		{
			//Open the table and form.
			include("includes/form_start.php");
			//Open table-row wrapper.
			echo("<tr class=\"feedback\" valign=\"top\">\n");
			echo("<td class=\"feedback\" colspan=\"2\>\n");
			//Print confirmation content.
			echo("<div class=\"feedback\">\n");
			echo("<br><p class=\"warning\">Your " . $item . " was added successfully to the database! <br>Here it is what you entered:</p>\n");
			echo("<p class=\"feedback\" style=\"font-weight:bold;font-size:18px;\">" . $title . "</p>\n");
			echo("<p class=\"feedback\">" . nl2br($main_text) . "</p>\n");
			echo("<p class=\"feedback\" style=\"color:#000\"><b>Critical Date:</b> " . getMonthName($REL_monthID) . " " . $REL_dateID . ", " . $REL_yearID . "</p>\n");
			echo("<p class=\"feedback\" style=\"color:#000\"><b>Show on Website:</b> " . $isActive . "</p>\n");
			echo("&nbsp;&nbsp;<input type=\"button\" name=\"goBack\" value=\" OK \" onclick=\"window.location.href='news_main.php';\"><br><br>");
			echo("</div>\n");
			//Close table-row wrapper.
			echo("</td></tr>\n");
			//Close the table and form.
			include("includes/form_end.php");
		}
		// Or... show an error if the query returned FALSE.
		else
		{
			echo("<br><br><p class=\"error\">Error adding submitted news item: " . mysql_error() . "</p>\n");
		}
	} // End of function insertNewsItem().
	

	/*
	** Function insertImage() inserts the related image (for the news-item)
	** into the 'image' table.
	*/
	function insertImage ($description, $data, $form_data_name, $form_data_size, $form_data_type)
	{
		// Do a binary-safe file read and assign it to $data.
		$data = addslashes (fread(fopen($form_data, "r")), filesize($form_data));
		// Insert the image data into the 'image' table.
		$img_query = "	INSERT INTO image 
						(description, bin_data, filename, filesize, filetype) 
						VALUES 
						('$description','$data','$form_data_name','$form_data_size','$form_data_type')";
		$img_result = mysql_query ($img_query);
		// Show an error if query returns FALSE.
		if (! $img_result)
		{
			return (FALSE);
		}
		// Return the id of the inserted image record.
		else
		{
			$imageId = mysql_insert_id();
			return ($imageId);
		}
	} // End of function insertImage().
?>
