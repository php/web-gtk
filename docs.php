<?php
/*
 * $Id$ 
 */

// Start output buffering in order to grab the data from the documentation
// CVS updates file (that is echoed when included) and save to a variable
// instead of echoing it right away.
ob_start();
?>
<div id="docsupdates">
<h3>Docs Updates</h3>
<?php
include_once 'manual/en/updates.php';
?>
</div>
<?php
$RIGHT_SIDEBAR_DATA = ob_get_clean();


$SIDEBAR_DATA = <<< EOF
<h3>FAQ</h3>
<p>The <a href="/faq.php">PHP-GTK FAQ</a> is your first stop for general 
    information and those questions that seem to be on most people&#8217;s 
    minds.</p>

<!--
<p>The <a href="/wiki/">PHP-GTK Wiki</a> also provides an <a href="/wiki/PhpGtk/PhpGtkFaq">extended 
    FAQ</a> section.</p>
-->

<h3>Changelog</h3>
<p>You can also find the <a href="/changelog.php">PHP-GTK Changelog</a> useful, 
    if you would like to look up changes between various versions of 
    PHP-GTK.</p>

<h3>More Information</h3>
<p>The <a href="/wiki/">PHP-GTK Wiki</a> is an excellent resource and 
    addendum to the documentation listed here.</p>

<h3>Sample Code</h3>
<p>Sample code and example scripts are often the best way to learn PHP-GTK. 
    The manual comes complete with a <a href="/manual1/en/tutorials.php">Tutorials
    section</a> that contains some sample code.  However, the Wiki also has a 
    <a href="/wiki/Code">code section</a> dedicated to samples.</p>
EOF;

commonHeader("Documentation");

?>

<h1>Documentation</h1>

<p>The documentation for PHP-GTK 2 is a work in progress, as can be seen from the
    updates list to the right. Translations are very much in the early stages, and
    will be added here as they start to come in.</p>

<p>Note that, in translated versions of the manual, untranslated sections will
    still be in English.</p>

<table border="0" cellpadding="3" cellspacing="2" width="100%">
    <tr bgcolor="#cccccc">
        <th>Formats</th>
        <th>Languages</th>
    </tr>
    <tr>
        <th bgcolor="#dddddd">View Online</th>
        <td bgcolor="#eeeeee">
<?php

$lastlang = count($man2_languages) - 1;
foreach ($man2_languages as $langnum => $langcode) {
	echo '<a href="/manual/'.$langcode.'/">'.$LANGUAGES[$langcode].'</a>';
	echo ($lastlang != $langnum) ? ", " : "";
}

?>
        </td>
    </tr>
    <tr>
        <th bgcolor="#dddddd">Printer friendly</th>
        <td bgcolor="#eeeeee">
<?php

foreach ($man2_languages as $langnum => $langcode) {
	echo '<a href="/manual/'.$langcode.'/html/index.html">'.$LANGUAGES[$langcode].'</a>';
	echo ($lastlang != $langnum) ? ", " : "";
}

?>
        </td>
    </tr>
    <tr>
        <th bgcolor="#dddddd">Downloads</th>
        <td bgcolor="#eeeeee">For other downloadable formats, please visit 
            our <a href="download-docs.php">documentation downloads</a> page.</td>
    </tr>
</table>

<p>The PHP-GTK 1 manual is available online in a selection of languages. You can 
    choose between the printer friendly and graphically designed versions. 
    Please pick a language and format from the table below.</p>

<p> Note, that many languages are just under translation, and the untranslated 
    parts are still in English. Also some translated parts might be outdated. 
    The translation teams are open to contributions. Please send an e-mail to
    <a href="mailto:php-gtk-doc+at+lists+dot+php+dot+net">php-gtk-doc at lists 
    dot php dot net</a> to offer your help.</p>

<table border="0" cellpadding="3" cellspacing="2" width="100%">
    <tr bgcolor="#cccccc">
        <th>Formats</th>
        <th>Languages</th>
    </tr>
    <tr>
        <th bgcolor="#dddddd">View Online</th>
        <td bgcolor="#eeeeee">
<?php

$lastlang = count($man_languages) - 1;
foreach ($man_languages as $langnum => $langcode) {
	echo '<a href="/manual1/'.$langcode.'/">'.$LANGUAGES[$langcode].'</a>';
	echo ($lastlang != $langnum) ? ", " : "";
}

?>
        </td>
    </tr>
    <tr>
        <th bgcolor="#dddddd">Printer friendly</th>
        <td bgcolor="#eeeeee">
<?php

foreach ($man_languages as $langnum => $langcode) {
	echo '<a href="/manual1/'.$langcode.'/html/index.html">'.$LANGUAGES[$langcode].'</a>';
	echo ($lastlang != $langnum) ? ", " : "";
}

?>
        </td>
    </tr>
    <tr>
        <th bgcolor="#dddddd">Downloads</th>
        <td bgcolor="#eeeeee">For other downloadable formats, please visit 
            our <a href="download-docs.php">documentation downloads</a> 
            page.</td>
        
    </tr>
</table>

<?php 
commonFooter();

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim: expandtab sw=4 ts=4 fdm=marker
 */
?>
