<?php
$title = "Enrolment Application";
include("header_enrol.php");
include("../gms4Adm1n/includes/library.php");
?>

<!-- GMS APPLICATION FOR ENROLMENT -->
<form method="POST" action="enrol_process.php" name="enrolForm">
  <!-- DOCTOR-INFO TABLE -->
  <table
 style="text-align: left; width: 680px; background-color: rgb(255, 255, 255); margin-left: auto; margin-right: auto;"
 border="0" cellpadding="2" cellspacing="2">
    <tbody>
      <tr>
        <td colspan="5" rowspan="1" style="vertical-align: top; background-color: rgb(255, 204, 102);">Please 
fill in the following form. You'll be able to print a copy for your records.
<br><strong>TIP:</strong> Press TAB to move to the next field, and press Shift-TAB to move to the previous field.
        </td>
      </tr>
      <tr>
        <td colspan="5" rowspan="1" style="vertical-align: top; white-space: nowrap;"><img
 style="width: 110px; height: 126px;" alt="GMS Logo"
 src="../images/enrol/gms-logo-shrunk.png" align="left" hspace="10">
        <h1>Application for Enrollment</h1>
        Guelph Montessori School<br style="font-weight: bold;">
        <span style="font-weight: bold;"></span>(519) 836-3810 </td>
      </tr>
      <tr>
        <td>
        <h2>For</h2>
        </td>
        <td style="text-align: right;">First Name:</td>
        <td><input name="for_firstname" type="text"> </td>
        <td style="white-space: nowrap; text-align: right;">Last
Name:&nbsp;</td>
        <td style="text-align: right;"><input name="for_lastname"
 type="text"></td>
      </tr>
      <tr>
        <td colspan="5" rowspan="1" style="vertical-align: top;">
        <hr style="width: 100%; height: 2px;">
        <h2>Wellington Dufferin Guelph Public Health Student Data</h2>
        </td>
      </tr>
      <tr>
        <td style="vertical-align: top; white-space: nowrap;">Family
Doctor<br>
        </td>
        <td colspan="4" rowspan="1" style="vertical-align: top;"><input
 name="health_doctor" style="width: 100%;" type="text"></td>
      </tr>
      <tr>
        <td style="vertical-align: top;">Address<br>
        </td>
        <td colspan="4" rowspan="1" style="vertical-align: top;"><input
 maxlength="80" name="health_address" style="width: 100%;" type="text">
        </td>
      </tr>
      <tr>
        <td>Phone<br>
        </td>
        <td><input name="health_phone" type="text"> </td>
        <td style="text-align: right; white-space: nowrap;">Student's
own<br>
Ontario Health Card Number<br>
        </td>
        <td colspan="2" rowspan="1"><input name="health_card"
 type="text"> </td>
      </tr>
    </tbody>
  </table>
<!-- IMMUNIZATION TABLE -->
  <table
 style="text-align: left; width: 680px; background-color: rgb(255, 255, 255); margin-left: auto; margin-right: auto;"
 border="1" cellpadding="4" cellspacing="0">
    <tbody>
      <tr>
        <td style="text-align: center; vertical-align: bottom; width: 25%;">
            Date<br>
            yy mm dd
        </td>
        <td><img style="width: 25px; height: 108px;" alt="Pertussis" src="../images/enrol/disease_pertussis.gif"></td>
        <td><img style="width: 25px; height: 108px;" alt="Diphteria" src="../images/enrol/disease_diphtheria.gif"></td>
        <td><img style="width: 25px; height: 108px;" alt="Tetanus" src="../images/enrol/disease_tetanus.gif"></td>
        <td><img style="width: 25px; height: 108px;" alt="Polio" src="../images/enrol/disease_polio.gif"></td>
        <td><img style="width: 25px; height: 108px;" alt="Oral Polio" src="../images/enrol/disease_oral_polio.gif"></td>
        <td><img style="width: 25px; height: 108px;" alt="Measles" src="../images/enrol/disease_measles.gif"></td>
        <td><img style="width: 25px; height: 108px;" alt="Mumps" src="../images/enrol/disease_mumps.gif"></td>
        <td><img style="width: 25px; height: 108px;" alt="Rubella *" src="../images/enrol/disease_rubella.gif"></td>
        <td><img style="width: 25px; height: 108px;" alt="TB Skin Test &amp; Result" src="../images/enrol/disease_tb_test.gif"></td>
        <td><img style="width: 25px; height: 108px;" alt="Haemophilus b" src="../images/enrol/disease_haemophilus_b.gif"></td>
        <td><img style="width: 25px; height: 108px;" alt="Hepatitus B" src="../images/enrol/disease_hepatitis_b.gif"></td>
        <td style="text-align: center; vertical-align: bottom; width: 75%;">
            Comments Other<br>
            Immunization or Tests
        </td>
      </tr>
      
<!-- -----------------------------------------------------------------
    Each <tr> below shows the immunizations (shots) given on one date.
---- ----------------------------------------------------------------- --> 
      <tr>
        <!-- shot1Date -->
        <td colspan="1" rowspan="1" style="vertical-align: top; text-align: center;"><input size="8" name="shot1Date" maxlength="8" type="text"></td>
        <!-- shot1Diseases[] -->
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Pertussis" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Piphtheria" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Tetanus" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Polio" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Oral Polio" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Measles" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Mumps" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Rubella" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="TB Skin Test & Result" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Haemophilus b" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Hepatitis B" type="checkbox"></td>
        <!-- shot1Comment -->
        <td style="vertical-align: top;"><input maxlength="80" name="shot1Comment" style="width: 100%;" type="text">
        </td>
      </tr>
      
      <tr>
        <!-- shot1Date -->
        <td colspan="1" rowspan="1" style="vertical-align: top; text-align: center;"><input size="8" name="shot1Date" maxlength="8" type="text"></td>
        <!-- shot1Diseases[] -->
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Pertussis" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Piphtheria" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Tetanus" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Polio" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Oral Polio" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Measles" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Mumps" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Rubella" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="TB Skin Test & Result" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Haemophilus b" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Hepatitis B" type="checkbox"></td>
        <!-- shot1Comment -->
        <td style="vertical-align: top;"><input maxlength="80" name="shot1Comment" style="width: 100%;" type="text">
        </td>
      </tr>
      
      <tr>
        <!-- shot1Date -->
        <td colspan="1" rowspan="1" style="vertical-align: top; text-align: center;"><input size="8" name="shot1Date" maxlength="8" type="text"></td>
        <!-- shot1Diseases[] -->
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Pertussis" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Piphtheria" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Tetanus" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Polio" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Oral Polio" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Measles" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Mumps" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Rubella" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="TB Skin Test & Result" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Haemophilus b" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Hepatitis B" type="checkbox"></td>
        <!-- shot1Comment -->
        <td style="vertical-align: top;"><input maxlength="80" name="shot1Comment" style="width: 100%;" type="text">
        </td>
      </tr>
      
      <tr>
        <!-- shot1Date -->
        <td colspan="1" rowspan="1" style="vertical-align: top; text-align: center;"><input size="8" name="shot1Date" maxlength="8" type="text"></td>
        <!-- shot1Diseases[] -->
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Pertussis" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Piphtheria" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Tetanus" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Polio" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Oral Polio" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Measles" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Mumps" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Rubella" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="TB Skin Test & Result" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Haemophilus b" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Hepatitis B" type="checkbox"></td>
        <!-- shot1Comment -->
        <td style="vertical-align: top;"><input maxlength="80" name="shot1Comment" style="width: 100%;" type="text">
        </td>
      </tr>
      
      <tr>
        <!-- shot1Date -->
        <td colspan="1" rowspan="1" style="vertical-align: top; text-align: center;"><input size="8" name="shot1Date" maxlength="8" type="text"></td>
        <!-- shot1Diseases[] -->
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Pertussis" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Piphtheria" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Tetanus" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Polio" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Oral Polio" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Measles" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Mumps" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Rubella" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="TB Skin Test & Result" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Haemophilus b" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Hepatitis B" type="checkbox"></td>
        <!-- shot1Comment -->
        <td style="vertical-align: top;"><input maxlength="80" name="shot1Comment" style="width: 100%;" type="text">
        </td>
      </tr>
      
      <tr>
        <!-- shot1Date -->
        <td colspan="1" rowspan="1" style="vertical-align: top; text-align: center;"><input size="8" name="shot1Date" maxlength="8" type="text"></td>
        <!-- shot1Diseases[] -->
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Pertussis" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Piphtheria" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Tetanus" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Polio" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Oral Polio" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Measles" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Mumps" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Rubella" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="TB Skin Test & Result" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Haemophilus b" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Hepatitis B" type="checkbox"></td>
        <!-- shot1Comment -->
        <td style="vertical-align: top;"><input maxlength="80" name="shot1Comment" style="width: 100%;" type="text">
        </td>
      </tr>
      
      <tr>
        <!-- shot1Date -->
        <td colspan="1" rowspan="1" style="vertical-align: top; text-align: center;"><input size="8" name="shot1Date" maxlength="8" type="text"></td>
        <!-- shot1Diseases[] -->
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Pertussis" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Piphtheria" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Tetanus" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Polio" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Oral Polio" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Measles" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Mumps" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Rubella" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="TB Skin Test & Result" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Haemophilus b" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Hepatitis B" type="checkbox"></td>
        <!-- shot1Comment -->
        <td style="vertical-align: top;"><input maxlength="80" name="shot1Comment" style="width: 100%;" type="text">
        </td>
      </tr>
      
      <tr>
        <!-- shot1Date -->
        <td colspan="1" rowspan="1" style="vertical-align: top; text-align: center;"><input size="8" name="shot1Date" maxlength="8" type="text"></td>
        <!-- shot1Diseases[] -->
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Pertussis" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Piphtheria" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Tetanus" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Polio" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Oral Polio" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Measles" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Mumps" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Rubella" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="TB Skin Test & Result" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Haemophilus b" type="checkbox"></td>
        <td colspan="1" style="text-align: center;"><input name="shot1Diseases" value="Hepatitis B" type="checkbox"></td>
        <!-- shot1Comment -->
        <td style="vertical-align: top;"><input maxlength="80" name="shot1Comment" style="width: 100%;" type="text">
        </td>
      </tr>
      
  <!-- -------------- -->
  <!-- Disease Legend -->
  <!-- -------------- -->
  <table style="width: 680px; background-color: rgb(255, 255, 255); margin-left: auto; margin-right: auto;" border="0" cellpadding="4" cellspacing="0">
    <tbody>
      <tr>
        <td>*Pertusis = Whooping Cough</td>
        <td style="text-align:center;">*Tetanus = Lockjaw</td>
        <td style="text-align:right;">*Rubella = German Measles</td>
      </tr>
      <tr><td colspan="3"></td></tr>
      <tr>
        <td colspan="3">
			<strong>Immunization:</strong> By law, to attend school, your child's immunization record must be up to date. The Health Unit requires a complete list with dates of
			all immunization or a valid exemption form. Please complete the above chart. The booster doses of DPTP and MMR are due at 4-6 years of age. TdP
			is due at 14-16 years of age. Please let your school nurse or health unit know when these boosters or other immunization are given. If you cannot
			locate your child's record, please contact your previous physician or health unit for this information.
        </td>
        <tr><td colspan="3"></td></tr>
        <tr><td colspan="3">Etc. . . .</td></tr>
      </tr>
    </tbody>	
  </table>
</form>

<?php
	include("footer_enrol.php");
?>