<?php
/*
** Adapted from "Site Navigation with PHP," by Brad Bulger.
** Purpose: Provides dynamic "Back" and "Next" hyperlinks.
** Source: webmonkey.com - programming section
** IMPORTANT: All filenames must end in "_[integer]", e.g., file_1.php
**			  and be in the same directory.
*/
$full_path = getenv("REQUEST_URI");
$base = dirname($full_path);
$page_file = basename($full_path);
$page_num = substr($page_file
	, strrpos($page_file, "_") + 1
	, strpos($page_file, ".php") - strrpos($page_file, "_") - 1
);
$partial_path = substr($page_file, 0, strrpos($page_file, "_"));

$prev_page_file = $partial_path . "_" . (string)($page_num-1) . ".php";
$next_page_file = $partial_path . "_" . (string)($page_num+1) . ".php";

$prev_exists = file_exists($prev_page_file);
$next_exists = file_exists($next_page_file);
?>

<div class="vTourLinks">

<?php
	// If there's a 'previous' file, show a link to it.
	if ($prev_exists)
	{
		print "<a href=\"$base/$prev_page_file\"><img src=\"../images/btn_previous.gif\" alt=\"Previous\" border=\"0\"></a>";
	}
	// If there's a 'next' file, show a link to it.
	if ($next_exists)
	{
		print "<a href=\"$base/$next_page_file\"><img src=\"../images/btn_next.gif\" alt=\"Next\" border=\"0\"></a>";
	}
?>
	
	<!-- close link -->
	<a href="javascript:window.close()"><img src="../images/btn_close.gif" alt="Close" border="0"></a>

</div>

