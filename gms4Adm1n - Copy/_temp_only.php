// ---------------------------------------------------------------
	// Mainline logic to send password e-blast.
	// ---------------------------------------------------------------
	/* 
		CODING TO HANDLE YES/NO ANSWER "REALLY SEND E-BLAST?"
	*/
	//blastPasswords();
	
	
	// ---------------------------------------------------------------
	// Function Definitions
	// ---------------------------------------------------------------
	
	function blastPasswords() 
	{
		//$parentFile = "../../prntL1st_11-12.csv";
		$parentFile = "../../prntTest_11-12.txt";   // 4-line test file
		
		if (file_exists($parentFile)) 
		{
			$file_handle = fopen($parentFile, "r");
			
			while (!feof($file_handle)) 
			{
				// Get fields-array from current line ("record").
				$recField = fgetcsv($file_handle, 1000); //Char-length param. for max. speed
				/*
					CODING TO SEND THE E-BLAST.
				*/
			}
			return $returnValue;    //May or may not need this.
		}
		else 
		{
			print "<span style=\"color:red;\">SYSTEM ERROR:<br>Parent list has incorrect filename, or it doesn't exist. Contact the Guelph Montessori administrator.</span><br><br>";
		}
	}

	
	// ---------------------------------------------------------------
	// Housekeeping
	// ---------------------------------------------------------------
	
	include("includes/form_end.php");
	finishUp();   //Include footer.php and close the connection to MySQL server.