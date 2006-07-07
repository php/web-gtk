<?php

$last = '';
$used = array();

$let = isset($_GET['let']) ? $_GET['let'] : 'a';
if (strlen($let) > 1 || !preg_match("'[a-z]'", $let)) {
	$let = 'a';
}

$y = isset($_GET['y']) ? $_GET['y'] : date('Y', time());
if (strlen($y) != 4 || !preg_match("'[\d]{4}'", $y)) {
	$y = date('Y', time());
}

$db = sqlite_open($notesfile);
$query = sqlite_query($db, "SELECT DISTINCT $order FROM notes");

while ($row = sqlite_fetch_array($query, SQLITE_ASSOC)) {
	if ($order == 'date') {
		$year = date('Y', $row['date']);
		if (!in_array($year, $used)) {
			$used[] = $year;
		}
	} else {
		$first_letter = strtolower($row[$order][0]);
		if (!array_key_exists($first_letter, $used)) {
			$used[$first_letter] = true;
		}
	}
}
sqlite_close($db);

$links = array();

if ($order == 'date') {
	rsort($used);
	foreach ($used as $year) {
		$links[] = make_link("{$_SERVER['PHP_SELF']}?y=$year", "<b>$year</b>");
	}
} else {
	for ($i = ord('a'); $i <= ord('z'); $i++) {
		$letter = chr($i);
		if (isset($used[$letter])) {
			$links[] = make_link("{$_SERVER['PHP_SELF']}?let=$letter", "<b>$letter</b>");
		} else {
			$links[] = $letter;
		}
	}
}

$jumpbar = "<table border='0' cellpadding='4' cellspacing='0' width='100%'>\n".
	"<tr bgcolor='#d0d0d0' valign='top'>\n".
	"<td align='right' colspan='2'><small>Jump to: ".
	implode(" <span style='color:#999999'>|</span> ", $links).
	"<br /></small></td>\n".
	"</tr>\n".
	"</table><br />\n\n";

echo $jumpbar;

echo '<table border="0" cellpadding="4" cellspacing="0" width="100%">';

if (!isset($used[$let]) && $order != 'date') {
	echo '<tr><td colspan="2">No entries for <b>'.$let.'</b><br /></td></tr>';
	echo stretchPage(15);
	echo "&nbsp;</div>";
} else {
	$db = sqlite_open($notesfile);
	if ($order == 'date') {
		$query = sqlite_query($db, "SELECT * FROM notes WHERE strftime('%Y', date, 'unixepoch') = '$y' ORDER BY date DESC");
	} else {
		$query = sqlite_query($db, "SELECT * FROM notes WHERE lower(substr($order, 1, 1)) = '$let' ORDER BY lower($order)");
	}

	while ($row = sqlite_fetch_array($query, SQLITE_ASSOC)) {
		if ($order == 'page') {
			if ($row['page'] != $last) {
				makeTitle($row['page']);
				$last = $row['page'];
			}
		} else {
			makeTitle($row['page']);
		}
		makeEntry($row, $admin);
	}
	sqlite_close($db);
}

echo '</table>';
echo $jumpbar;
