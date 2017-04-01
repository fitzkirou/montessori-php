<?php
$title = "School Location";
include("includes/header.php");
?>

<h1>School Location</h1>

<script type="text/javascript">
	// Function to open a new window for the enlarged map.
	function openMap() {
		var MapWindow = window.open("map_enlarged.html","blowup","status=no,width=520,height=435");
	}
</script>

<p>
	Our school is located conveniently at 151 Waterloo Avenue in central Guelph, just 
	west of the downtown area. The map below shows our location relative to major 
	roads in the city. Please note the following features of the map:
</p>

<ul>
	<li>
		North is up.
	</li>
	<li>
		The school is indicated by a small black square.
	</li>
	<li>
		Click on the central grey-shaded area for an enlarged view.
	</li>
</ul>

<!-- Map coordinates for the enlargement link (see below). -->
<map name="clickzone">
	<AREA title="Click to enlarge." SHAPE="rect" COORDS="45,170,150,232" onclick="openMap()" HREF="#">
</map>

<IMG usemap="#clickzone" style="position:relative; left:22px;" SRC="images/mont-map.gif" ALT="Map to Guelph Montessori School" WIDTH="212" HEIGHT="365" border="0">
<br><br>

<?PHP
include ("includes/footer.php");
?>
