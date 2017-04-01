<?php
	/*
	You cannot simply delete a line from text file. 
	You have to read whole file into memory, delete line, 
	and save whole file to disk. Something like:
	*/

	$text = file('textfile'); 
	
	//find the line to delete, unset() it 
	
	$f = fopen('textfile','w'); 
	fputs($f, join('',$text)); 
	
	fclose($f); 	
?>