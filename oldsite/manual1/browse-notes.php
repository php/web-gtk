<?php

require_once 'shared-manual1.inc';

/*
if (!strstr($MYSITE,"gtk.php.net")) {
	header("Location: http://gtk.php.net/manual1/browse-notes.php");
	exit;
}
*/

commonHeader("Browse PHP-GTK 1 Manual Notes");
echo '<h1>Browse PHP-GTK 1 Manual Notes</h1>';

include 'browse.php';

commonFooter();
