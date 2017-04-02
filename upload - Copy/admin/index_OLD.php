<!DOCTYPE HTML PUBLIC "-//WC3//DTD HTML 4.0 Transitional//EN" 
"http://www.w3.org/TR/REC-html40/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
	<title>GMS EcoNewsletter Uploader</title>
	<style>body{font-family:verdana,arial,sans-serif;} div,h1{position:relative; left:60px;} h1{font-size:20px; color:#3c6bb1;}</style>
</head>
<body vlink="#0000ff">
	<img src="../../images/h_EcoSchoo_-banner.gif" width="800" height="119" border="0">
	<br><br><br><br><h1>Upload <em>Eco Maniacs</em> Newsletter</h1>
	<!-- Shift to align with header text.-->
	<div>
		
<?php
// If form has been sent, process it.
if ($_FILES["file"])    //IS THIS CORRECT ???
{
	/*if (($_FILES["file"]["type"] == "application/pdf") 
			&& ($_FILES["file"]["name"] == "es_news.pdf"))*/
	if ($_FILES["file"]["type"] == "application/pdf")
	  {
		  if ($_FILES["file"]["error"] > 0)
		    {
		    	echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
		    }
		  else
		    {
			    echo "<b>Upload successful!</b><br><br>";
			    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
			    echo "Type: " . $_FILES["file"]["type"] . "<br />";
			    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
			    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
				
			    //Look in the current ("upload") folder.
			    // COMMENT OUT BECAUSE WE *WANT* TO OVERWRITE THE EXISTING FILE.
			    //if (file_exists($_FILES["file"]["name"]))
			    //  {
			    //  	echo $_FILES["file"]["name"] . " already exists. ";
			    //  }
			    //else
			    //  {
			      	move_uploaded_file($_FILES["file"]["tmp_name"], "../es_news.pdf");
				    //move_uploaded_file($_FILES["file"]["tmp_name"], $_FILES["file"]["name"]);
			      	echo "Stored in: " . "upload/es_news.pdf";
			      	echo "<br><br><a href=\"http://guelphmontessori.com\">I'm done</a>";
			    //  }
		    }
	  }
	else
	  {
	  	echo "<span style=\"color:red;\">Invalid file type or file name.</span> ";
	  	echo "<a href=\"index.php\">Try again</a>";
	  }
}
// Else, show the input form
else
{
?>
	<form action="index.php" method="post" enctype="multipart/form-data">
		<label for="file">File to upload: </label>
		<input type="file" name="file" id="file">
		<br><hr width="674" align="left">
		<input type="submit" name="submit" value="Upload file"> 
		<input type="button" name="cancel" value="Cancel" onclick="javascript:window.history.go(-1);">
		<br><br><br><br>
		<em>Note:</em>
		<br>Large files may take many seconds to upload. Be patient -- wait for confirmation!
		<p style="margin-top:20px; font-size:10px;">
			Copyright &copy; Guelph Montessori School, 2010.
		</p>
	</form>
<?php 
}
?>

	</div>	
</body>
</html> 
