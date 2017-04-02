<?php
	/*
	** File: submenu.php
	** Purpose: Creates a vertical menu of text links, with submenus.
	** Author: Bob Young
	** Date: June 4, 2003
	*/
	
	// Define arrays to hold the link text and URLs.
	$main = array(
				'Home' => 'index.php', 
				'Montessori Basics' => 'whatis.php',
				'Montessori Method' => 'method.php',
				'Primary Curriculum' => 'curriculum.php?submenu=primary',
				'Elementary Curriculum' => 'elemntry.php?submenu=elementary',
				'Toddler Program' => 'toddler-program.php',
				'Credentials' => 'credentials.php',
				'Location' => 'map.php',
				'Our Caterer' => 'http://thelunchlady.ca/',
				'Tuition and Fees' => 'fees.php',
				'Application for Enrollment' => 'appl-for-enrol.php', 
				'School Calendar' => 'prnt10g1n.php?isCalendarWanted=1'
				);
				
	$sub_primary = array(
				'Practical Life' => 'life.php?submenu=primary',
				'Sensorial Learning' => 'sensorial.php?submenu=primary',
				'Language' => 'language.php?submenu=primary',
				'Mathematics' => 'math.php?submenu=primary',
				'Culture &amp; Geography' => 'culture.php?submenu=primary',
				'French' => 'french.php?submenu=primary',
				'Physical Education' => 'phys_ed.php?submenu=primary',
				'Karate' => 'karate.php?submenu=primary'
				);
	
	$sub_elementary = array(
				'Language' => 'elem_language.php?submenu=elementary',
				'Mathematics' => 'elem_math.php?submenu=elementary',
				'History' => 'elem_history.php?submenu=elementary',
				'Geography' => 'elem_geography.php?submenu=elementary',
				'Botany &amp; Zoology' => 'elem_botanyzoo.php?submenu=elementary',
				'Geometry' => 'elem_geometry.php?submenu=elementary',
				'Arts' => 'elem_art.php?submenu=elementary',
				'French' => 'elem_french.php?submenu=elementary',
				'Physical Education' => 'elem_phys_ed.php?submenu=elementary',
				'Skating' => 'elem_skating.php?submenu=elementary',
				'Swimming' => 'elem_swim.php?submenu=elementary',
				'Karate' => 'elem_karate.php?submenu=elementary'
				);
	
	// Display the navigation, showing submenus when appropriate.
	foreach ($main as $key => $value)
	{
		// Show menu items; launch the School Year Calendar in a new window
		// (i.e., target="blank").
		if ($key == "School Year Calendar")
		{
			echo ("<div class=\"subnav\"><a target=\"_blank\" class=\"subLink\" href=\"" . $value . "\">" . $key . "</a></div>\n");
		}
		else
		{
			echo ("<div class=\"subnav\"><a class=\"subLink\" href=\"" . $value . "\">" . $key . "</a></div>\n");
		}
		// Handle the sub-menus.
		if (($key == "Primary Curriculum") AND ($submenu == "primary"))
		{
			foreach ($sub_primary as $key => $value)
			{
				echo ("<div class=\"navIndent\"><a class=\"subLink\" href=\"" . $value . "\">" . $key . "</a></div>\n");
			}
		}
		elseif (($key == "Elementary Curriculum") AND ($submenu == "elementary"))
		{
			foreach ($sub_elementary as $key => $value)
			{
				echo ("<div class=\"navIndent\"><a class=\"subLink\" href=\"" . $value . "\">" . $key . "</a></div>\n");
			}
		}
	}
?>
