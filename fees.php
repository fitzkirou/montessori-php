<?php
	$title = "Tuition and Fees";
	include("includes/header.php");
	include("gms4Adm1n/includes/library.php");
	
	// Query the database's "fee" table.
	$getAllFees  = 'SELECT * 	FROM fee';
	$getAllFees .= ' ORDER BY   fee_id ASC';
	$result = mysql_query($getAllFees);

	// Count the records in the 'fee' table.
	$rsltAllRecords = mysql_query('SELECT COUNT(*) FROM fee');
	if ($row = mysql_fetch_row($rsltAllRecords)) 
		$numberOfRecords = $row[0];
	else
		die('ERROR: Due to a mySQL query error, the fee records could not be counted.');

	// Get value for final record (highest id-value).
	$qryYearVal  =  'SELECT	* FROM fee';
	$qryYearVal .=  ' WHERE	  fee_id=' . $numberOfRecords;
	// Run the query.
	$year2Result = mysql_query($qryYearVal);
	// Exit if query failed.
	if (! $year2Result) {
		die('ERROR: In db SELECT query.<br><br>MySQL said: ' . mysql_error());
	}
	$year2row = mysql_fetch_array($year2Result);
	
	// ******************** VARS. USED BELOW IN FIELD OUTPUT ***********************
	$year2 = $year2row['amount'];
	$year1 = $year2 - 1;
	$cutOffYear = $year1 - 4;    //by inspection of exist. GMS fee table
	// *****************************************************************************
	
	// Headline
	echo("<h1>" . $title . "</h1>");
?>

<h2>
	Montessori Education Programs<br />
	for the Academic School Year<br>
<?php 
	// Show academic school year.
	echo 'September ' . $year1 . ' to June ' . $year2;
?>
</h2>

<h2>SCHEDULE A<br />
</h2>

<p><strong>PRIMARY HALF DAY PROGRAMS</strong><br />
    Five half days (mornings) per week, for children 2 1/2 to 4 years of age.<br />
    Mornings 8:30 a.m. to 11:30 a.m.<br />
    Annual tuition 
	<?php 
		echo showFee("Half Day");
	?>
	<br>
	Mornings <b>with catered lunch</b> daily 8:30 a.m. to 1:00 p.m.<br />
	Annual tuition 
	<?php 
		echo showFee("Half Day + Lunch");
	?>
</p>

<p><strong>PRIMARY FULL DAY PROGRAM</strong><br />
<strong>For students born after <?php echo "Dec.31." . $cutOffYear ?></strong><br />
Five full days per week, mornings, afternoons and a supervised catered lunch period <strong>for children 2.5 to 3 years and 8 months old</strong>. 
This program offers the students the opportunity to further develop their interests in the academic areas of the classroom. Includes hot lunch, two 
outdoor play periods and an afternoon quiet time daily.<br />
Daily 8:30 a.m. to 3:30 p.m.<br />
Annual tuition <?php echo showFee("Primary Full Day - Born After Dec 31"); ?> 
</p>

<p><strong>PRIMARY FULL DAY PROGRAM</strong><br />
<strong>For students born on or before <?php echo "Dec.31." . $cutOffYear ?> (JK Eligible)</strong><br />
Five full days per week, mornings, afternoons and a supervised lunch period <strong>for children 3 years and 8 months to 6 years of age</strong>. 
This program offers the students the opportunity to further develop their interests in the academic areas of the classroom, and prepare them for the 
elementary program.<br />
Daily 8:45 a.m. to 3:30 p.m.<br />
Annual tuition <?php echo showFee("Primary Full Day - Born On or Before Dec 31"); ?>

<hr width="62%">
<p><strong>ELEMENTARY FULL DAY PROGRAM &mdash; GRADES 1-6</strong><br />
    For children 6 to 12 years of age. A full academic program conducted in an 
    ungraded classroom environment that allows each child to independently function 
    at his/her own achievement level. Includes a supervised lunch period.<br />
    Daily 8:45 a.m. to 3:30 p.m.<br />
    Annual Tuition 
	<?php 
		echo showFee("Elementary");
	?>

<hr width="62%">
<!-- Toddler programs added 2006-03-19, RY. -->
<p>
	<strong>TODDLER FULL DAY PROGRAM &mdash; 5 Days per Week</strong><br />
    <strong>Five</strong> full days per week, mornings and afternoons with lunch provided for children 18 to 30 Months Old.<br />
    Daily 8:45 a.m. to 3:30 p.m.<br />
	Annual tuition 
	<?php 
		echo showFee("Toddler Full-Day - 5 Days/Week");
	?>
</p>
<p>
	<strong>TODDLER FULL DAY PROGRAM &mdash; 4 Days per Week</strong><br />
    <strong>Four</strong> full days per week, mornings and afternoons with lunch provided for children 18 to 30 Months Old.<br />
    8:45 a.m. to 3:30 p.m. <br />
    Annual tuition 
	<?php 
		echo showFee("Toddler Full-Day - 4 Days/Week");
	?>
</p>

<hr width="62%">
<p><strong>EXTENDED CARE</strong><br />
    Additional care is available daily before classes beginning at 7:45a.m. and 
    after classes until 5:30 p.m.
	
	<table border="0" cellspacing="2" cellpadding="2">
	  <tr>
		<th align="center" style="background-color:Goldenrod; color:#fff;">
			Description
		</th>
		<th align="center" style="background-color:Goldenrod; color:#fff;">
			Fee
		</th>
		<th align="center" style="background-color:Goldenrod; color:#fff;">
			Period
		</th>
	  </tr>
	  <tr>
		<td nowrap>Before and After School</td>
		<td style="text-align:right;">
			<?php 
				echo showFee("Before and After Hours");
			?>
		</td>
		<td>
			per month
		</td>
	  </tr>
	  <tr>
		<td>Before School Only</td>
		<td style="text-align:right;">
			<?php 
				echo showFee("Before School Only");
			?>
		</td>
		<td>
			per month
		</td>
	  </tr>
	  <tr>
		<td>After School Only</td>
		<td style="text-align:right;">
			<?php 
				echo showFee("After School Only");
			?>
		</td>
		<td>
			per month
		</td>
	  </tr>
	  <tr>
		<td nowrap>
			Occasional Use Before Hours
			&nbsp;&nbsp;&nbsp;
		</td>
		<td style="text-align:right;">
			<?php 
				echo showFee("Occasional Use Before Hours");
			?>
		</td>
		<td>
			per use
		</td>
	  </tr>
	  <tr>
		<td nowrap>Occasional Use After Hours</td>
		<td style="text-align:right;">
			<?php 
				echo showFee("Occasional Use After Hours");
			?>
		</td>
		<td>
			per use
		</td>
	  </tr>
	</table>
</p>

<br>
<h2><hr>PAYMENT PLANS</h2>

<p><strong>Plan A (Ten Installments)</strong><br />
    A registration deposit of one tenth of the annual tuition is due upon submission 
    of the Application For Enrollment and is non-refundable. The registration 
    deposit is the last installment. (June <?php echo $year2 ?>)
	<br /><br />
    Nine installments submitted in the form of post dated cheques each representative 
    of one tenth of the annual tuition must accompany the Application for Enrollment. 
    Cheques are payable to Guelph Montessori School and should be dated consecutively 
    for the first of each month beginning in September <?=$year1?> and ending in May 
    <?=$year2?>.</p>
<p><strong>Plan B (Twelve Installments/Discount for Siblings)</strong><br />
    Families sending more than one child to the Guelph Montessori School may take 
    advantage of Tuition Plan B provided that at least one of the children is 
    enrolled in either the Primary Full Day Program or Elementary Program.<br />
    This plan offers a 10% discount off the <strong><em>lower</em></strong> annual tuition fee, 
    and 20% off for each additional child, it also allows parents to 
    defer the total annual tuition of all children over a period of twelve months 
    (instead of ten months). 
	<br /><br />
    A registration deposit of one twelfth of the annual tuition (for all children) 
    is due upon submission of the Application for Enrollment and is non-refundable. 
    The registration deposit is the last installment. (July <?=$year2?>)
	<br /><br />
    Eleven installments submitted in the form of post dated cheques each representative 
    of one twelfth of the annual tuition must accompany the Application for Enrollment. 
    Cheques are payable to Guelph Montessori School and should be dated consecutively 
    for the first of each month beginning in 
	September <?=$year1?> and ending in July <?=$year2?>.</p>
<p><strong>Plan C (Full Payment Upon Registration)</strong><br />
    A 5% discount off the annual tuition fee will be given to parents who choose 
    to pay the full yearly tuition by June 01, <?=$year1?> (no exceptions).<br />
    <br />
    <strong style="color:#CC0000">* Please note that Plan C cannot be used in conjunction with Plan B.</strong>
</p>

<?php
	include ("includes/footer.php");
?>
