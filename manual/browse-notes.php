<?

require_once 'shared-manual.inc';

/*
if(!strstr($MYSITE,"www.php.net")) {
	Header("Location: http://www.php.net/manual/browse-notes.php");
	exit;
}
*/

commonHeader("Browse Manual Notes");

mysql_connect("localhost");
mysql_select_db("gtk");


include 'browse.php';

commonFooter();

?>
