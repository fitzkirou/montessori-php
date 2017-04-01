<?php
	/* datafile.txt: 
	
	1||test line 1||description 1 
	2||test line 2||description 2 
	3||test line 3||description 3 
	4||test line 4||description 4 
	5||test line 5||description 5 
	6||test line 6||description 6 
	7||test line 7||description 7 
	8||test line 8||description 8 
	
	delete_record.php: 
	*/
	
	$datafile = 'datafile.txt';
	
	if (isset($_GET['id']) and is_numeric($_GET['id']) and ($_GET['id'] > 0)) 
	{
		$newfile = null;
		$id = $_GET['id'];
		$fh = fopen($datafile, "r") or die("cannot open file for reading");
		if (is_file($datafile) and $fh) 
		{
			while (!feof($fh)) 
			{
				$buffer = fgets($fh, 4096);
				// Only skip the line if it matches on the id.
				// otherwise compile all the contents into $newfile,
				// which we will use to overwrite $datafile. Include
				// the delimiter so it doesn't match on 42, 406, etc.
				// make sure it's writable.
				if (! preg_match("/^$id\|\|.*/",$buffer)) 
				{
					$newfile .= $buffer;
				}
			}
		}
		fclose($fh);
		$fh = fopen($datafile, "w") or die("cannot open file for writing");
		if (fwrite($fh, $newfile) === FALSE) 
		{
			die("Cannot write to $datafile");
		}
		fclose($fh);
		
		// check it  
		$contents = file_get_contents($datafile);
		echo "<pre>$contents</pre>"; 
	} 
	else 
	{
		echo "<p><a href=\"delete_record.php?id=4\">delete record 4</a></p>";
		$contents = file_get_contents($datafile);
		echo "<pre>$contents</pre>"; 
	}
	
	
	//It's a standard practice to have the unique identifier first 
	//in the list of fields, I suggest moving it, otherwise you would do something like 
	//if (! preg_match("/^[^\|]{2}?\|\|$id\|\|.*/",$buffer)) { 
	// etc. 
?>