<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>
		Website Administration - Guelph Montessori School
	</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<!--Link to stylesheet.-->
	<link href="includes/web_mgr.css" type="text/css" rel="stylesheet" />

	<SCRIPT TYPE="text/JavaScript" LANGUAGE="javascript">
		// Function to launch a content window
		function openWindow (page) {
			OpenWin = window.open(page,"CtrlWindow","width=240,height=300");
		}
		
		// Validate that an event type has been selected.
		function checkEventType (theSelectList)
		{
			ind = theSelectList.selectedIndex;
			selectedType = theSelectList.options[ind].value;
			if (selectedType == "FALSE")
			{
				message = "You didn't select an event type from the list!";
				alert (message);
				theSelectList.focus();
			}
		}
		
		<!-- Send page content to printer. -->
		function printpage()
	   	{
	   		window.print();
	   	}	
	</SCRIPT>
</head>

<!-- <body bgcolor="#808080"> -->
<body bgcolor="#E0E9F2" background="../images/bg_texture.gif">

<!-- This DIV contains all content. -->
<div style="width:745px;">
	
	<!-- Image Map / header -->
	<img name="h_nav_backend" src="images/h_nav_backend.gif" width="745" height="149" border="0" usemap="#h_nav_backend">
	<map name="h_nav_backend">
		<area shape="rect" coords="144,100,254,115" href="event_main.php">
		<area shape="rect" coords="274,100,443,115" href="admin_calendar.php">
		<area shape="rect" coords="460,100,552,115" href="news_main.php">
		<area shape="rect" coords="567,100,616,115" href="index.php">
	</map>

	<!-- Open the "indent" CSS box. -->
	<div id="indentBox">
