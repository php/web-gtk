<?php

$SIDEBAR_DATA='
<h3>Documentation online</h3>
<p>
You can read the <a href="/docs.php">documentation online</a>.
</p>

<h3>File sizes and dates</h3>
<p>
If you are using a capable browser, the file size and
date will show up when you move the mouse above the link.
If you use another browser, or would like to see all the
information, you can <a href="/download-docs.php?sizes=1">click
here to see all the file sizes and dates</a>.
</p>

<h3>Tip for Windows users</h3>
<p>
Note, that the recent versions of WinZip and other
zip programs on Windows can handle .tar.gz compressed
files. If you have such a program, you can save
download time for yourself, if you choose the .tar.gz
formats, instead of .zip.
</p>
';

commonHeader("Download documentation");

# array structure: (header, link_text, show_size_for_package)
$formats = array(
 "manual.txt.gz"           => array("Plain text",          "txt.gz"),
 "bigmanual.html.gz"       => array("Single HTML",         "html.gz"),
 "manual.tar.gz"           => array("Many HTML files",     "tar.gz"),
 "manual.tar.bz2"          => array("Many HTML files",     "tar.bz2"),
 "manual.zip"              => array("Many HTML files",     "zip")
);
?>

<h1>Download documentation</h1>

<p>
The PHP-GTK manual is available in various formats. Pick a language and
format from the table below to start downloading.
</p>

<p>
Note that the packaged HTML versions of the manual
(tar.gz, tar.bz2 and zip) don't contain any directories,
so all of the files will be dumped into your current working
directory when you expand the archive unless the tool you
use does otherwise.
</p>

<table border="0" cellpadding="2" cellspacing="1" width="100%">
 <tr bgcolor="#cccccc">
  <td>&nbsp;</td>
  <?php
	while (list($k, $v) = each($formats)) {
		echo "<th valign=\"bottom\">$v[0]</th>\n";
	}?>
 </tr>
 <?php
	while (list(,$langcode) = each($man_languages)) {
		$language = $LANGUAGES[$langcode];
		echo "<tr>\n<td bgcolor=\"#dddddd\"><b>$language</b></td>\n";
		reset($formats);
		while (list($fn,$details) = each($formats)) {
			echo "<td align=\"center\" bgcolor=\"#eeeeee\">";

			$link_to = "";
			if (file_exists("manual1/$langcode/$fn")) {
				$link_to = "manual1/$langcode/$fn";
			}
			elseif (file_exists("distributions/manual1/php_gtk_manual_$langcode.$details[1]")) {
				$link_to = "distributions/manual1/php_gtk_manual_$langcode.$details[1]";
			}
			elseif (file_exists("distributions/manual1/manual-$langcode.$details[1]")) {
				$link_to = "distributions/manual1/manual-$langcode.$details[1]";
			}

			if (!$link_to) {
			echo "&nbsp;";
			}
			else {
				$size = @filesize($link_to);
				$changed = @filemtime($link_to);
				$date_format = "j M Y"; // Part of the RFC date type (to be short)
				if ($size) {
					echo "<a href=\"$link_to\" title=\" Size: ", (int) ($size/1024), "Kb\n Date: ", date($date_format, $changed), "\">$details[1]</a>";
					if ($sizes) {
						echo "<br /><small>Size: ", (int) ($size/1024), "Kb<br />Date: ", date($date_format, $changed), "</small>";
					}
				} else {
					echo "&nbsp;";
				}
			}
			echo "</td>\n";
		}
		echo "</tr>\n";
	}
?>
</table>

<?php commonFooter(); ?>
