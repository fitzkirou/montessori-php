<?php
	error_reporting(E_ALL);
	session_start();	// 4-Oct-2011: Start browser session for parent-tools variables.

	include("../config.php");
	// Connect to MySQL server.
	$dbh = @mysql_connect ($host, $username, $password) 
		or die ( '<p style="color:red;"><b style="color:black;">Guelph Montessori School</b><br><br>There\'s a problem connecting to the Guelph Montessori database.<br>Please contact the School\'s <a title="E-mail the webmaster" href="mailto:bob@youngstudios.net">webmaster.</a></p>');
	// Select the database to use.
	mysql_select_db ($database);
?>
<!DOCTYPE HTML PUBLIC "-//WC3//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>
<head>
	<title><?php echo($title); ?> - Guelph Montessori School</title>
	<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1" />
	<meta name="keywords" content="Montessori, montessori, Guelph, Ontario, private, school, primary, elementary, curriculum">
	<meta name="description" content="An AMI certified Montessori school that uses concrete materials to teach children about language, culture, geography, and practical life skills.">
	<!-- Link to stylesheet -->
	<link href="includes/frontend.css" rel="stylesheet" type="text/css" media="all">

	<script language="JavaScript" type="text/javascript">
		// Open the virtual tour various new browser windows.
		function openTour() {
			theWindow = window.open("virtualtour/virtualtour_1.php","virtualTour","width=540,height=510");
		}
		// Cross-browser, backwards compatible "bookmark" function.
		// NOTE: The two arguments are passed from the file 'index.php'.
		function makeBookmark (theTitle, theURL)
		{
			if( window.sidebar && window.sidebar.addPanel ) {
			    //Gecko (Netscape 6 etc.) - add to Sidebar
			    window.sidebar.addPanel( theTitle, theURL, '' );
			} else if( window.external && ( navigator.platform == 'Win32' ||
			      ( window.ScriptEngine && ScriptEngine().indexOf('InScript') + 1 ) ) ) {
			    //IE Win32 or iCab - checking for AddFavorite produces errors for no
			    //good reason, so I use a platform and browser detect.
			    //adds the current page page as a favourite; if this is unwanted,
			    //simply write the desired page in here instead of 'location.href'
			    window.external.AddFavorite( location.href, document.title );
			} else if( window.opera && window.print ) {
			    //Opera 6+ - add as sidebar panel to Hotlist
			    return true;
			} else if( document.layers ) {
			    //NS4 & Escape - tell them how to add a bookmark quickly (adds current page,
			    //not target page)
			    window.alert( 'Please click OK then press Ctrl+D to create a bookmark' );
			} else {
			    //other browsers - tell them to add a bookmark (adds current page, not target page)
			    window.alert( 'Please use your browser\'s bookmarking facility to create a bookmark' );
			}
			return false;
		}
	</script>
</head>

<!--
Body tag opens.
N.B. Change bg colour as per refresh design; delete background attribute.
RY, 4 Feb. 2016
-->
<body bgcolor="#E0E9F2" background="images/bg_texture.gif">

<div align="center">

<!-- Header image map -->
<!-- ImageReady Slices (header- final.psd) -->
<IMG SRC="images/header.gif" style="position:relative;z-index:1" name="header" WIDTH=745 HEIGHT=149 BORDER=0 ALT="" USEMAP="#header_Map">
<MAP NAME="header_Map">
	<!-- White text on gold -->
	<AREA SHAPE="rect" ALT="" COORDS="157,131,251,142" HREF="#" onclick="openTour();">
	<AREA SHAPE="rect" ALT="" COORDS="269,130,390,143" HREF="contacts.php">
	<!-- Black text on white -->
	<AREA SHAPE="rect" ALT="" COORDS="659,111,725,121" HREF="map.php">
	<AREA SHAPE="rect" ALT="" COORDS="527,111,616,122" HREF="credentials.php">
	<AREA SHAPE="rect" ALT="" COORDS="370,111,486,122" HREF="toddler-program.php">
	<AREA SHAPE="rect" ALT="" COORDS="157,111,332,123" HREF="elemntry.php?submenu=elementary">
	<AREA SHAPE="rect" ALT="" COORDS="581,93,726,105" HREF="curriculum.php?submenu=primary">
	<AREA SHAPE="rect" ALT="" COORDS="403,93,544,105" HREF="method.php">
	<AREA SHAPE="rect" ALT="Montessori Basics" COORDS="231,93,370,105" HREF="whatis.php">
	<AREA SHAPE="rect" ALT="Home" COORDS="157,93,202,106" HREF="index.php">
	<!-- NOTE: This shape is NOT in the ImageReady map file: -->
	<AREA SHAPE="rect" ALT="New Toddler Program" COORDS="487,119,511,133" HREF="toddler-program.php">
</MAP>
<!-- End ImageReady Slices -->

<!-- Start of page container table -->
<table style="position:relative;z-index:0" class="pageContainer" bgcolor="#ffffff" border="0" width="745" cellpadding="0" cellspacing="0">
	<tr bgcolor="#ffffff">
		<td width="140" class="subnavigation" rowspan="2" valign="top">

<?php
	/*
	** Display dynamic subnavigation:
	*/
	include("includes/submenu.php");
	
	/*
	** Choose a random photo & text:
	*/
	//Seed the generator.
	mt_srand(doubleval(microtime()) * 100000000);
	
	//Choose image and text.
	switch(mt_rand(2,10))
	{
		/*
		case 1:
			$randomImage = "abstract_art.jpg";
			$randomText = "A visual artist explains an abstract painting on Career Day.";
			break;
		*/
		case 2:
			$randomImage = "building.jpg";
			$randomText = "Historic facade of the Guelph Montessori School.";
			break;
		case 3:
			$randomImage = "class_elem.jpg";
			$randomText = "Children in one of our elementary classes.";
			break;
		case 4:
			$randomImage = "class_primary.jpg";
			$randomText = "Children in one of our primary classes.";
			break;
		case 5:
			$randomImage = "computer.jpg";
			$randomText = "The school features a networked computer lab.";
			break;
		case 6:
			$randomImage = "math_beads.jpg";
			$randomText = "A student using Montessori concrete materials to learn math.";
			break;
		case 7:
			$randomImage = "math_table.jpg";
			$randomText = "A student using a pyramid table to learn math.";
			break;
		case 8:
			$randomImage = "science.jpg";
			$randomText = "Students complete scientific and environmental projects.";
			break;
		case 9:
			$randomImage = "screwdriver.jpg";
			$randomText = "Students use real tools to master practical life skills.";
			break;
		default:
			$randomImage = "skating.jpg";
			$randomText = "Physical education includes trips for skating and swimming.";
	}
?>
<!-- Display the randomly selected image and text. -->
<img class="sidebar" src="images/sidebar/<?php echo $randomImage; ?>" alt="<?php echo $randomText; ?>"><br clear="all"><div class="caption"><?php echo $randomText; ?></div></td>
		
		<!-- Left gutter -->
		<td width="20" valign="top">&nbsp;</td>
<?php
	// If we're on the homepage, use full screen width available.
	if ($title == "Home") {
		$columnWidth = "560";
	}
	else {
		$columnWidth = "510";
	}
	// Open the body-content column.
	echo ("<td bgcolor=\"#ffffff\" width=\"" . $columnWidth . "\" valign=\"top\">");
?>
			<br />
			<!-- Body content starts. -->