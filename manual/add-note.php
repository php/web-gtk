<?

require_once 'shared-manual.inc';


/*
# Notes only available at main mirror site for now
if ($HTTP_SERVER_VARS["HTTP_HOST"]!='gtk.php.net') {
	Header('Location: http://gtk.php.net' . $HTTP_SERVER_VARS['REQUEST_URI'] );
	exit;
}
*/


$mailto = 'gtk-webmaster@lists.php.net';

commonHeader('Manual Notes');

/* clean off leading and trailing whitespace */
$user = trim($user_email);
$note = trim($note);

/* don't pass through example username */
if ($user_email == 'user@example.com') {
    $user_email = '';
}

if ($note == '') {
    unset ($note);
}


# turn the POST data into GET data so we can do the redirect
/*
if(!strstr($MYSITE,"gtk.php.net")) {
    Header("Location: http://gtk.php.net/manual/add-note.php?sect=".urlencode($sect)."&lang=".urlencode($lang)."&redirect=".urlencode($redirect));
    exit;
}
*/

if (isset($note) && isset($action) && strtolower($action) != "preview") {
	$now = date("Y-m-d H:i:s");
	$query = "INSERT INTO note (user, note, sect, ts, lang) VALUES ";
        # no need to call htmlspecialchars() -- we handle it on output
        $query .= "('$user_email','$note','$sect','$now','$lang')";
	if (mysql_query($query)) {
		echo "<P>Your submission was successful -- thanks for contributing!</P>";
		$new_id = mysql_insert_id();	
		$msg = stripslashes($note);
		$msg .= "\n\n $redirect \n";
                # make sure we have a return address.
                if (!$user_email) {
			$user_email = "php-gtk@lists.php.net";
		}
		mail("gtk-webmaster@lists.php.net", "note $new_id added to $sect", $msg, "From: $user_email");
	} else {
		# mail it.
		mail($mailto, "failed manual note query", $query);
		echo "<P>There was an error processing your submission. " .
			"It has been automatically e-mailed to the developers.</P>";
	}

	echo '<P>You can <A href="' . $redirect. '">go back</A> from whence you came,' .
		'or you can <A href="http://gtk.php.net/manual/">go to the front of the manual</A>.</P>';

} else {

        if (isset($note) && strtolower($action) == "preview") {

		echo '<P>This is what your entry will look like, roughly:</P>';
                echo '<table border="0" cellpadding="0" cellspacing="0" width="100%">';
		$temp = array(
			'user' => stripslashes($user_email),
			'note' => stripslashes($note),
			'xwhen' => time()
		);
                makeEntry($temp, false, false);
                echo "</table>";

        } else {

?>

<P>
You can contribute to the PHP-GTK manual from the comfort of your browser!
Just add your comment in the big field below, and, optionally, your email
address in the little one (usual anti-spam practices are OK, e.g. 
johnNOSPAM@doe.NO_SPAM.com).
</P>

<P>
Note that most HTML tags are not allowed in the posts. We tried 
allowing them in the past, but people invariably made a mess of
things making the manual hard to read for everybody. You can include
&lt;p&gt;, &lt;/p&gt;, and &lt;br&gt; tags.
</P>

<P>
Carefully read the following note. If your post falls into one of the
categories mentioned there, it will be rejected by one of the editors.
</P>

<P>
<B>Note:</B> If you are trying to <A href="http://gtk.php.net/bugs">report a
bug</A>, or <a href="http://gtk.php.net/bugs">request a new feature or language
change</a>, you're in the wrong place.  If you are just commenting on the fact
that something is not documented, save your breath. This is where <B>you</B>
add to the documentation, not where you ask <B>us</B> to add the
documentation. This is also not the correct place to <A
href="http://www.php.net/support.php">ask questions</A> (even if you see others have done that
before, we are editing the notes slowly but surely).  If you post a note in
any of the categories above, it will edited and/or removed.
</P>

<P>
Just to make the point once more. The notes are being edited and support
questions/bug reports/feature request/comments on lack of documentation, are
being <b>deleted</b> from them (and you may get a <b>rejection</b> email), so
if you post a question/bug/feature/complain, it will be removed (but once you
get an answer/bug solution/function documentation, feel free to come back
and add it here!).
</P>

<P>
That said, you can change your mind and <a href="http://www.php.net/support.php">click here to 
go to the support pages</a> or <a href="http://gtk.php.net/bugs">click here 
to submit a bug report or request a feature</a>.
</P>
<?      
	}
	if (!$user_email) {
		$user_email = "user@example.com";
	}
        if (!isset($sect)) {
		echo "<P><b>To add a note, you must click on the 'Add Note' button " .
			"on the bottom of a manual page so we know where to add the note!</b></P>";
	} else {
?>

<form method="POST" action="/manual/add-note.php">
<input type="hidden" name="sect" value="<?echo $sect;?>">
<input type="hidden" name="redirect" value="<?echo $redirect;?>">
<input type="hidden" name="lang" value="<?echo $lang;?>">
<table border="0" cellpadding="5" cellspacing="0" bgcolor="#e0e0e0">
<TR VALIGN="top">
<TD ALIGN="right">Your email address:<BR></TD>
<td><input type="text" name="user_email" size="40" maxlength="40" value="<?echo htmlspecialchars(stripslashes($user_email))?>"></td>
</TR>
<TR VALIGN="top">
<TD ALIGN="right">Your note:<BR></TD>
<td><textarea name="note" rows="6" cols="40" wrap="virtual"><?echo htmlspecialchars(stripslashes($note))?></textarea><br>
</TD>
</TR>
<TR>
 <td colspan="2" align="right">
  <input type="submit" name="action" value="Preview">
  <input type="submit" name="action" value="Add Note">
 </td>
</tr>
</TABLE>
</FORM>
<?
	}
}

commonFooter();

