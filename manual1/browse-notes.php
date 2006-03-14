<?php

require_once 'shared-manual1.inc';

/*
if(!strstr($MYSITE,"www.php.net")) {
	Header("Location: http://www.php.net/manual/browse-notes.php");
	exit;
}
*/

commonHeader("Browse PHP-GTK 1 Manual Notes");
echo '<h1>Browse PHP-GTK 1 Manual Notes</h1>';

updateNotesVoting();

include 'browse.php';

commonFooter();


