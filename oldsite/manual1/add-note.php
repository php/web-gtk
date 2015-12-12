<?php

require_once 'shared-manual1.inc';

/*
# Notes only available at main mirror site for now
if ($_SERVER["HTTP_HOST"]!='gtk.php.net') {
	header('Location: http://gtk.php.net' . $_SERVER['REQUEST_URI'] );
	exit;
}
*/

$mailto = 'gtk-webmaster@lists.php.net';

commonHeader('PHP-GTK 1 Manual Notes');

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
if (!strstr($MYSITE,"gtk.php.net")) {
	header("Location: http://gtk.php.net/manual1/add-note.php?sect=".urlencode($sect)."&lang=".urlencode($lang)."&redirect=".urlencode($redirect));
	exit;
}
*/

if (isset($note) && isset($action) && strtolower($action) != "preview" && file_exists($notesdb)) {

		$now = time();
		$note = htmlentities($note, ENT_COMPAT, 'UTF-8');
		$db_string = '(null, "'.$sect.'", "'.$now.'", "'.$user_email.'", "'.$note.'")';

		$db = sqlite_open($notesdb);
		$query = @sqlite_query($db, "INSERT INTO php_gtk_manual VALUES $db_string");
		sqlite_close($db);

	if (mysql_query($query)) {
		echo "<p>Your submission was successful -- thanks for contributing!</p>";
		$new_id = sqlite_last_insert_rowid($db);
		$msg = stripslashes($note);
		$msg .= "\n\n $redirect \n";
		# make sure we have a return address.
		if (!$user_email) {
			$user_email = "php-gtk@lists.php.net";
		}
		mail($mailto, "note $new_id added to $sect", $msg, "From: $user_email");
	} else {
		# mail it.
		mail($mailto, "failed manual v1 note query", $query);
		echo "<p>There was an error processing your submission. " .
			"It has been automatically e-mailed to the developers.</p>";
	}

	echo '<p>You can <a href="' . $redirect. '">go back</a> from whence you came,' .
		'or you can <a href="http://gtk.php.net/manual1/">go to the manual home page</a>.</p>';

} else {

		if (isset($note) && strtolower($action) == "preview") {

		echo '<p>This is what your entry will look like, roughly:</p>';
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

<p>
You can contribute to the PHP-GTK 1 manual from the comfort of your browser!
Just add your comment in the big field below, and, optionally, your email
address in the little one (usual anti-spam practices are OK, e.g. 
johnNOSPAM@doe.NO_SPAM.com).
</p>

<p>
Note that most HTML tags are not allowed in the posts. We tried 
allowing them in the past, but people invariably made a mess of
things making the manual hard to read for everybody. You can include
&lt;p&gt;, &lt;/p&gt;, and &lt;br&gt; tags.
</p>

<p>
Carefully read the following note. If your post falls into one of the
categories mentioned there, it will be rejected by one of the editors.
</p>

<p>
<b>Note:</b> If you are trying to <a href="http://bugs.php.net/">report a
bug</a>, or <a href="http://bugs.php.net/">request a new feature or language
change</a>, you're in the wrong place.  If you are just commenting on the fact
that something is not documented, save your breath. This is where <b>you</b>
add to the documentation, not where you ask <b>us</b> to add the
documentation. This is also not the correct place to <a
href="http://gtk.php.net/resources.php">ask questions</a> (even if you see others have done that
before, we are editing the notes slowly but surely).  If you post a note in
any of the categories above, it will edited and/or removed.
</p>

<p>
Just to make the point once more. The notes are being edited and support
questions/bug reports/feature request/comments on lack of documentation, are
being <b>deleted</b> from them (and you may get a <b>rejection</b> email), so
if you post a question/bug/feature/complaint, it will be removed (but once you
get an answer/bug solution/function documentation, feel free to come back
and add it here!).
</p>

<p>
That said, you can change your mind and <a href="http://gtk.php.net/resources.php">click here to 
go to the support pages</a> or <a href="http://bugs.php.net/">click here 
to submit a bug report or request a feature</a>.
</p>
<?php
	}
	if (!$user_email) {
		$user_email = "user@example.com";
	}
	if (!isset($sect)) {
		echo "<p><b>To add a note, you must click on the 'Add Note' button " .
			"on the bottom of a manual page so we know where to add the note!</b></p>";
	} else {
?>

<form method="POST" action="/manual1/add-note.php">
<input type="hidden" name="sect" value="<?echo $sect;?>">
<input type="hidden" name="redirect" value="<?echo $redirect;?>">
<input type="hidden" name="lang" value="<?echo $lang;?>">
<table border="0" cellpadding="5" cellspacing="0" bgcolor="#e0e0e0">
<tr valign="top">
<td align="right">Your email address:<br /></td>
<td><input type="text" name="user_email" size="40" maxlength="40" value="<?echo htmlspecialchars(stripslashes($user_email))?>"></td>
</tr>
<tr valign="top">
<td align="right">Your note:<br /></td>
<td><textarea name="note" rows="6" cols="40" wrap="virtual"><?echo htmlspecialchars(stripslashes($note))?></textarea><br>
</td>
</tr>
<tr>
 <td colspan="2" align="right">
  <input type="submit" name="action" value="Preview">
  <input type="submit" name="action" value="Add Note">
 </td>
</tr>
</table>
</form>
<?php
	}
}

commonFooter();
?>
