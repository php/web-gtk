<?

require_once 'shared-manual.inc';

/*
if(!strstr($MYSITE,"www.php.net")) {
	Header("Location: http://www.php.net/manual/browse-notes.php");
	exit;
}
*/

commonHeader("Browse Manual Notes");
echo '<h1>Browse Manual Notes</h1>';

updateNotesVoting();

include 'browse.php';

commonFooter();


