<?

$query = "SELECT DISTINCT(LEFT(sect,1)) AS first FROM note ORDER BY first";
$result = mysql_query($query) or die(mysql_error());
$used = array();
$fl = '';
if ( mysql_num_rows($result) > 0) {
	while ($row = mysql_fetch_array($result)) {
		if (!$fl) {
			$fl = $row['first'];
		}
		$used[ $row['first'] ] = true;
	}
}

$links = array();
for($i=ord('a'); $i<=ord('z'); $i++ ) {
	$l = chr($i);
	if (isset($used[$l])) {
		$links[] = make_link($PHP_SELF.'?let='.$l, '<b>'.$l.'</b>' );
	} else {
		$links[] = $l;
	}
}

$jumpbar = '<table border="0" cellpadding="4" cellspacing="0" width="100%">' . 
	'<tr bgcolor="#d0d0d0" valign="top">' .
	'<td align="right" colspan="2"><small>Jump to: ' . 
	join (' <font color="#999999">|</font> ', $links ) . 
	'<br></small></td>' .
	"</tr>\n" .
	"</table><BR>\n\n";

echo $jumpbar;

if(!$let) {
	$let = $fl;
}

echo '<table border="0" cellpadding="4" cellspacing="0" width="100%">';

$query = "SELECT *, UNIX_TIMESTAMP(ts) AS xwhen, IF(votes=0, 10, rating/votes) AS rate FROM note " .
	"WHERE sect LIKE '$let%' ORDER BY sect, rate DESC, id";


$result = mysql_query($query) or die(mysql_error());
$numrows = mysql_num_rows($result);
if ( $numrows > 0) {
	$last = '';
	while ($row = mysql_fetch_array($result)) {
		if ($row['sect'] != $last)  {
			makeTitle( $row['sect'] );
			$last = $row['sect'];
		}
		makeEntry($row);
	}

} else if (!$fl) {

	echo '<TR><TD COLSPAN="2">No entries for any section</B>.<BR></TD></TR>';

} else {

	echo '<TR><TD COLSPAN="2">No entries for <B>'.$let.'</B>.<BR></TD></TR>';

}

echo '</table>';

if ($numrows > 10 ) {
	echo $jumpbar;
}

