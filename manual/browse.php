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

echo '<table border="0" cellpadding="4" cellspacing="0" width="100%">';
echo '<tr bgcolor="#d0d0d0" valign="top">';
echo '<td align="right" colspan="2"><small>Jump to: ' . 
	join (' <font color="#999999">|</font> ', $links ) . 
	'<br></small></td>';
echo "</tr>\n";
echo "</table><BR>\n\n";

if(!$let) {
	$let = $fl ? $fl : 'a';
}

echo '<table border="0" cellpadding="4" cellspacing="0" width="100%">';

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


