<?php
	/*
	** Purpose: Shows a virtual-tour picture with dynamic back/next buttons.
	** Author: Bob Young
	** Date: June 11, 2003
	*/
	
	// Declare variables.
	$pictureNumber = "25";
	$description = "Periodic performances by visiting artists (Bach to Beatles).";
	
	include("../includes/vtour_header.html");
	
	// show image
	echo ("<img id=\"vTour\" src=\"../images/virtualtour/vtour_" . $pictureNumber . ".jpg\" alt=\"" . $description . "\" height=\"383\" width=\"510\" border=\"0\">");
	
	// show description
	echo ("<div id=\"vTourDesc\">" . $description . "</div>");
	
	include("../includes/backnext_nav.php");
	include("../includes/vtour_footer.html");
?>