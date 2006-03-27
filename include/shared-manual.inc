<?php

define(NAV_NONE, 0);
define(NAV_CLASSENTRY, 1);
define(NAV_CONSTRUCTOR, 2);
define(NAV_METHOD, 3);
define(NAV_SIGNAL, 4);
define(NAV_ENUM, 5);

mysql_connect("localhost","nobody","");
mysql_select_db("gtk");

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
	$tstamp = gmdate("D, d M Y",getlastmod());
}

function makeBorderTOC($this) {
	global $NEXT, $PREV, $UP, $HOME, $TOC;
	global $SIDEBAR_DATA;

	$SIDEBAR_DATA = '<form method="get" action="/manual1-lookup.php">';
	/* ALTER FOR LOCAL "../../php-gtk-web/manual1-lookup.php" */
	$SIDEBAR_DATA.= '<table border="0" CELLPADDING="4" CELLSPACING="0" WIDTH="160">';

	if(sizeof($TOC) > 1) {
	$SIDEBAR_DATA.= '<tr valign="top"><td><small>' .
		'lookup: <input type="text" class="small" name="function" size="10"> ' .
		make_submit('small_submit.gif', 'lookup', 'bottom') .
		'<br></small></td></tr>';

	$SIDEBAR_DATA.= '<tr bgcolor="#cccccc"><td></td></tr>';

	$SIDEBAR_DATA.= '<tr valign="top"><td>' . 
	make_link('./', make_image('caret-t.gif', $HOME[1]) . $HOME[1] ) . 
	'<br></td></tr>';

	$SIDEBAR_DATA.= '<tr bgcolor="#cccccc"><td></td></tr>';

	if (($HOME[1] != $UP[1]) && $UP[1]) {
		$SIDEBAR_DATA.= '<tr valign="top"><td>' . 
			make_link($UP[0], make_image('caret-u.gif', $UP[1]) . $UP[1] ) . 
			'<br></td></tr>';
	}

	$SIDEBAR_DATA.= '<tr valign="top"><td><small>';

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
			'<br>';
		}
		$SIDEBAR_DATA.= '</small></td></tr>';
	}
	$SIDEBAR_DATA.= '</table></form>';
}

function navigationBar($title, $id, $loc) {
	global $NEXT, $PREV, $tstamp;

	echo '<table border="0" width="100%" bgcolor="#e0e0e0" cellpadding="0" cellspacing="4">';

	echo '<tr><td>';
	if ($PREV[1]) {
		echo make_link( $PREV[0] , make_image('caret-l.gif', 'previous') . $PREV[1] ) ;
	}
	echo '<br></td>';

	echo '<td align="right">';
	if ($NEXT[1]) {
		echo make_link( $NEXT[0] , $NEXT[1] . make_image('caret-r.gif', 'next') ) ;
	}
	echo '<br></td>';
	echo '</tr>';

	echo '<tr bgcolor="#cccccc"><td colspan="2">';
	spacer(1,1);
	echo '<br></td></tr>';

	echo '<tr>';
	echo '<td align="right" colspan="2"><small>Last updated: '.$tstamp.'<br>';

#	if ($loc == 'bottom') {

#		$back_url = 'http://' . $_SERVER['SERVER_NAME'] . 
#			(($_SERVER['SERVER_PORT']==80) ? '' : ':'.$_SERVER['SERVER_PORT'] ) . 
#			$_SERVER['PHP_SELF'];

#	} else {

		global $LANGUAGES;
		$links = array();
		if($LANGUAGES){
			foreach($LANGUAGES as $code=>$name) {
				if (file_exists("../$code/$id")) {
					$links[] = make_link("../$code/$id", $name);
					}
				}
			}
		$file = substr($id,0,-4);
		if (file_exists("html/$file.html")) {
			$links[] = make_link("html/$file.html", 'Plain HTML');
		}
		if (count($links)) {
			echo 'view this page in ' . join (delim(), $links);
			echo '<br></small></td></tr>';
		}
	echo "</table>\n";
}

function makeTitle($title) {
	echo '<tr bgcolor="#d0d0d0" valign="top">';
	echo '<td colspan="2"><b>' . $title . '</b><br></td>';
	echo "</tr>\n";
}

function makeEntry($row, $show_admin = true, $show_rating = true ) {
	global $MAGIC_COOKIE;

	echo '<tr valign="top">';
	echo '<td bgcolor="#e0e0e0" colspan="2">';
	echo '<table border="0" cellpadding="2" cellspacing="0" width="100%">';
	echo '<tr valign="top"><td>';
	$name = htmlspecialchars($row['user']);
	if ($name && $name != "php-gtk@lists.php.net" && $name != "user@example.com") {
		if (ereg("(.+)@(.+)\.(.+)",$name)) {
			echo '<a href="mailto:'.$name.'">'.$name.'</a><br>';
		} else {
			echo '<b>'.$name.'</b><br>';
		}
	}
	echo '<small>' . date("d-M-Y h:i", $row['xwhen']) . '</small>';
	echo '<br></td>';
	echo '<td align="right" nowrap><small>';
	if (isset($MAGIC_COOKIE) && $show_admin) {

		print_link('/manual1/admin-notes.php?action=edit+' . $row['id'] . '&brief=1',
			make_image('notes-edit.gif', 'edit note')
		);
		echo '&nbsp';
		print_link('/manual1/admin-notes.php?action=reject+' . $row['id'] . '&brief=1&popup=1',
			make_image('notes-reject.gif', 'reject note'),
			'admin'
		);
		echo '&nbsp';
		print_link('/manual1/admin-notes.php?action=delete+' . $row['id'] . '&brief=1&popup=1',
			make_image('notes-delete.gif', 'delete note'),
			'admin'
		);
	}
	echo '<br>';

	if ($show_rating) {
		echo 'rating: ';
		if ( $row['votes'] > 2 ) {
			printf('<b>%.01f</b>', $row['rate'] );
		} else {
			echo '<b><font color="#cc0000">new</font></b>';
		}
		echo ' | rate: ';
		for ($i=1; $i<=5; $i++) {
			if ($i>1) {
				echo ' <font color="#999999">|</font> ';
			}
			print_link(htmlspecialchars($_SERVER['PHP_SELF']).'?rate_id='.$row['id'].'&rate_note='.$i, $i);
		}
		echo '<br>';
	}

	echo '</small></td></tr>';
	echo '<tr bgcolor="#f0f0f0"><td colspan="2">';
	echo clean_note($row['note']). '<br>';
	echo '</td></tr>';
	echo '</table>';
	echo '</td></tr>';
}

function updateNotesVoting() {

	# probably a better way/place to do this, but ...

	if ($_GET['rate_id'] && $_GET['rate_note']) {
		$p = parse_url($_SERVER['HTTP_REFERER']);

echo "\n\n<!-- " . $p['path'] . " :: " . $_SERVER['SCRIPT_NAME'] . " -->\n\n";

		/* prevent outside scripts from voting */
		if ($_SERVER['SCRIPT_NAME']==$p['path']) {
			$query = 'UPDATE note SET votes=votes+1, rating=rating+' . 
				min(5, $_GET['rate_note']) .
				' WHERE id=' . $_GET['rate_id'];
			$result_id = @mysql_query($query);
		}
	}
}

function manualGetUserNotes($title, $id) {
	// if we're gtk.php.net, get it from the local DB
	// otherwise look in "/manual1/usernotes/$title.txt" (if present)
	$notes = array();
#	if(is_primary_site() || strstr($MYSITE,"localhost")) {

	if ( true ) {

		updateNotesVoting();

		$query = "SELECT *, UNIX_TIMESTAMP(ts) AS xwhen, IF(votes=0, 10, rating/votes) AS rate FROM note " .
				"WHERE sect='$title' OR sect='$id' ORDER BY xwhen DESC, id";

echo "\n\n<!-- DEBUG: $query -->\n\n";

		$result_id = @mysql_query($query);
		if ($result_id && mysql_num_rows($result_id) > 0) {
echo "\n\n<!-- DEBUG: numrows=" . mysql_num_rows($result_id) . " -->\n\n";
			while ($row = mysql_fetch_array($result_id)) {
				$notes[] = $row;
			}
		} else {
echo "\n\n<!-- DEBUG: err=" . @mysql_error($result_id) . " -->\n\n";
		}
	} else {
		$notes_file = "../usernotes/" . urlencode( $title ) . ".txt";
		if ( @file_exists( $notes_file ) )
		{
			$fp = @fopen($notes_file,"r");
			if ($fp) {
				$body = fread($fp,filesize($notes_file));
				if (strlen($body)) {
					$notes = @unserialize($body);
				}
				fclose($fp);
			}
		}
	}
	return $notes;
}

function manualUserNotes($title, $id) {
	global $LANG, $MYSITE;

	$cur = substr(dirname($_SERVER['PHP_SELF']), -2);
	if($cur=='al') {
		$cur='en';
	}

	echo "<BR>\n\n";

	echo '<table border="0" cellpadding="4" cellspacing="0" width="100%">';

	$notes = manualGetUserNotes($title, $id);

	$back_url = 'http://' . $_SERVER['SERVER_NAME'] . 
		(($SERVER_PORT==80) ? '' : ':'.$_SERVER['SERVER_PORT'] ) . 
		htmlspecialchars($_SERVER['PHP_SELF']);

	echo '<tr bgcolor="#d0d0d0" valign="top">';
	echo '<td><small>User Contributed Notes<br></small><b>' . $title . '</b><br></td>';
	echo '<td align="right">';
	print_link('/manual1/add-note.php?sect='.$id.'&redirect='.$back_url,
		make_image('notes-add.gif','add a note')
	);
	echo "&nbsp;";
	print_link('/manual1/about-notes.php',
		make_image('notes-about.gif', 'about notes')
	);
	echo "<br></td>\n";
	echo "</tr>\n";

	if ( sizeof($notes) == 0 ) {

		if ( false ) {
			echo '<tr valign="top">';
			echo '<td bgcolor="#e0e0e0" colspan="2">';
			echo 'User contributed notes are not available on this mirror site; try ';
			print_link('http://gtk.php.net/manual1/'.$LANG.'/'.$id, 'here');
			echo '.<br></td></tr>';
		} else {
			echo '<tr valign="top">';
			echo '<td bgcolor="#e0e0e0" colspan="2">';
			echo 'There are no user contributed notes for this page.';
			echo '<br></td></tr>';
		}

	} else {

		foreach($notes as $note) {
			makeEntry($note);
		}

		echo "<tr bgcolor=\"#d0d0d0\" valign=\"top\">\n";
		echo "<td colspan=\"2\" align=\"right\">\n";
		print_link('/manual1/add-note.php?sect='.$id.'&redirect='.$back_url,
			make_image('notes-add.gif','add a note')
			);
		echo "&nbsp;";
		print_link('/manual1/about-notes.php',
			make_image('notes-about.gif', 'about notes')
			);
		echo "<br></td>\n";
		echo "</tr>\n";
	}
	echo "</table><br><br>\n";
}

function sendManualHeaders($charset, $LANG) {
	global $LANG;
	Header("Content-type: text/html;charset=UTF-8");
	Header("Content-language: $LANG");
}

function manualHeader($title, $id="") {
	global $HTDIG;

	makeBorderTOC($title);
	commonHeader('PHP-GTK 1 Manual : '.$title);
	# create links to plain html and other languages
	if (!$HTDIG) {
		navigationBar($title, $id, "top");
	}
}

function manualFooter($title, $id="") {
	global $HTDIG;
	if (!$HTDIG) {
		manualUserNotes($title,$id);
		navigationBar($title, $id, "bottom");
	}
	commonFooter();
}

function dehtmlspecialchars($str) {

	$str = str_replace("&gt;",">",$str);
	$str = str_replace("&lt;","<",$str);
	$str = str_replace("&quot;","\"",$str);
	$str = str_replace("&amp;","&",$str);
	return $str;
}

?>
