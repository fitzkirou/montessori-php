<?php
	/*
	** Project: WEBadmin - Guelph Montessori School
	** Version: 1.0
	** File: events_main.php
	** Purpose: Outputs all records in the 'events' table, w/ add/edit/delete.
	** Author: Bob Young, May 2003.
	*/
	
	// Set this screen's title & include header.
	$screenTitle = "UPCOMING DATES";
	include("includes/header.php");
?>

<!-- Sub-navigation links -->
<a href="#">Add an upcoming date</a>

<form>
	<!--Table for database output starts.-->
	<table width="586" cellpadding="0" cellspacing="0">
	<tr valign="bottom">
		<th class="sidebarHeader">Title</th>
		<th class="sidebarHeader">Date</th>
		<th class="sidebarHeader">Start Time</th>
		<th class="sidebarHeader">Location</th>
		<th class="sidebarHeader">Show</th>
		<th class="sidebarHeader">&nbsp;</th>
		<th class="sidebarHeader">&nbsp;</th>
	</tr>
	<tr>
		<td>Lorem ipsum dolor set it ...</td>
		<td><div align="left">17-Jun-2003</div></td>
		<td>6:30 PM</td>
		<td>Georgian Creeds</td>
		<td align="center"><input type="checkbox" name="show" value="checkbox" checked /></td>
		<td><a href="#">Edit</a>&nbsp;</td>
		<td><a href="#">Delete</a></td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td>Quid pro quo, amet sit isi dolor ...</td>
		<td>13-Jun-2003</td>
		<td>8:00 AM</td>
		<td>School gym</td>
		<td align="center"><input type="checkbox" name="show" value="checkbox" checked /></td>
		<td><a href="#">Edit</a>&nbsp;</td>
		<td><a href="#">Delete</a></td>
	</tr>
	<tr>
			  <td>Doosy un fita neo soony dan ...</td>
			  <td>15-May-2003</td>
			  <td>6:00 PM</td>
			  <td>Playground</td>
		<td align="center"><input type="checkbox" name="show" value="checkbox" /></td>
		<td><a href="#">Edit</a>&nbsp;</td>
		<td><a href="#">Delete</a></td>
	</tr>
	<tr bgcolor="#FFFFFF">
			  <td>Foder veil in var dominum ....</td>
			  <td>12-May-2003</td>
			  <td>4:30 PM</td>
			  <td>Victor Davis Pool</td>
		<td align="center"><input type="checkbox" name="show" value="checkbox" checked /></td>
		<td><a href="#">Edit</a>&nbsp;</td>
		<td><a href="#">Delete</a></td>
	</tr>
	</table>
</form>
<!--Table for database output ends.-->

<?php
// ****************************
// Finish up interface display.
// ****************************
include ("includes/footer.php");
?>
