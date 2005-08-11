<?php
/* $Id$ */

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
    $str = preg_replace('/width=\"([0-9]+?)\"/i', '', $img);
    $str = preg_replace('/height=\"([0-9]+?)\"/i', '', $str);
    $str = substr($str, 0, -1) . sprintf(' height="%s" width="%s">', $height, $width);
    return $str;
}

# make_image()
# return an IMG tag for a given file (relative to the images dir)
#
function make_image($file, $alt=false, $align=false, $extras=false, $dir=false, $border=0) {
    if (!$dir) {
        // ALTER FOR LOCAL $dir = '../../php-gtk-web/gifs';
        $dir = "/gifs";
    }
    
    if ($size = @getimagesize($_SERVER['DOCUMENT_ROOT'].$dir.'/'.$file)) {
        $image = sprintf('<img src="%s/%s" border="%d" %s alt="%s" %s%s>',
            $dir,
            $file,
            $border,
            $size[3],
            ($alt    ? $alt : ''),
            ($align  ? ' align="'.$align.'"'  : ''),
            ($extras ? ' '.$extras            : '')
        );
    } else {
        $image = sprintf('<img src="%s/%s" border="%d" alt="%s" %s%s>',
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
        $return = '<input type="image"' . substr($return,4);
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
    return sprintf('<font color="%s">&nbsp;|&nbsp;</font>', $color);
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
function make_link($url, $linktext=false, $target=false, $extras=false) {
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

# make_email()
# make an e-mail hyperlink
# 
function make_email($email, $linktext=false) {
    return sprintf("<a href=\"mailto:%s\">%s</a>",
        $email,
        ($linktext ? $linktext : $email)
    );
}

# print_email()
# echo an e-mail hyperlink
# 
function print_email($email, $linktext=false) {
    echo make_email($email, $linktext);
}

# commonheader()
#
#
function commonHeader($title=false, $padding=true) {
	global $SIDEBAR_DATA;
?><html>
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
    <title>PHP-GTK<?php if ($title) { echo ':'.$title; } ?></title>
    <link rel="stylesheet" href="/style.css" />
    <link rel="stylesheet" href="/style-highlight.css" />
    <link rel="shortcut icon" href="/gifs/favicon.ico" />
</head>

<body bgcolor="#FFFFFF" text="#000000" link="#000099" alink="#0000FF" vlink="#000099">
<a name="TOP"></a>
<table border="0" cellspacing="0" cellpadding="0" height="48" width="100%">
    <tr bgcolor="#0099CC">
        <td align="left" rowspan="2">
            <?php print_link('/', make_image('php-gtk.gif', 'PHP-GTK', false, 'vspace="2" hspace="2"')); ?><br />
        </td>
        <td align="right" valign="top" nowrap>
            <font color="#FFFFFF">
                <b><?php echo strftime("%A, %B %d, %Y"); ?></b>&nbsp;<br />
            </font>
        </td>
    </tr>
    <tr bgcolor="#0099CC">
        <td align="right" valign="bottom" nowrap>
            <?php
            print_link('/download.php', 'download', false, 'class="menuBlack"');
            echo delim();
            print_link('/docs.php', 'documentation', false, 'class="menuBlack"');
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
            if (isset($_COOKIE['MAGIC_COOKIE'])) {
                echo delim();
                print_link('/admin-logout.php', 'logout', false, 'class="menuBlack"');
            }
            ?>&nbsp;<br />
            <?php spacer(2,2); ?><br />
        </td>
    </tr>
    <tr bgcolor="#000033"><td colspan="2"><?php spacer(1,1); ?><br /></td></tr>
    <tr bgcolor="#006699">
	    <form method="POST" action="/search.php">
            <td align="right" valign="top" colspan="2" nowrap>
                <font color="#FFFFFF">
                    <small>search for</small>
                    <input class="small" type="text" name="pattern" value="<?php echo htmlentities($prevsearch); ?>" size="30" />
                    <small>in the</small>
                    <select name="show" class="small">
                        <option value="manual">manual</option>
                        <option value="whole-site">whole site</option>
                        <option value="wiki">wiki</option>
                        <option value="php-gtk-general-list">general mailing list</option>
                        <option value="php-gtk-dev-list">development mailing list</option>
                        <option value="php-gtk-doc-list">documentation mailing list</option>
                    </select>
                    <?php echo make_submit('small_submit_white.gif', 'search', 'bottom'); ?>&nbsp;<br />
                </font>
            </td>
        </form>
    </tr>
    <tr bgcolor="#000033"><td colspan="2"><?php spacer(1,1) ;?><br /></td></tr>
</table>

<table border="0" cellpadding="0" cellspacing="0">
    <tr valign="top">
    <?php if (isset($SIDEBAR_DATA)): ?>
        <td width="200" bgcolor="#F0F0F0">
            <table width="100%" cellpadding="4" cellspacing="0">
                <tr valign="top">
                    <td class="sidebar">
                        <?php echo $SIDEBAR_DATA; ?>
                    </td>
                </tr>
            </table>
        </td>
        <td bgcolor="#CCCCCC" background="/gifs/checkerboard.gif"><?php spacer(1,1); ?><br /></td>
    <?php endif; ?>
        <td>
            <table width="100%" cellpadding="<?php if ($padding) { print("10"); } else { print("0"); } ?>" cellspacing="0">
                <tr>
                    <td valign="top">
<?php
}

# commonfooter()
#
#
function commonFooter($padding = true) {
    global $RIGHT_SIDEBAR_DATA;

    if ($padding) {
        print("<br />");
    }
?>
                    </td>
                </tr>
            </table>
        </td>
    <?php if (isset($RIGHT_SIDEBAR_DATA)): ?>
        <td bgcolor="#CCCCCC" background="/gifs/checkerboard.gif"><?php spacer(1,1);?><br /></td>
        <td width="170" bgcolor="#F0F0F0">
            <table width="100%" cellpadding="4" cellspacing="0">
                <tr valign="top">
                    <td class="sidebar">
                        <?php echo $RIGHT_SIDEBAR_DATA; ?>
                    </td>
                </tr>
            </table>
        </td>
    <?php endif; ?>
    </tr>
</table>

<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr bgcolor="#000033"><td><?php spacer(1,1);?><br /></td></tr>
    <tr bgcolor="#006699">
        <td align="right" valign="bottom">
            <?php
            //print_link('/source.php?url='.$_SERVER['SCRIPT_NAME'], 'show source', false, 'class="menuWhite"');
            //echo delim();
            print_link('/credits.php', 'credits', false, 'class="menuWhite"');
            ?>&nbsp;<br />
        </td>
    </tr>
    <tr bgcolor="#000033"><td><?php spacer(1,1); ?><br /></td></tr>
</table>

<table border="0" cellspacing="0" cellpadding="6" width="100%">
    <tr valign="top" bgcolor="#CCCCCC">
        <td>
            <small>
                <?php print_link('http://www.php.net/', make_image('php-logo.gif', 'PHP', 'left')); ?>
                <?php print_link('/copyright.php', 'Copyright &copy; 2001-' . date('Y') . ' The PHP Group'); ?><br />
                All rights reserved.<br />
            </small>
        </td>
        <td align="right">
            <small>
                Last updated: <?php echo strftime("%c %Z", getlastmod()); ?><br />
            </small>
            <br />
        </td>
    </tr>
</table>
</body>
</html>
<?php
}

# clean_note()
#
#
function clean_note($text) {
    $text = htmlentities($text);
    $allowed = array(
        'from' => array(
            '&lt;br&gt;', 
            '&lt;br /&gt;', 
            '&lt;br/&gt;', 
            '&lt;p&gt;', 
            '&lt;/p&gt;', 
            '&lt;b&gt;',
            '&lt;/b&gt;',
            '&lt;strong&gt;',
            '&lt;/strong&gt;',
            '&lt;i&gt;',
            '&lt;/i&gt;',
            '&lt;em&gt;',
            '&lt;/em&gt;'
        ),
        'to' => array(
            '<br />', 
            '<br />', 
            '<br />', 
            '<p>', 
            '</p>',
            '<b>',
            '</b>',
            '<strong>',
            '</strong>',
            '<i>',
            '</i>',
            '<em>',
            '</em>'
        )
    );
    foreach ($fixes as $f) {
        $text = str_ireplace($allow['from'], $allowed['to'], $text);
    }
	$text = '<tt>' . nl2br($text) . '</tt>';
	return $text;
}

# sect_to_file()
#
#
function sect_to_file($string) {
    $string = strtolower($string);
    $string = str_replace(' ', '-', $string);
    $string = str_replace('_', '-', $string);

    $func   = "function.$string.php";
    $chap   = "ref.$string.php";
    $feat   = "features.$string.php";
    $struct = "control-structures.$string.php";

    if (is_file($func)) {
        return $func;
    } elseif (is_file($chap)) {
        return $chap;
    } elseif (is_file($feat)) {
        return $feat;
    } elseif (is_file($struct)) {
        return $struct;
    } else {
        return "$string.php";
    }
}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim: expandtab sw=4 ts=4 fdm=marker softtabstop=4
 */
?>
