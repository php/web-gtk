<?php

function common_header($title = "PHP-GTK")
{
?>
<html>
<!-- Start: common header -->
<head>
<title>PHP-GTK: PHP language bindings for GTK+ </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.title {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 36px; font-style: normal; font-weight: bolder}
.mtext {  font-family: "Times New Roman", Times, serif; font-size: 12pt; font-style: normal}
a { text-decoration:none }
.title2 {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 24px; font-style: normal; font-weight: bolder}

-->
</style>
</head>

<body bgcolor="#FFFFFF" text="#000000" link="#5B69A6" vlink="#5B69A6" alink="#FF0000" leftmargin="0" rightmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="#0080e5"> 
    <td width="132" bgcolor="#0080e5" height="74">
    <a href="http://gtk.php.net/">
     <img src="images/php_gtk_logo.gif" border="0" width="128" height="67"></td>
    </a>
    <td width="622" height="74" bgcolor="#0080e5"> 
      <h1>
       <font face="Arial, Helvetica, sans-serif" class="title" size="+6">
        <?php echo $title; ?>
       </font>
      </h1>
    </td>
    <td width="505" height="74">&nbsp;</td>
  </tr>
  <tr bgcolor="#0080e5"> 
    <td colspan="3" bgcolor="#000000" height="2"><img src="images/1b1.gif" width="100%" height="2"></td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="120" bgcolor="#ffffff" background="images/120b2.gif" valign="top"> 
      <table width="120" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><img src="images/120b2.gif" width="120" height="70"></td>
        </tr>
        <tr> 
          <td><a href="download.php"><img src="images/download.gif" width="120" height="30" alt="Information" border="0"></a></td>
        </tr>
        <tr> 
          <td><a href="manual.php"><img src="images/manual.gif" width="120" height="28" alt="Meetings" border="0"></a></td>
        </tr>
        <tr> 
          <td><a href="resources.php"><img src="images/resources.gif" width="120" height="28" alt="Developers" border="0"></a></td>
        </tr>
        <tr> 
          <td><a href="faq.php"><img src="images/faq.gif" width="120" height="28" alt="Resources" border="0"></a></td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
        </tr>
        <tr> 
               
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td><img src="images/120b2.gif" width="120" height="70"></td>
        </tr>
        <td></td>
        </tr>
      </table>
      <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
      </table>
    </td>
    <td valign="top"> 
      <!-- End: common header -->
<?php
}

function common_footer()
{
?>
     <!-- Start: Common Footer -->
    </td>
  </tr>
		</table>

			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr bgcolor="#000000"> 
					<td colspan="2" height="2"><img src="images/1b1.gif" width="100%" height="2"></td>
				</tr>  
				<tr>
					<td>
						
      <div align="right"> 
        <p><font size="1" face="Arial, Helvetica, sans-serif">This site is subject 
          to the following<font color="#0080e5"> <a href="license.php"><font color="#5B69A6">license</font></a></font><br>
          Questions about PHP-GTK should be sent <font color="#5B69A6"><a href="mailto:php-gtk@lists.php.net">here</a></font><br>
          Questions about the website shoud be sent to<font color="#5B69A6"> <a href="mailto:gtk-webmaster@php.net">gtk-webmaster@php.net</a></font><br>
          </font></p>
						</div>
					</td>
				</tr>
			</table>
		</body>
	</html>
<?php
}

?>
