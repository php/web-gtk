<?php

commonHeader("Documentation");

$man_languages = array('en', 'de', 'fr', 'pt_BR');

?>

<h1>Documentation</h1>

<p>
The PHP-GTK manual is available online. You can choose between the printer
friendly and graphically designed versions. Please pick a language and format
from the table below.
</p>

<table border="0" cellpadding="3" cellspacing="2" width="100%">
<tr bgcolor="#cccccc"><th>Formats</th><th>Languages</th></tr>
<tr><th bgcolor="#dddddd">View Online</th><td bgcolor="#eeeeee">
<?php

  $lastlang = count($man_languages) - 1;
  foreach ($man_languages as $langnum => $langcode) {
    echo '<a href="/manual/' . $langcode . '/">' . $LANGUAGES[$langcode] . '</a>';
    echo ($lastlang != $langnum) ? ", " : "";
  }

?>
</td></tr>
<tr><th bgcolor="#dddddd">Printer friendly</th><td bgcolor="#eeeeee">
<?php

  foreach ($man_languages as $langnum => $langcode) {
    echo '<a href="/manual/' . $langcode . '/html/">' . $LANGUAGES[$langcode] . '</a>';
    echo ($lastlang != $langnum) ? ", " : "";
  }

?>
</td></tr>
<tr><th bgcolor="#dddddd">Downloads</th><td bgcolor="#eeeeee">
For other downloadable formats, please visit our
<a href="download-docs.php">documentation downloads</a> page.
</td></tr>
</table>

<?php commonFooter(); ?>
