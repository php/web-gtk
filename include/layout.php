<?php
/*
 * $Id$ 
 */


# spacer()
# print a IMG tag for a sized spacer GIF
#

function spacer($width=1, $height=1, $align=false, $extras=false) {
	printf('<img src="/gifs/spacer.gif" width="%d" height="%d" border="0" alt="" %s%s>',
		$width,
		$height,
		($align ? 'align="'.$align.'" ' : ''),
		($extras ? $extras : '')
	);
}

# resize_image()
# tag the output of make_image() and resize it manually
#

function resize_image($img, $width=1, $height=1) {
	$str = preg_replace('/width=\"([0-9]+?)\"/i', '', $img );
	$str = preg_replace('/height=\"([0-9]+?)\"/i', '', $str );
	$str = substr($str,0,-1) . sprintf(' height="%s" width="%s">', $height, $width );
	return $str;
}

# make_image()
# return an IMG tag for a given file (relative to the images dir)
#

function make_image($file, $alt=false, $align=false, $extras=false, $dir=false, $border=0) {
	if (!$dir) {
	//ALTER FOR LOCAL $dir = '../../php-gtk-web/gifs';
		$dir = "/gifs";
	}
	if ($size = @getimagesize($_SERVER['DOCUMENT_ROOT'].$dir.'/'.$file)) {
		$image = sprintf('<img src="%s/%s" border="%d" %s ALT="%s" %s%s>',
			$dir,
			$file,
			$border,
			$size[3],
			($alt    ? $alt : ''),
			($align  ? ' align="'.$align.'"'  : ''),
			($extras ? ' '.$extras            : '')
		);
	} else {
		$image = sprintf('<img src="%s/%s" border="%d" ALT="%s" %s%s>',
			$dir,
			$file,
			$border,
			($alt    ? $alt : ''),
			($align  ? ' ALIGN="'.$align.'"'  : ''),
			($extras ? ' '.$extras            : '')
		);
	}
	return $image;
}

# print_image()
# print an IMG tag for a given file
#

function print_image($file, $alt=false, $align=false, $extras=false, $dir=false, $border=0) {
	print make_image($file, $alt, $align, $extras, $dir);
}

# make_submit()
#  - make a submit button image
#
function make_submit($file, $alt=false, $align=false, $extras=false, $dir=false, $border=0) {
	if (!$dir) {
	//ALTER FOR LOCAL $dir = '../../php-gtk-web/gifs';
		$dir = "/gifs";
	}
	$return = make_image($file, $alt, $align, $extras, $dir, $border);
	if ($return != "<img>") {
		$return = '<input type="image"'.substr($return,4);
	} else {
		$return = '<input type="submit">';
	}
	return $return;
}

# delim()
# print a pipe delimiter
#

function delim($color=false) {
	if (!$color) {
		return '&nbsp;|&nbsp;';
	}
	return sprintf('<font color="%s">&nbsp;|&nbsp;</font>', $color );
}

# hdelim()
# print a horizontal delimiter (just a wide line);
#

function hdelim($color = '#000000') {
    echo '<hr />';
}

# make_link()
# return a hyperlink to something, within the site
#

function make_link ($url, $linktext=false, $target=false, $extras=false) {
	return sprintf("<a href=\"%s\"%s%s>%s</a>",
		$url,
		($target ? ' target="'.$target.'"' : ''),
		($extras ? ' '.$extras : ''),
		($linktext ? $linktext : $url)
	);
}

# print_link()
# echo a hyperlink to something, within the site
#

function print_link($url, $linktext=false, $target=false, $extras=false) {
	echo make_link($url, $linktext, $target, $extras);
}

function make_email($email, $linktext=false) {
	return sprintf("<a href=\"mailto:%s\">%s</a>",
		$email,
		($linktext ? $linktext : $email)
	);
}

function print_email($email, $linktext=false) {
	echo make_email($email, $linktext);
}

# commonheader()
#
#

function commonHeader($title=false, $padding=true) {
	global $SIDEBAR_DATA, $MAGIC_COOKIE;
?><html>
<head>
 <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
 <title>PHP-GTK<?php if ($title) { echo ':'.$title; } ?></title>
 <link rel="stylesheet" href="/style.css" />
<!-- ALTER FOR LOCAL  "../../php-gtk-web/style.css" -->
 <link rel="shortcut icon" href="/gifs/favicon.ico" />
</head>

<body bgcolor="#FFFFFF" text="#000000" link="#000099" alink="#0000FF" vlink="#000099">
<a name="TOP"></a>
<table border="0" cellspacing="0" cellpadding="0" height="48" width="100%">
  <tr bgcolor="#0099cc">
    <td align="left" rowspan="2">
<?php print_link('/', make_image('php-gtk.gif', 'PHP-GTK', false, 'vspace="2" hspace="2"') ); ?><br>
    </td>
    <td align="right" valign="top" nowrap>
      <font color="#ffffff"><b>
        <?php echo strftime("%A, %B %d, %Y"); ?>
      </b>&nbsp;<br>
      </font>
    </td>
  </tr>

  <tr bgcolor="#0099cc">
    <td align="right" valign="bottom" nowrap>
      <?php
	print_link('/download.php', 'download', false, 'class="menuBlack"');
	echo delim();
	print_link('/docs.php', 'documentation', false, 'class="menuBlack"');
	/*ALTER FOR LOCAL docs.php*/
	echo delim();
	print_link('/wiki/Main/HomePage', 'wiki', false, 'class="menuBlack"');
	echo delim();
	print_link('/apps/', 'applications', false, 'class="menuBlack"');
	echo delim();
	print_link('/faq.php', 'faq', false, 'class="menuBlack"');
	echo delim();
	print_link('/changelog.php', 'changelog', false, 'class="menuBlack"');
	echo delim();
	print_link('/resources.php', 'resources', false, 'class="menuBlack"');
	if( isset($MAGIC_COOKIE) ) {
		echo delim();
		print_link('/admin-logout.php', 'logout', false, 'class="menuBlack"');
	}
      ?>&nbsp;<br>
      <?php spacer(2,2); ?><br>
    </td>
  </tr>

  <tr bgcolor="#000033"><td colspan="2"><?php spacer(1,1);?><br></td></tr>

  <tr bgcolor="#006699">
	<form method="POST" action="/search.php">
	<!-- CHANGE! need "../../php-gtk-web/search.php" -->
	<td align="right" valign="top" colspan="2" nowrap><font color="#ffffff">
	<small>search for</small>
<INPUT CLASS="small" TYPE="text" NAME="pattern" VALUE="<?php echo htmlspecialchars($prevsearch) ?>" SIZE="30">
<small>in the</small>
<SELECT NAME="show" CLASS="small">
<OPTION VALUE="manual">manual</OPTION>
<OPTION VALUE="whole-site">whole site</OPTION>
<OPTION VALUE="wiki">wiki</OPTION>
<OPTION VALUE="php-gtk-general-list">general mailing list</OPTION>
<OPTION VALUE="php-gtk-dev-list">development mailing list</OPTION>
<OPTION VALUE="php-gtk-doc-list">documentation mailing list</OPTION>
</SELECT>
<? echo make_submit('small_submit_white.gif', 'search', 'bottom');
?>&nbsp;<br>
</font></td>
</form>
</tr>

<tr bgcolor="#000033"><td colspan="2"><?php spacer(1,1);?><br></td></tr>
</table>


<table cellpadding="0" cellspacing="0">
 <tr valign="top">
<?php if (isset($SIDEBAR_DATA)):?>
  <td width="200" bgcolor="#f0f0f0">
   <table width="100%" cellpadding="4" cellspacing="0">
    <tr valign="top">
     <td class="sidebar"><?php echo $SIDEBAR_DATA?></td>
    </tr>
   </table>
  </td>
  <td bgcolor="#cccccc" background="/gifs/checkerboard.gif"><?php spacer(1,1);?><br /></td>
<?php endif; ?>
  <td>
   <table width="570" cellpadding="<?php if( $padding ) { print("10"); }else { print("0"); } ?>" cellspacing="0">
    <tr>
     <td valign="top">
<?php
}

# commonfooter()
#
#

function commonFooter($padding = true) {

    global $RIGHT_SIDEBAR_DATA;

	if( $padding ) {
		print("<br>");
	}
?>
     </td>
    </tr>
   </table>
  </td>
<?php if (isset($RIGHT_SIDEBAR_DATA)):?>
  <td bgcolor="#cccccc" background="/gifs/checkerboard.gif"><?php spacer(1,1);?><br /></td>
  <td width="185" bgcolor="#f0f0f0">
   <table width="100%" cellpadding="4" cellspacing="0">
    <tr valign="top">
     <td class="sidebar"><?php echo $RIGHT_SIDEBAR_DATA?></td>
    </tr>
   </table>
  </td>
<?php endif; ?>
 </tr>
</table>

<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr bgcolor="#000033"><td><?php spacer(1,1);?><br></td></tr>
  <tr bgcolor="#006699">
    <td align="right" valign="bottom"><?
      print_link('/source.php?url='.$_SERVER['SCRIPT_NAME'], 'show source', false, 'class="menuWhite"');
      echo delim();
      print_link('/credits.php', 'credits', false, 'class="menuWhite"');
      ?>&nbsp;<br>
    </td>
  </tr>
  <tr bgcolor="#000033"><td><?php spacer(1,1); ?><br></td></tr>
</table>

<table border="0" cellspacing="0" cellpadding="6" width="100%">
  <tr valign="top" bgcolor="#cccccc">
    <td><small>
      <?php print_link('http://www.php.net/', make_image('php-logo.gif', 'PHP', 'left') ); ?>
      <?php print_link('/copyright.php', 'Copyright &copy; 2001-' . date('Y') . ' The PHP Group'); ?><BR>
      All rights reserved.<BR>
      </small>
    </td>
    <td align="right"><small>
	  Last updated: <?php echo strftime("%c %Z", getlastmod()); ?><BR>
      </small><br>
    </td>
  </tr>
</table>

</body>
</html>
<?php

}

function clean_note($text) {
	$text = htmlspecialchars($text);
	$fixes = array('<br>','<p>','</p>');
	foreach ($fixes as $f) {
		$text=str_replace(htmlspecialchars($f), $f, $text);
		$text=str_replace(htmlspecialchars(strtoupper($f)), $f, $text);
	}
	$text = "<tt>".nl2br($text)."</tt>";
	return $text;
}

function sect_to_file($string) {
        $string = strtolower($string);
        $string = str_replace(' ','-',$string);
        $string = str_replace('_','-',$string);
        $func = "function.$string.php";
        $chap = "ref.$string.php";
        $feat = "features.$string.php";
        $struct = "control-structures.$string.php";
        if(is_file($func)) return $func;
        else if(is_file($chap)) return $chap;
        else if(is_file($feat)) return $feat;
        else if(is_file($struct)) return $struct;
        else return "$string.php";
}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim: expandtab sw=4 ts=4 fdm=marker
 */
?>
