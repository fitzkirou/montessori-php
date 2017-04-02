<?php
	/*
	** File: 		gms4Adm1n/pws31aster.php
	** Project: 	Parent Tools (admin. site) - Guelph Montessori School
	** Purpose: 	Sends an e-blast of passwords to the parent master-list.
	** Author: 		Bob Young, October 2011.
	*/
	include("includes/library.php"); //Include shared modules.
	$isViewAllLinked = true;  //Define global variables.
	$process = "Send";
	$item = "Password E-Blast";
	$action = "pws31aster.php";  //I.e., this file.
	prepare($isViewAllLinked,$process,$item,$action);

	
	// ---------------------------------------------------------------
	// Mainline logic to send password e-blast.
	// ---------------------------------------------------------------
	include("includes/form_start.php");  // Set up the HTML form from vars. above.
	
	if (isset($_POST["submit"])) 
	{	
		if (blastPasswords())
		{
			startRowWrapper();   // HTML table-row req'd as per page template.
			showAdminHomeLink();
			showConfirmationText();
			showEmailList();
			endRowWrapper();
		}
		else
		{
			die("<div style=\"color:#c00;\">Sending of emails failed.</div>");
		}
	}
	else
	{
		showForm();
	}
	
	include("includes/form_end.php");
	finishUp();
	
	
	// ---------------------------------------------------------------
	// Function Definitions
	// ---------------------------------------------------------------
	
	function blastPasswords() 
	{	
		$parentFile = "../../prntL1st.csv";
		//$parentFile = "../../prntTest_11-12.csv";   // 4-line test file
		
		if (file_exists($parentFile)) 
		{	
			$file_handle = fopen($parentFile, "r");
			while (!feof($file_handle)) 
			{
				// Get fields-array from current line ("record").
				$recField = fgetcsv($file_handle, 1000); //Char-length param. for max. speed
				// Assign surname and title var's. for use in $body string variable.
				$surname = getSurname($recField[0]);
				$sex = getSex($recField[0]);
				$title = getTitle($sex);
				
				$body = "Dear " . $title . $surname . ",\n\nThe Guelph Montessori School has a new sign-in page for secure access to the GMS newsletter, the school-year calendar, and the GMS Parents Facebook group.\n\nTo access these tools, go to the Guelph Montessori website, click on the \"Parent Tools\" link, and sign in with your username and password:\n\nUsername: " . $recField[1] . "\nPassword: " . $recField[2] . "\n\nPlease print out this email, or write down your username and password because you'll need them every time to sign in.\n\nSincerely,\n\nAmir Gutman, Administrator\nGuelph Montessori School";
				$isSent = mail($recField[1], "GMS Website Secure Log-in", $body);
			}
			return $isSent;
		}
		else 
		{
			print "<span style=\"color:red;\">SYSTEM ERROR:<br>Parent list has incorrect filename, or it doesn't exist. Contact the Guelph Montessori administrator.</span><br><br>";
		}
	}
	
	
	function getSurname ($strNameAndSex) 
	{
		if (getSex($strNameAndSex)=="M" OR getSex($strNameAndSex)=="F")
		{
			$surname = substr($strNameAndSex, 0, -6);  //Get all but last 6 char's.
		}
		else
		{
			$surname = $strNameAndSex;    //Use whole string 'cause no sex appended.
		}
		
		return $surname;
	}
	
	
	function getSex($strNameAndSex) 
	{
		$last5Characters = substr($strNameAndSex, -4, 3);
		
		if ($last5Characters == "dad") 
		{
			$sex = "M";
		}
		elseif ($last5Characters == "mom")
		{
			$sex = "F";
		}
		else
		{
			$sex = "unknown";
		}
		
		return $sex;
	}
	
	
	function getTitle($gender) 
	{
		if ($gender == "M")
			$title = "Mr. ";    // A space is appended for easy concatenation later.
		elseif ($gender == "F")
			$title = "Ms. ";
		elseif ($gender == "unknown")
			$title = "Mr./Ms. ";
			
		return $title;
	}
	
	
	function showForm() 
	{
		$parentFile = "../../prntL1st.csv";
		//$parentFile = "../../prntTest_11-12.csv";   // 4-line test file
		
		$numParents = countParents();
?>
		<tr valign="top">
			<td colspan="2" style="padding:10px; padding-top:20px;">
				<div>
					<span style="font-weight:bold; color:#c00;">WARNING!</span><br><br>
					Clicking on the "Send passwords" button will email passwords to 
					all <?php echo $numParents; ?> parents on the GMS master list. You should 
					only need to send out the passwords once per year.
					<br><br>ARE YOU SURE you want to send these <?php echo $numParents; ?> emails?<br><br>
					<!-- Form Buttons: -->
					<input type="submit" name="submit" value="Send passwords">
					<!-- "Cancel" button functions as a "Back" button. -->
					&nbsp;<input name="cancel" type="button" onClick="window.history.back();" value="Cancel">
					<br><br>
				</div>
			</td>
		</tr>
<?php
	}
	

	function countParents() 
	{
		$parentFile = "../../prntL1st.csv";
		//$parentFile = "../../prntTest_11-12.csv";   // 4-line test file
		
		$numLines = 0;
		if (file_exists($parentFile)) 
		{
			$file_handle = fopen($parentFile, "r");
			while (!feof($file_handle)) 
			{
				$recField = fgetcsv($file_handle, 1000); //Must do to avoid endless loop.
				$numLines = $numLines + 1;
			}
		}
		else 
		{
			print "<span style=\"color:red;\">SYSTEM ERROR:<br>Parent list has incorrect filename, or it doesn't exist. Contact the Guelph Montessori administrator.</span><br><br>";
		}
		
		return $numLines;
	}
	
	
	function showConfirmationText() 
	{
		print "<br><br><div style=\"margin-bottom:20px;\">Passwords have been sent successfully ";
		print "to the GMS parents who are listed below.<br>";
		print "<em>Time of Send</em>: " . date('l jS \of F Y h:i:s A');
		print "</div>";
	}
	
	
	function showEmailList() 
	{
		$parentFile = "../../prntL1st.csv";
		//$parentFile = "../../prntTest_11-12.csv";   // 4-line test file
		
		print '<table style="text-align: left; width: 100%;" border="0" cellpadding="0" cellspacing="0">';
		print '<tbody><tr><th>LAST NAME</th><th>EMAIL</th><th>PASSWORD</th></tr>';
		
		if (file_exists($parentFile)) 
		{
			$file_handle = fopen($parentFile, "r");
			while (!feof($file_handle)) 
			{
				// Get fields-array from current line ("record").
				$recField = fgetcsv($file_handle, 1000); //Char-length param. for max. speed
				// Show the last-name, email, and password values.
				print "<tr><td>".$recField[0]."</td><td>".$recField[1]."</td><td>".$recField[2]."</td></tr>";
			}
		}
		else 
			print "<span style=\"color:red;\">SYSTEM ERROR:<br>Parent list has incorrect filename, or it doesn't exist. Contact the Guelph Montessori administrator.</span><br><br>";
		
		print "</tbody></table>";
	}
	
	
	function showAdminHomeLink() 
	{
		print "<div><a href=\"#\" onclick=\"printpage();\">Print...</a>&nbsp;&nbsp;<a href=\"http://www.guelphmontessori.com/gms4Adm1n\">Admin Home</a>";
	}
	
	
	function startRowWrapper() 
	{
?>
		<tr valign="top">
			<td colspan="2" style="padding:10px; padding-top:20px;">
				<div>
<?php
	}
	
	function endRowWrapper() 
	{
?>
					<br><br>
				</div>
			</td>
		</tr>
<?php 	
	}
?>