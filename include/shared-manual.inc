<?php // -*- C++ -*-

$NEXT = $PREV = $UP = $HOME = array(false, false);
$TOC = array();

$SIDEBAR_DATA = '';


function setupNavigation($data) {
    global $NEXT, $PREV, $UP, $HOME, $TOC, $tstamp;
    $HOME = @$data["home"];
    $HOME[0] = "./";
    $NEXT = @$data["next"];
    $PREV = @$data["prev"];
    $UP   = @$data["up"];
    $TOC =  @$data["toc"];
    $tstamp = gmdate("D, d M Y",getlastmod());
}



function makeBorderTOC($this) {
	global $NEXT, $PREV, $UP, $HOME, $TOC, $PHP_SELF, $DOCUMENT_ROOT;
	global $SIDEBAR_DATA, $LANG;

	$SIDEBAR_DATA = '<form method="GET" action="/manual-lookup.php">' .
	$SIDEBAR_DATA.= '<table border="0" CELLPADDING="4" CELLSPACING="0">';

	$SIDEBAR_DATA.= '<tr valign="top"><td><small>' .
		'<input type="hidden" name="lang" value="' . $LANG . '">' .
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
		list($url, $title) = $TOC[$i];
		if (!$url || !$title) {
			continue;
		}
		$img = 'box-0.gif';
		if ($title == $this) {
			$img = 'box-1.gif';
		}
		if ($UP[0] == 'funcref.php') {
			$title = eregi_replace(" functions\$", "", $title);
		}
		$SIDEBAR_DATA .= '&nbsp;' . 
			make_link($url, make_image($img, $title) . $title ) . 
			'<br>';
	}

	$SIDEBAR_DATA.= '</small></td></tr>';
	$SIDEBAR_DATA.= '</table></form>';

}

function navigationBar($title,$id,$loc) {
	global $NEXT, $PREV, $tstamp, $SERVER_NAME,$SERVER_PORT,$PHP_SELF;

	echo '<table border="0" width="620" bgcolor="#e0e0e0" cellpadding="0" cellspacing="4">';

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

		$back_url = 'http://' . $SERVER_NAME . 
			(($SERVER_PORT==80) ? '' : ':'.$SERVER_PORT ) . 
			$PHP_SELF;
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


function sendManualHeaders($charset,$lang) {
        global $LANG;
        $LANG = $lang;
	Header("Content-type: text/html;charset=$charset");
	Header("Content-language: $lang");
}

function manualHeader($title,$id="") {
	global $HTDIG, $LANGUAGES, $LANG, $SIDEBAR_DATA;
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
		navigationBar($title, $id, "bottom");
	}
	commonFooter();

}
?>
