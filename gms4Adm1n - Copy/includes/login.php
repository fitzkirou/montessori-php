<?php
$PageTitle = "LoginPage";
require ("header.php")

if ($Message == "Invalid")
{
	echo ('<p style="text-align:center; color:red;">' . "\n");
	echo ('The username and password you entered do not match what is on ');
	echo ('file. Please try again!' . "\n");
	echo ('</p> . "\n"');
}
else
{
	
}
?>
