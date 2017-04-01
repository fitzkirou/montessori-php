<?php
$title = "Plug into the School Calendar";
include("includes/header.php");
echo("<h1>" . $title . "</h1>");
?>

<!--test stuff here-->Please contact us for more information or to set up an appointment. Phone Amir Gutman 
or Bridget Young, Administrators A.M.I., at <b>(519) 836-3810</b>, or send e-mail to 
<a href="mailto:guelphmontessori@rogers.com">guelphmontessori@rogers.com</a>.
<br><br>

<MM:BeginLock translatorClass="MM_SSI" type="ssi" orig="%3C?PHP
include (%22includes/footer.php%22);
?%3E" fileRef="includes/footer.php" depFiles="file:///C|/Bob/Web/montessori site/public_html/includes/footer.php">
			<div class="copyright">
				Copyright &copy; Guelph Montessori School, <?php echo(date(Y)); ?>.
			</div>

			<!-- Body content ends. -->
		</td>
		<!-- Right gutter -->
		<td width="75" valign="top">&nbsp;</td>
	</tr>

	<tr><!-- White space below content -->
		<td colspan="3" width="605" valign="top">&nbsp;
			
		</td>
	</tr>
<!-- End of page container table -->
</table>

<div class="footer">
	<style type="text/css">
		.MySQL {
			position: relative;
			top: -7px;
		}
	</style>
	<!-- Don't show these images 'cause they have white backgrounds. -->
	<!-- <a href="http://www.mysql.com"><img class="MySQL" align="right" src="admin/images/logo-mysql.gif" alt="Powered by MySQL" width="88" height="31" border="0"></a> -->
	<!-- <a href="http://www.php.net"><img align="right" src="admin/images/logo-php.gif" alt="Powered by PHP" width="88" height="31" border="0"></a> -->
	Guelph Montessori School, 151 Waterloo Avenue, Guelph, ON Canada N1H 3H9<br />
	<strong>(519) 836-3810</strong>. E-mail: <a href="mailto:guelphmontessori@rogers.com">guelphmontessori@rogers.com</a>
</div>

</div>

</body>
</html>

<?PHP
	mysql_close($dbh);
?>

<MM:EndLock>
