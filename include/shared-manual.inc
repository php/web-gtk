<?php // -*- C++ -*-

define(NAV_NONE, 0);
define(NAV_CLASSENTRY, 1);
define(NAV_CONSTRUCTOR, 2);
define(NAV_METHOD, 3);
define(NAV_SIGNAL, 4);
define(NAV_ENUM, 5);


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
	global $NEXT, $PREV, $UP, $HOME, $TOC, $PHP_SELF, $DOCUMENT_ROOT;
	global $SIDEBAR_DATA, $LANG;

	$SIDEBAR_DATA.= '<table border="0" CELLPADDING="4" CELLSPACING="0" WIDTH="160">';

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
	$SIDEBAR_DATA.= '</table>';

}

function navigationBar($title,$id,$loc) {
	global $NEXT, $PREV, $tstamp, $SERVER_NAME,$SERVER_PORT,$PHP_SELF;

	echo '<table border="0" width="580" bgcolor="#e0e0e0" cellpadding="0" cellspacing="4">';

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

	if ($loc == 'bottom') {

#		$back_url = 'http://' . $SERVER_NAME . 
#			(($SERVER_PORT==80) ? '' : ':'.$SERVER_PORT ) . 
#			$PHP_SELF;

	} else {

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
		}
	}

	echo '<br></small></td></tr>';
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

		print_link('/manual/admin-notes.php?action=edit+' . $row['id'] . '&brief=1',
			make_image('notes-edit.gif', 'edit note')
		);
		echo '&nbsp';
		print_link('/manual/admin-notes.php?action=reject+' . $row['id'] . '&brief=1&popup=1',
			make_image('notes-reject.gif', 'reject note'),
			'admin'
		);
		echo '&nbsp';
		print_link('/manual/admin-notes.php?action=delete+' . $row['id'] . '&brief=1&popup=1',
			make_image('notes-delete.gif', 'delete note'),
			'admin'
		);
	}
	echo '<br>';

	if ($show_rating) {
		echo 'rating: ';
		if ( $row['votes'] > 3 ) {
			printf('<b>%.02f<b> (%d votes)', $row['rate'], $row['votes'] );
		} else {
			echo '&lt; 3 votes';
		}
		echo ' | rate: ';
		for ($i=0; $i<=10; $i++) {
			if ($i) {
				echo ' <font color="#999999">|</font> ';
			}
			print_link($PHP_SELF.'?rate_id='.$row['id'].'&rate_note='.$i, $i);
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



function manualGetUserNotes($title, $id) {
	// if we're gtk.php.net, get it from the local DB
	// otherwise look in "/manual/usernotes/$title.txt" (if present)
	$notes = array();
	if ( true ) {
#	if(is_primary_site() || strstr($MYSITE,"localhost")) {
#		$host = '127.0.0.1';

		$host = 'localhost';
		$user = 'nobody';
		$pass = '';
		$db_id = @mysql_pconnect($host, $user, $pass);

		$query = "SELECT *, UNIX_TIMESTAMP(ts) AS xwhen, IF(votes=0, 0, rating/votes) AS rate FROM note " .
				"WHERE sect='$title' OR sect='$id' ORDER BY rate DESC, id";

		echo "<!-- $query -->\n";

		if ($db_id) {
			$result_id = mysql_db_query("gtk", $query, $db_id);
		}
		if ($result_id && mysql_num_rows($result_id) > 0) {
			while ($row = mysql_fetch_array($result_id)) {
				$notes[] = $row;
			}
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
	global $PHP_SELF, $SERVER_NAME, $SERVER_PORT, $LANG, $MYSITE;

	$cur = substr(dirname($PHP_SELF), -2);
	if($cur=='al') {
		$cur='en';
	}

	echo "<BR>\n\n";

	echo '<table border="0" cellpadding="4" cellspacing="0" width="100%">';

	$notes = manualGetUserNotes($title, $id);

	$back_url = 'http://' . $SERVER_NAME . 
		(($SERVER_PORT==80) ? '' : ':'.$SERVER_PORT ) . 
		$PHP_SELF;

	echo '<tr bgcolor="#d0d0d0" valign="top">';
	echo '<td><small>User Contributed Notes<br></small><b>' . $title . '</b><br></td>';
	echo '<td align="right">';
	print_link('/manual/add-note.php?sect='.$id.'&redirect='.$back_url,
		make_image('notes-add.gif','add a note')
	);      
	echo "&nbsp;";
	print_link('/manual/about-notes.php',
		make_image('notes-about.gif', 'about notes')
	);
	echo "<br></td>\n";
	echo "</tr>\n";

	if ( sizeof($notes) == 0 ) {

#		if ( !strstr($MYSITE,"gtk.php.net") ) {
		if ( false ) {
			echo '<tr valign="top">';
			echo '<td bgcolor="#e0e0e0" colspan="2">';
			echo 'User contributed notes are not available on this mirror site; try ';
			print_link('http://www.php.net/manual/'.$LANG.'/'.$id, 'here');
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
                print_link('/manual/add-note.php?sect='.$id.'&redirect='.$back_url,
                        make_image('notes-add.gif','add a note')
                );      
		echo "&nbsp;";
                print_link('/manual/about-notes.php',
                        make_image('notes-about.gif', 'about notes')
                );
		echo "<br></td>\n";
		echo "</tr>\n";

	}

	echo "</table><br><br>\n";
}



function manualLastModified($title, $id) {
	global $MYSITE, $SCRIPT_FILENAME;
#	if (is_primary_site()) {
	if ( true ) {
		$host = 'localhost';
		$user = 'nobody';
		$pass = '';
		$db_id = @mysql_pconnect($host, $user, $pass);
		$query = "SELECT UNIX_TIMESTAMP(ts) AS stamp FROM note WHERE sect = '$title' OR sect = '$id' ORDER BY ts DESC limit 1";
		if ($db_id) {
			$result_id = @mysql_db_query("gtk", $query, $db_id);
		} else {
			$result_id = 0;
		}
		if($result_id && mysql_num_rows($result_id)) {
			$t = mysql_fetch_row($result_id);
			Header("Last-Modified: ".gmdate("D, d M Y H:i:s",$t[0])." GMT");
		} else {
			Header("Last-Modified: ".gmdate("D, d M Y H:i:s",getlastmod())." GMT");
		}
		if ($result_id) {
			mysql_free_result($result_id);
		}
	}
}



function sendManualHeaders($charset,$lang) {
	global $LANG;
	$LANG = $lang;
	Header("Content-type: text/html;charset=$charset");
	Header("Content-language: $lang");
}



function manualHeader($title,$id="") {
	global $HTDIG, $LANGUAGES, $LANG, $SIDEBAR_DATA;
	manualLastModified($title,$id);
	makeBorderTOC($title);
	commonHeader('Manual: '.$title);
        # create links to plain html and other languages
	if (!$HTDIG) {
		navigationBar($title, $id, "top");
	}
}

function manualFooter($title,$id="") {
	global $HTDIG;
	if (!$HTDIG) {
		manualUserNotes($title,$id);
		navigationBar($title, $id, "bottom");
	}
	commonFooter();

}

