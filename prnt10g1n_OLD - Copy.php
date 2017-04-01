<?php 
	/*
	** File: 		prnt10g1n.php
	** Project: 	Parent Tools - Guelph Montessori School
	** Purpose: 	Dynamic display of both login form and parents-only content.
	** Author: 		Bob Young, October 2011.
	*/
	// Go to news-item detail if logged-in user clicked a homepage link.
	//session_start();
	//if ($_POST["isFromHome"] == 1 && $_SESSION['isSignedIn'])
	//{
	//	/* Redirect browser */
	//	header("Location: http://guelphmontessori.com/news_detail.php?PK_newsID=" . $_POST['newsID']);
	//	exit();
	//}
	
	error_reporting(E_ALL ^ E_NOTICE);
	
	$title = "Parent Tools";
	include("includes/header.php");
	// NOTE: DB connection has been made, so you can query and output if you want.
	include("gms4Adm1n/includes/library.php");
	
	//Define login info to match -- the same for every user.
	define ("USERNAME", "gmsparent");
	define ("PASSWORD", "14-15gmsN");
	
	// Define time-related constants.
	define ("IS_ONE_YEAR", FALSE);
	define ("YEAR1_START_MONTH", 7);	// July to ...
	define ("YEAR1_END_MONTH", 12);		// December.
	define ("YEAR2_START_MONTH", 1);	// January to ...
	define ("YEAR2_END_MONTH", 6);		// June.
	
	// Define variable $thisYear as current system year (XXXX format).
	$thisYear = date ("Y");
	// Ensure correct academic year is displayed during YEAR2:
	// If the current month number is less than or equal to the academic 
	// year's end-month, then decrement the calendar year $thisYear.
	if (date ("n") <= YEAR2_END_MONTH)
	{
		$thisYear = $thisYear - 1;
	}
	
	echo('<h1>'.$title.'</h1>');
?>
	<!-- Client-side scripts -->
	<script language="JavaScript" type="text/javascript">
		function opnN00sW1n() {
			theWindow = window.open("prntn00s13tt3r.php","dummy1","width=680,height=510,scrollbars=yes");
		}
		<!-- 9-Oct-2011. Not currently using this one: -->
		function opnY33rCa1() {
			theWindow = window.open("prnty3arca1.php","dummy2","width=800,height=600");
		}
	</script>
<?php 
// -------------------------------------------------------------------
// Mainline logic
// -------------------------------------------------------------------
if (!isset($_POST["submit"]) && !isset($_SESSION['isSignedIn'])) 
{
	showLoginForm();
}
else 
{
	$isGoodCreds = checkLogin($_POST["email"], $_POST["password"]);
	if ($isGoodCreds) 
	{
		$_SESSION['email'] = $_POST["email"];  //Used for welcome text
	}
	if ($isGoodCreds OR $_SESSION['isSignedIn']==true) 
	{
		$_SESSION['isSignedIn'] = true;
		showTools($thisYear);
	}
	else 
	{
		showLoginError();
		showLoginForm();  // To do: echo "Hello, <lastame>."
	}
}
echo "<br>";
include("includes/footer.php");  // End HTML and close db connection.


// -------------------------------------------------------------------
// Function Definitions
// -------------------------------------------------------------------
function showLoginForm()
{
	// GET var. is set in the news-item "more..." links in index.php.
	if ($_GET["isFromHome"] == 1)
	{
		echo '<p>You must sign in to view News Item details.</p><br>';
	}
?>
<form style="background:#eeeeee; width:100%;" action="prnt10g1n.php" method="post">
	
	<!-- Pass _GET vars. (from clicked news-item link) to form. -->
	<!-- <input type="hidden" name="isFromHome" value="<?php echo $_GET['isFromHome']; ?>">
	<input type="hidden" name="newsID" value="<?php echo $_GET['newsID']; ?>"> -->
	
	<p style="font-weight:bold; color:#FFF; background:#C90; width:100%; padding:2px;">
		Sign In
	</p>
	<table style="text-align:left;" border="0" cellpadding="2" cellspacing="2">
		<tbody>
		<tr>
			<td style="text-align: right;">User Name:<br></td>
			<td>
				<input type="text" name="email" value="<?php echo($_GET["email"]); ?>"><br>
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">Password:<br></td>
			<td><input type="password" name="password"><br></td>
		</tr>
		<tr>
			<!--Purposely blank cell:--><td><br></td>
			<td><input type="submit" name="submit" value="Sign in"> <input type="button" name="cancel" value="Cancel" onclick="window.location='index.php';"><br></td>
		</tr>
		</tbody>
	</table>
	<p><br></p><!-- Blank by design -->
</form>
<?php
}

function checkLogin($userEmail, $userPassword) 
{
	/* OLD SYSTEM -- ASSUMES EACH PARENT HAS UNIQUE LOGIN CREDS.
	$parentFile = "../prntL1st.csv";
	
	if (file_exists($parentFile)) 
	{
		$file_handle = fopen($parentFile, "r");
		$isMatch = false;    // Initialize return-value.
		
		while (!feof($file_handle)) 
		{
			// Get fields-array from current line ("record").
			$recField = fgetcsv($file_handle, 1000); //Char-length param. for max. speed
			// Try for a match.
			if (($userEmail != "") && ($userPassword != ""))   //Hack for empty fields.
			{
				if ($userEmail == $recField[1] && $userPassword == $recField[2])
				{
					$isMatch = true;
					$lastNameAndSex = $recField[0];
					break;
				}
			}
		}
		return $isMatch;
	*/
	$isMatch = false;    // Initialize return-value.
	if (($userEmail == USERNAME) && ($userPassword == PASSWORD))
	{
		$isMatch = true;
	}	
	return $isMatch;
}

function showTools($currentYear) 
{	
?>
	<table style="text-align: left; width: 100%;" border="0" cellpadding="2" cellspacing="2">
	<tbody>
		<tr>
			<td style="vertical-align: top;" colspan="2">
				<div class="feature">You are signed in as: <strong><?php echo $_SESSION['email']; ?></strong>.<br>To sign out, simply close your web browser.</div>
				<br>
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top;"><a href="#" onClick="opnN00sW1n();"><img src="images/ptools_newsletter.png" border="0" alt="" width="50" height="50"></a><br><br></td>
			<td style="vertical-align: top; width: 100%;"><a href="#" onClick="opnN00sW1n();">School Newsletter</a> - 
	<?php
		print date("F Y") . "<br>";
	?>
			</td>
		</tr>
		<tr>
			<td style="vertical-align: top;"><a href="https://www.facebook.com/pages/Guelph-Montessori-School/240892285956024?ref=ts" target="_blank"><img src="images/facebook_logo.png" border="0" alt="" width="50" height="50"></a><br><br></td>
			<td style="vertical-align: top;"><a href="https://www.facebook.com/pages/Guelph-Montessori-School/240892285956024?ref=ts" target="_blank">Parents' Facebook Group</a><br></td>
		</tr>
		<tr>
			<td style="vertical-align: top;"><a href="prnty3arca1.php" target="_blank"><img src="images/ptools_people.png" border="0" alt="" width="50" height="50"></a><br><br></td>
			<td style="vertical-align: top;"><a href="prnty3arca1.php" target="_blank">School Calendar</a> - for the 
	<?php 
		// Control for one versus two calendar years.
		if (IS_ONE_YEAR)
		{
			echo($currentYear);
		}
		else
		{
			$nextYear = $currentYear + 1;											
			echo($currentYear . "&ndash;" . $nextYear);
		}
	?>
			academic year</td>
		</tr>
	</tbody>
	</table>
<?php
}


function showLoginError() 
{
	echo "<span style='color:red;'><strong>Sorry!</strong> Your email and/or password were incorrect. Please try again.</span>\n";   // temporary only
}
?>