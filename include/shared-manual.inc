<?php

require_once('cvs-auth.inc');

define('NAV_NONE', 0);
define('NAV_CLASSENTRY', 1);
define('NAV_CONSTRUCTOR', 2);
define('NAV_METHOD', 3);
define('NAV_SIGNAL', 4);
define('NAV_ENUM', 5);

$NEXT = $PREV = $UP = $HOME = array(false, false);
$TOC = array();
$SIDEBAR_DATA = '';

function recursive_trim(&$s, $k) {
	if (is_array($s)) {
		array_walk($s, 'recursive_trim');
	} else {
		$s = trim($s);
	}
}

function setupNavigation($data) {
	global $NEXT, $PREV, $UP, $HOME, $TOC, $tstamp;

	@array_walk($data, 'recursive_trim');
	$HOME = @$data["home"];
	$HOME[0] = "./";
	$NEXT = @$data["next"];
	$PREV = @$data["prev"];
	$TOC =  @$data["toc"];
	$UP = @$data["up"];
	$tstamp = gmdate("D, d M Y", getlastmod());
}

function makeBorderTOC($this) {
	global $NEXT, $PREV, $UP, $HOME, $TOC;
	global $SIDEBAR_DATA;

	$SIDEBAR_DATA = '<form method="get" action="/manual-lookup.php">';
	$SIDEBAR_DATA.= '<table border="0" cellpadding="4" cellspacing="0" width="160">';

	if(sizeof($TOC) > 1) {
	$SIDEBAR_DATA.= '<tr valign="top"><td><small>' .
		'lookup: <input type="text" class="small" name="function" size="10"/> ' .
		make_submit('small_submit.gif', 'lookup', 'bottom') .
		'<br /></small></td></tr>';

	$SIDEBAR_DATA.= '<tr bgcolor="#cccccc"><td></td></tr>';

	$SIDEBAR_DATA.= '<tr valign="top"><td>' . 
	make_link('./', make_image('caret-t.gif', $HOME[1]) . $HOME[1] ) . 
	'<br /></td></tr>';

	$SIDEBAR_DATA.= '<tr bgcolor="#cccccc"><td></td></tr>';

	if (($HOME[1] != $UP[1]) && $UP[1]) {
		$SIDEBAR_DATA.= '<tr valign="top"><td>' . 
			make_link($UP[0], make_image('caret-u.gif', $UP[1]) . $UP[1] ) . 
			'<br /></td></tr>';
	}

	$SIDEBAR_DATA.= '<tr valign="top"><td>';

	for ($i = 0; $i < count($TOC); $i++) {
		list($url, $title, $type) = $TOC[$i];
		if (!$url || !$title) {
			continue;
		}
		$end = '0.gif';
		if ($title == $this) {
			$end = '1.gif';
		}

		switch($type) {
			case NAV_CLASSENTRY:
				$img = "icon-o".$end;
				break;
			case NAV_CONSTRUCTOR:
				$img = "icon-c".$end;
				break;
			case NAV_METHOD:
				$img = "icon-m".$end;
				break;
			case NAV_SIGNAL:
				$img = "icon-s".$end;
				break;
			case NAV_ENUM:
				$img = "icon-e".$end;
				break;
			default:
				$img = "box-".$end;
		}

		if ($UP[0] == 'funcref.php') {
			$title = eregi_replace(" functions\$", "", $title);
		}
		$SIDEBAR_DATA .= '&nbsp;' . 
			make_link($url, make_image($img, $title) . $title ) . 
			'<br />';
		}
		$SIDEBAR_DATA.= '</td></tr>';
	}
	$SIDEBAR_DATA.= '</table></form>';
}

function navigationBar($title, $id, $loc) {
	global $NEXT, $PREV, $tstamp, $LANGUAGES, $man2_languages;

	echo '<table border="0" width="100%" bgcolor="#e0e0e0" cellpadding="0" cellspacing="4">';
	echo '<tr><td>';

	if ($PREV[1]) {
		echo make_link( $PREV[0] , make_image('caret-l.gif', 'previous') . $PREV[1] ) ;
	}

	echo '<br /></td>';
	echo '<td align="right">';

	if ($NEXT[1]) {
		echo make_link( $NEXT[0] , $NEXT[1] . make_image('caret-r.gif', 'next') ) ;
	}

	echo '<br /></td>';
	echo '</tr>';
	echo '<tr bgcolor="#cccccc"><td colspan="2">';
	spacer(1,1);
	echo '<br /></td></tr>';
	echo '<tr>';
	echo '<td align="right" colspan="2"><small>Last updated: '.$tstamp.'<br />';

	$links = array();

	foreach($LANGUAGES as $code=>$name) {
		if (in_array($code, $man2_languages) && file_exists("../$code/$id")) {
			$links[] = make_link("../$code/$id", $name);
		}
	}

	$file = substr($id, 0, -4);

	if (file_exists("html/$file.html")) {
		$links[] = make_link("html/$file.html", 'Plain HTML');
	}

	if (count($links)) {
		echo 'view this page in ' . join (delim(), $links);
		echo '<br />';
	}
	echo '</small></td></tr>';

	echo "</table>\n";
}

function makeTitle($title) {

	echo "<tr bgcolor='#d0d0d0' valign='top'>\n";
	echo "<td colspan='2'><b>$title</b><br /></td>\n";
	echo "</tr>\n";
}

function makeEntry($row, $show_admin = false) {

	echo "<tr valign='top'>\n";
	echo "<td bgcolor='#e0e0e0' colspan='2'>\n";
	echo "<table border='0' cellpadding='2' cellspacing='0' width='100%'>\n";
	echo "<tr valign='top'>\n<td>\n";

	$name = $row['display'];

	if ($name) {
		echo "<b>$name</b><br />\n";
	}

	echo "<small>" . date('d-M-Y H:i', $row['date']) . "</small>\n";
	echo "<br />\n</td>\n";
	echo "<td align='right' nowrap><small>";

	if (get_user() && $show_admin) {

		$get = (isset($_POST['queue']) || array_key_exists('q', $_GET)) ? '&q': null;
		$get .= isset($_GET['let']) ? "&amp;let={$_GET['let']}" : null;
		$get .= isset($_GET['y']) ? "&amp;y={$_GET['y']}" : null;

		print_link("{$_SERVER['PHP_SELF']}?edit={$row['id']}$get",
			make_image('notes-edit.gif', 'edit note'));
		echo '&nbsp';
		print_link("{$_SERVER['PHP_SELF']}?reject={$row['id']}$get",
			make_image('notes-reject.gif', 'reject note'));
		echo '&nbsp';
		print_link("{$_SERVER['PHP_SELF']}?delete={$row['id']}$get",
			make_image('notes-delete.gif', 'delete note'));
	}
	echo "<br />\n";
	echo "</small></td>\n</tr>\n";
	echo "<tr bgcolor='#f0f0f0'>\n<td colspan='2'>\n";
	if (strstr($row['comment'], '&lt;?')) {
		$note = do_highlighting($row['comment']);
	} else {
		$note = nl2br(stripslashes($row['comment']));
	}
	echo "\n<br />\n".$note."\n<br />\n";
	echo "</td>\n</tr>\n";
	echo "</table>\n";
	echo "</td>\n</tr>\n";
}

function do_highlighting($orig_note) {

	$startcodes    = array();
	$endcodes      = array();
	$samples       = array();
	$clean_samples = array();

	$lines = explode("\n", $orig_note);
	$i = 0;

	/* find PHP start and end tags */
	foreach ($lines as $line) {
		if (strstr($line, '&lt;?')) {
			$startcodes[] = $i;
		}
		if (strstr($line, "?&gt;")) {
			$endcodes[] = $i;
		}
		$i++;
	}

	/* collect code samples */
	foreach($startcodes as $key => $startcode) {
		if (isset($endcodes[$key])) {
			$samples[] = array_slice($lines, $startcode, ($endcodes[$key] - ($startcode - 1)));
		}
	}

	/* clean code samples */
	if (!empty($samples)) {
		foreach($samples as $sample) {
			foreach($sample as $number => $sampleline) {
				$sample[$number] = strip_tags($sampleline);
			}
			$clean_samples[] = $sample;
		}

	}
	
	/* make the array be a string again */
	$data = implode("<br />\n", $lines);

	/* highlight code samples */
	if (!empty($clean_samples)) {
		foreach($clean_samples as $number => $sample) {
			$original = implode("<br />\n", $samples[$number]);
			$string = trim(implode("\n", $sample));
			$string = str_replace("&gt;", '>', $string);
			$string = str_replace("&lt;", '<', $string);
			$string = str_replace('&quot;', '"', $string);
			$string = str_replace('&amp;', '&', $string);

			ob_start();
			highlight_string($string);
			$highlit = ob_get_contents();
			ob_end_clean();

			$highlit = preg_replace("'([a-zA-Z0-9\=])&nbsp;'", "$1 ", $highlit);
			if (substr(PHP_OS, 0, 3) == 'WIN') {
				$highlit = str_replace("\r<br />", "<br />\r", $highlit);
			} else {
				$highlit = str_replace("\n<br />", "<br />\n", $highlit);
			}
			$data = str_replace($original, $highlit, $data);
		}
	}

	return $data;
}

function manualGetUserNotes($id) {

	global $okfile, $notesfile;

	$notes = array();

	if (file_exists($okfile) || $user = get_user()) {

		$db = sqlite_open($notesfile);
		$result = sqlite_array_query($db, "SELECT * FROM notes WHERE page = '$id' ORDER BY date DESC");
		foreach ($result as $row) {
			$notes[] = $row;
		}
		sqlite_close($db);
	}
	return $notes;
}

function manualUserNotes($title, $id) {

	$current = dirname($_SERVER['PHP_SELF']);
	$toplevel = substr($current, 0, strrpos($current, '/'));

	echo "<br />\n\n";
	echo '<table border="0" cellpadding="4" cellspacing="0" width="100%">';

	$notes = manualGetUserNotes($id);
	$ref = isset($_SERVER['HTTP_REFERER']) ? null : "?ref={$_SERVER['PHP_SELF']}";

	echo '<tr bgcolor="#d0d0d0" valign="top">';
	echo '<td><small>User Contributed Notes<br /></small><b>' . $id . '</b><br /></td>';
	echo '<td align="right">';
	print_link($toplevel.'/add-note.php'.$ref, make_image('notes-add.gif','add a note'));
	echo "&nbsp;";
	print_link($toplevel.'/about-notes.php'.$ref, make_image('notes-about.gif', 'about notes'));
	echo "<br /></td>\n";
	echo "</tr>\n";

	if (sizeof($notes) == 0) {

		echo '<tr valign="top">';
		echo '<td bgcolor="#e0e0e0" colspan="2">';
		echo 'There are no user contributed notes for this page.';
		echo '<br /></td></tr>';

	} else {

		foreach($notes as $note) {
			makeEntry($note);
		}

		echo "<tr bgcolor=\"#d0d0d0\" valign=\"top\">\n";
		echo "<td colspan=\"2\" align=\"right\">\n";
		print_link($toplevel.'/add-note.php'.$ref, make_image('notes-add.gif','add a note'));
		echo "&nbsp;";
		print_link($toplevel.'/about-notes.php'.$ref, make_image('notes-about.gif', 'about notes'));
		echo "<br /></td>\n";
		echo "</tr>\n";
	}
	echo "</table><br /><br />\n";
}

function sendManualHeaders($charset, $lang) {

	header("Content-type: text/html; charset=UTF-8");
	header("Content-language: $lang");
}

function manualHeader($title, $id="") {

	makeBorderTOC($title);
	commonHeader('PHP-GTK 2 Manual : '.$title);
	navigationBar($title, $id, "top");
}

function manualFooter($title, $id="") {

	manualUserNotes($title, $id);
	navigationBar($title, $id, "bottom");
	commonFooter();
}

function dehtmlspecialchars($str) {

	$str = str_replace("&gt;",">", $str);
	$str = str_replace("&lt;","<", $str);
	$str = str_replace("&quot;","\"", $str);
	$str = str_replace("&amp;","&", $str);
	return $str;
}

function makeAdminOpts() {
	global $SIDEBAR_DATA;

	if (isset($_POST['order'])) {
		$order = $_POST['order'];
	} elseif (isset($_COOKIE['order'])) {
		$order = $_COOKIE['order'];
	} else {
		$order = 'page';
	}

	$SIDEBAR_DATA = "<form method='POST' action='browse-notes.php'>\n".
	"<table border='0' cellpadding='0' cellspacing='0' align='center'>\n".
	"<tr><td valign='top' colspan='3'><br />\n".
	make_link('../admin-login.php', '<b>Admin home</b>')."<br />\n<br />\n</td></tr>\n";
	if (strstr($_SERVER['PHP_SELF'], '/manual/browse-notes.php')) {
		$SIDEBAR_DATA .= "<tr><td valign='top' colspan='3'>\n";
		if (!isset($_POST['queue']) && !array_key_exists('q', $_GET)) {
			$SIDEBAR_DATA .= make_link($_SERVER['PHP_SELF'].'?q','<b>Queue administration</b>');
		} else {
			$SIDEBAR_DATA .= make_link($_SERVER['PHP_SELF'],'<b>Notes administration</b>').
			"<input type='hidden' name='queue' value='1' />";
		}
		$SIDEBAR_DATA .= "<br />\n<br />\n</td></tr>\n";
	}
	$SIDEBAR_DATA .= "<tr><td valign='bottom' colspan='3'><br /><b>Order notes by:</b></td></tr>\n".
	"<tr><td valign='top'><br />page (default)</td>\n".
	"<td colspan='2'><br /><input type='radio' name='order' value='page'";
	if ($order == 'page') $SIDEBAR_DATA .= " checked";
	$SIDEBAR_DATA .= " /></td></tr>\n".
	"<tr><td valign='top'>user</td>\n".
	"<td colspan='2'><input type='radio' name='order' value='display'";
	if ($order == 'display') $SIDEBAR_DATA .= " checked";
	$SIDEBAR_DATA .= " /></td></tr>\n".
	"<tr><td valign='top'>date</td>\n".
	"<td><input type='radio' name='order' value='date'";
	if ($order == 'date') $SIDEBAR_DATA .= " checked";
	$SIDEBAR_DATA .= " /></td>\n<td>&nbsp;&nbsp;".
	make_submit('small_submit.gif', 'Order by', 'bottom', 'style = "height: 11; width: 11"').
	"</td></tr>\n</table>\n</form>\n";
}

?>
