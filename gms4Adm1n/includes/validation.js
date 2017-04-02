/*
** PROJECT: Guelph Montessori website administration
** PURPOSE OF FILE: A shared library of functions to validate form-fields.
** AUTHOR: Bob Young, 2003.
*/

/*
** Show a time-format error message and select the field.
*/
function showError(timeField)
{
	var message = "The time you just entered is invalid. \nPlease enter the hour and minutes, separated by a colon (e.g., 5:15 or 10:30).";
	alert (message);
	// Select the correct time field.
	if (timeField == "start")
	{
		document.forms[0].start_time.select();
	}
	else if (timeField == "end")
	{
		document.forms[0].end_time.select();
	}
}

/*
** Validate the time field on the "upcoming dates" form.
*/
function checkTime (userString, timeField)
{
	 // make sure we have a string.
	var userString = new String(userString.value);
	var stringLength = userString.length; // get the string length.
	
	// The string is less than 4 characters long
	if (stringLength < 4)
	{
		showError(timeField);
		return;
	}
	
	/* ---------------------------------------------------------------------------------
	** Case for a 4-character string
	** ---------------------------------------------------------------------------------
	*/
	if (stringLength == 4)
	{
		// There's no colon where it should be.
		if (userString.charAt(1) != ":")
		{
			showError(timeField);
			return;
		}
		// There's a character instead of a number.
		for (i = 0; i <= 3; i++)
		{
			if (i == 1) // Continue past the colon.
			{
				continue;
			}
			else if ( (userString.charAt(i) < "0") || (userString.charAt(i) > "9") )
			{
				showError(timeField);
				return;
			}
		}
	}
	
	
	/* ---------------------------------------------------------------------------------
	** Case for a 5-character string
	** ---------------------------------------------------------------------------------
	*/
	else if (stringLength == 5)
	{
		// There's no colon where it should be.
		if (userString.charAt(2) != ":")
		{
			showError(timeField);
			return;
		}
		// There's a character instead of a number.
		for (i = 0; i <= 4; i++)
		{
			if (i == 2) // Continue past the colon.
			{
				continue;
			}
			else if ((userString.charAt(i) < "0") || (userString.charAt(i) > "9"))
			{
				showError(timeField);
				return;
			}
		}
	}
}
