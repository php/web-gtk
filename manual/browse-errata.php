<?

$mailto = 'gtk-webmaster@php.net';

/*
if(!strstr($MYSITE,"www.php.net")) {
	Header("Location: http://www.php.net/manual/browse-errata.php");
	exit;
}
*/

commonHeader("Manual Errata");

mysql_connect("localhost");
mysql_select_db("gtk");

$links = array();
for($i=ord('a'); $i<=ord('z'); $i++ ) {
	$links[] = make_link($PHP_SELF.'?let='.chr($i), chr($i) );
}

echo '<table border="0" cellpadding="4" cellspacing="0" width="100%">';
echo '<tr bgcolor="#d0d0d0" valign="top">';
echo '<td colspan="2"><small>Jump to: ' . join (' | ', $links ) . '<br></td>';
echo "</tr>\n";

if(!$let) {
	$let = 'a';
}

$query = "SELECT *, UNIX_TIMESTAMP(ts) AS my_when FROM note where sect like '$let%' ORDER BY sect, ts";
$result = mysql_query($query) or die(mysql_error());
if ( mysql_num_rows($result) > 0) {
	$last = '';
	while ($row = mysql_fetch_array($result)) {
		if ($row['sect'] != $last)  {
			makeTitle( $row['sect'] );
			$last = $row['sect'];
		}
		makeEntry($row['my_when'], $row['user'], $row['note'] );
	}

} else {

	echo '<TR><TD COLSPAN="2">No entries for <B>'.$let.'</B>.<BR></TD></TR>';

}

echo '</table>';
commonFooter();

?>
