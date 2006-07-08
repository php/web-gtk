<?php

require_once 'shared-manual.inc';
require_once 'config.inc';
require_once 'email-validation.inc';
/*
Unleash this if we want the same layout as phpdoc
if (isset($SIDEBAR_DATA)) {
	unset($SIDEBAR_DATA);
}
*/
commonHeader('Add Manual Note');
?>
<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
<!--
function check_email() {
	if (document.msgform.email.value != '') {
		return window.confirm('Please confirm that the email address given is valid');
	}
	return true;
}
//-->
</SCRIPT>
<?php

$referrer = null;

if (isset($_POST['referer'])) {
	$referrer  = trim($_POST['referer']);
} else {
	$referrer = $_SERVER['HTTP_REFERER'];
}

if (!$referrer) {
	$referrer = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));
	header("Location: $referrer");
	exit;
}

/* Honour form cancellation */
if (isset($_POST['cancel'])) {
	header("Location: $referrer");
	exit;
}

/* hide everything from non-administrators while we sort it all out */
if (file_exists($okfile) || $user = get_user()) {

if (isset($_POST['add']) || isset($_POST['preview'])) {

	/* Throw out any attempt at redirection */
/*	if (substr($referrer, 0, 25) != 'http://gtk.php.net/manual' || strstr($referrer, '?')) {
		header("Location: $referrer");
		exit;
	}
*/
	/* set globals and initialize a bunch of vars */
	$email      = stripslashes(trim($_POST['email']));
	$content    = stripslashes(trim($_POST['note']));
	$usename    = stripslashes(trim($_POST['name']));
	$antispam   = $_POST['antispam'];
	$ip         = $_SERVER['REMOTE_ADDR'];
	$flag       = null;
	$spammer    = null;
	$subject    = null;
	$errcode    = null;
	$errmsg     = null;
	$display    = '';
	$urls       = 0;
	$blanklines = 0;

	function force_shuffle($item, &$array) {
		if (strlen($item) < 2) {
			return $item.'z';
		}
		$shuffled = str_shuffle($item);
		$array[] = $shuffled;
		if ($item == $shuffled) {
			force_shuffle($item, &$array);
		}
		$result = $array[sizeof($array)-1];
		return $result;
	}

	/* Figure out what the user wants us to display on the site and store it */
	$usename = htmlentities(strip_tags($usename));
	$email   = htmlentities(strip_tags($email));

	if ($antispam == 'usename' && $usename != '') {
		$burst = explode(' ', $usename);
		foreach($burst as $part) {
			$display .= ucfirst($part).' ';
		}
		$display = trim($display);
	} else {
		if ($email != '') {
			if ($antispam == 'random') {
				if (strstr($email, '@')) {
					$burst = explode('@', $email);
					if (strstr($burst[1], '.')) {
						$alter = substr($burst[1], 0, strpos($burst[1], '.'));
						$shuffled = force_shuffle($alter, &$result);
						$display = $burst[0].'@'.substr_replace($burst[1], $shuffled, 0, strlen($alter));
					}
				}
			}
			$display = str_replace('@', ' at ', $display ? $display : $email);
			$display = str_replace('.', ' dot ', $display);
			if ($antispam == 'nospam') {
				$display = str_replace('at ', 'at NOSPAM ', $display);
			}
		}
	}
}

/* ============================ PREVIEW ONLY ========================= */

if (isset($_POST['preview'])) {
	print "<br />\n<p>\nThis is what your entry will look like, roughly:\n</p>\n";
	print "<table border='0' cellpadding='0' cellspacing='0' width='100%' align = 'center'>\n";
	$temp = array('user' => $display, 'note' => htmlentities($content), 'xwhen' => time());
	makeEntry($temp, false, false);
	print "</table>\n";
	print "<br />\n";
	print "<a href = '#notes'>Edit the form</a>\n";
}

/* ========================= ADDING TO DATABASE ====================== */

if (isset($_POST['add'])) {
	/* If we have a blacklist running today, check whether the user's IP is in it */
	if (file_exists($blockfile)) {
		$blocked = file_get_contents($blockfile);
		$blacklisted = strstr($blocked, $ip);
		if (strlen($blacklisted) > 0) {
			$btime = substr($blacklisted, strlen($ip) + 1, 11);
			if ($btime > strtotime("1 hour ago")) {
				/* Pretty darn sure this is a repeat attack. Fail silently */
				$blocked = str_replace($ip, "$ip\n".time()." BANNED (GTK_666)", $blocked);
				file_put_contents($blockfile, $blocked);
				unset($usename);
				unset($email);
				unset($content);
				header("Location: $referrer");
				exit;
			}
			/* It's possible - if unlikely - DHCP is to blame. So just log and flag it */
			$flag = true;
			$blocked = str_replace($ip, "$ip\n".time()." DHCP? (GTK_666)", $blocked);
			file_put_contents($blockfile, $blocked);
		}
	}

	/* ANTI-SPAM MEASURES (keep updated!) */

	/* Very short content - errorcode GTK_111 */
	if (strlen($content) < 32) {
		$spammer = "GTK_111";
		$errmsg  = "Your note is too short. Trying to test the notes system? Save us the trouble of deleting your test, and don't. It works.";
	}

	/* Check data against the 'bad word' list - errorcode GTK_333 */
	foreach($badwords as $badword) {
		if ($spammer) break;
		if (!$spammer && $email) $spammer = stristr($email, $badword);
		if (!$spammer) $spammer = stristr($content, $badword);
	}

	/* Check whether the content is mostly URLs - errorcode GTK_222 */
	if (strlen($spammer) == 0) {
		$lines = explode("\n", $content);
		foreach($lines as $no => $line) {
			$line = rtrim($line);
			if (preg_match("'(http:\/\/|<a href)'is", $line))
				$urls++;
			if (strlen($line) < 5)
				$blanklines++;
		}
		if ($urls > (sizeof($lines) - $blanklines) / 2) {
			$spammer = "GTK_222";
		}
	}

	if (strlen($spammer) > 0) {
		if (!strstr($spammer, 'GTK_')) {
			$spammer = "GTK_333";
		}
		if ($flag) {
			/* We're 100% sure it's spam, the guy reached here once already. Fail silently */
			file_put_contents($stats, "$spammer:id not assigned, $ip banned\n", FILE_APPEND);
			$blocked = file_get_contents($blockfile);
			$blocked = str_replace($ip, "$ip\n".time()." BANNED ($spammer)", $blocked);
			file_put_contents($blockfile, $blocked);
			unset($usename);
			unset($email);
			unset($content);
			header("Location: $referrer");
			exit;
		}
		/* We're 96.7% sure it's spam. Log the IP and print a failure message just in case */
		file_put_contents($blockfile, "$ip\n".time()." ($spammer)\n\n", FILE_APPEND);
		if (!$errmsg) {
			$errmsg = "There was an error processing your submission.<br />\nThe development team have been informed.";
		}
		print stretchPage(22);
		print "<p>\n$errmsg\n</p>\n";
		print "<p><a href = '$referrer'>Back</a></p>";
		commonFooter();
		exit;
	}

	/* DEFENSE AGAINST THE REST */
	/* Check we aren't currently being flooded by someone else - errorcode GTK_666 */
	if (filemtime($queuefile) > $veryrecent) {
		$queuedb = sqlite_open($queuefile);
		$result = sqlite_query($queuedb, "SELECT id FROM notes WHERE date > $recent");
		$count = sqlite_num_rows($result);
		if ((int)$count > $likely) {
			$spammer = "GTK_666";
		}
		sqlite_close($queuedb);
	}

	/*
	* If we got this far all's probably well, so invalid/empty email addresses
	* are OK to go. We just tag them to ensure we don't try to mail anything
	* out to them at a later stage
	*/
	if (!preg_match($email_regex, $email) || strstr($email, 'lists.php')) {
		$email = 'GTK_000'.$email;
	}

	/* Check and secure contents */
	if (strlen($content) > 4096) {
		print stretchPage(22);
		print "<p>Your note is too long to fit on the manual pages! Please review it and try to make it less verbose.</p>";
		commonFooter();
		exit;
	}
	$content = htmlentities($content, ENT_COMPAT, 'UTF-8');

	/* Pick up id, insert note data into queue and mail out admin notification */
	if (!$lastid = file_get_contents($last_id)) {
		die("Could not obtain note ID");
	}

	$id = $lastid + 1;
	$url = explode('/', $referrer);
	$lang = $url[4];
	$page = $url[5];
	$date = time();

	$db_string = '("'.$id.'", "'.$page.'", "'.$lang.'", "'.$date.'", "'.$email.'", "'.$display.'", "'.$content.'")';
	$db_string = sqlite_escape_string($db_string);
	$queuedb = sqlite_open($queuefile);
	$result = sqlite_exec($queuedb, "INSERT INTO notes VALUES $db_string");
	sqlite_close($queuedb);
	if (!file_put_contents($last_id, $id)) {
		die("New note ID not saved");
	}

	$printmsg = "<p>Thank you for contributing! Your note has been queued for processing";
	if (!strstr($email, 'GTK_000')) {
		$printmsg .= ", and you will be notified by email when it goes live";
	}
	$printmsg .= ".</p>";
	print stretchPage(22);
	print $printmsg;
	print $db_string;
	print "<p><a href = '$referrer'>Back</a></p>";
	commonFooter();

	if (!$result) {
		/* tell admin there's a problem and create an emergency file to retain the data */
		file_put_contents($stats, "GTK_ERROR:$errmsg Backup is in $id.txt\n", FILE_APPEND);
		$bytes = file_put_contents(DB_DIR."/$id.txt", $id."\n".$page."\n".$lang."\n".$date."\n".$email."\n".$display."\n".$content."\n\n".$ip);
		$msg = "page: $page\n\n$content\n\n$display - ".date('d-M-Y H:i', $date);
		mail($mailto, "queue system failed: note $id was backed up ($bytes bytes)", $msg, "From: $mailfrom");
		commonFooter();
		exit;
	}

	/* Mail success notification to the list */
	$msg = "page: <a href='$referrer'>$page</a>\n\n$content\n\n$display - ".date('d-M-Y H:i', $date);
	mail($mailto, "note $id has been queued", $msg, "From: $mailfrom");
	/*
	 * We can't check for the current id without holding up the page for a whole
	 * unacceptable minute - so we keep the current entry in the queue and
	 * work with the previous successful queue entry from this point instead
	 */
	$handle = @fsockopen('216.92.131.4', 119, $errno, $errstr, 10);
	if ($handle) {
		$helo = fgets($handle, 1024);
		if (substr($helo, 0, 3) == '200') {
			stream_set_timeout($handle, 2);
			fputs($handle, "GROUP php.gtk.webmaster\r\n");
			$groupinfo = fgets($handle, 1024);
			preg_match("'\d{4,6}'is", $groupinfo, $matches, 0, 10);
			$last_mail = $matches[0];
			fputs($handle, "HEAD $last_mail\r\n");
			$headerinfo = fgets($handle, 2048);
			while ($line != ".\r\n") {
				$line = fgets($handle, 2048);
				if (strstr($line, "Subject:")) $subject = $line;
				$status = socket_get_status($handle);
				if ($status['timed_out']) {
					break;
				}
			}
		}
		fclose($handle);
	}

	if ($subject) {
		$flag = null;
		if (!strstr($subject, "note ".$lastid)) {
			/* File an error but hold the data in the queue. errorcode GTK_444 */
			file_put_contents($stats, "GTK_444: $lastid held in queue\n", FILE_APPEND);
			if (strstr($subject, "note ".$id)) { /* NNTP might have been too fast for us! */
				$lastid = $id;
				$lastemail = $email;
				$lastpage = $page;
				$flag = true;
			}
		} else {
			/* If we're working with $lastid, we need to get the data out of the queue db first */
			$queuedb = sqlite_open($queuefile);
			$query = sqlite_unbuffered_query($db, "SELECT * FROM notes WHERE id = $lastid", SQLITE_ASSOC, &$errcode);
			if (!$query || $errcode) {
				sqlite_close($queuedb);
				file_put_contents($stats, "$errcode:$lastid (failed SQL query)\n", FILE_APPEND);
			} else {
				$last = sqlite_fetch_array($query, SQLITE_ASSOC);
				$lastpage = $last['page'];
				$lastemail = $last['email'];
				$db_string = '("'.$lastid.'", "'.$lastpage.'", "'.$last['lang'].'", "'.$last['date'].'", "'.$lastemail.'", "'.$last['display'].'", "'.$last['note'].'")';
				sqlite_close($queuedb);
				$flag = true;
			}
		}

		if ($flag) {
			$notesdb = sqlite_open($notesfile);
			$result = sqlite_exec($notesdb, "INSERT INTO notes VALUES $db_string");
			sqlite_close($notesdb);

			if (!$result) {
				/* Not being able to write to the notes db is pretty worrying. errorcode GTK_888 */
				$errcode = "GTK_888";
				file_put_contents($stats, "$errcode:$lastid held in queue (write failed)\n", FILE_APPEND);
			} else {
				$queuedb = sqlite_open($queuefile);
				$result = sqlite_exec($queuedb, "DELETE FROM notes WHERE id = $lastid");
				sqlite_close($queuedb);

				if (!$result) {
					/* Not being able to write to the queue isn't great either. errorcode GTK_777 */
					$errcode = "GTK_777";
					file_put_contents($stats, "$errcode:$lastid not deleted from queue\n", FILE_APPEND);
				}

				/* Mail the user to confirm good stuff */
				if ($errcode != 'GTK_888' && !strstr($last['email'], "GTK_000")) {
					$msg = "Hi\n\nThis is to confirm that your PHP-GTK manual note reached the top of the queue and will be available for viewing shortly at <a href='$referrer'>$referrer</a>.\n\nThank you again for your contribution!\n\nRegards,\nThe PHP-GTK Documentation Group";
					mail($lastemail, "PHP-GTK Manual Note $lastid added", $msg, "From: $mailfrom");
				}

				if (!$errcode) {
					file_put_contents($stats, "GTK_SUCCESS:$lastid\n", FILE_APPEND);
				}
			}
		}
	} else { /* no return from NNTP */
		file_put_contents($stats, "GTK_444: $lastid held in queue (NNTP response failed)\n", FILE_APPEND);
	}

	if ($spammer && $errcode) { /* spammer can only be GTK_666 at this stage (flood) */
		/* We're being attacked and they've managed to screw up at least one db */
		/* use GTK_999 but preserve the original combo so we know where to look */
		$msg = "page: <a href='$referrer'>$page</a>\n\n$content\n\n$display - ".date('d-M-Y H:i', $date);
		mail($mailto, "GTK_999 notification", $msg, "From: $mailfrom");
		exit;
	}

	if ($spammer) {
		file_put_contents($blockfile, "$ip\n".time()." ($spammer: note $id)\n\n", FILE_APPEND);
	}

	exit;

} else {
/* ======================= FORM NOT FILLED IN YET ==================== */
?>
<br />
<p>
You can contribute to the PHP-GTK manual from the comfort of your own browser!
Just add your comment in the big field below, and your name and email address
in the little ones.
</p>

<p>
Thanks to all those hard-working spammers out there, you now have several options
when it comes to displaying your email address. By default we will simply replace
the @ signs and dots in it (e.g. 'user@example.com' becomes 'user at example dot
com'), but we can also add various anti-spam measures at your request - including
not displaying it at all. We can only inform you of the progress of your note
throughout its lifetime if you use your real email address when submitting it.
</p>

<p>
We will only display your name if you choose that display option.
</p>

<p>
Your IP address will be logged when your note is submitted and used
during our screening process, but will not be made public at any stage.
</p>

<p>
Note that <b>HTML tags</b> are not allowed in the notes, but formatting
is preserved. URLs signalled by 'http://', 'https://' or 'ftp://' will be
turned into clickable links, and PHP code blocks enclosed in the PHP tags
&lt;?php and ?&gt; will be source highlighted automatically - so always
enclose PHP snippets in those tags. (Double-check that your note appears
as you intend during the preview. That's why the preview button is there!)
</p>

<p>
Please read the following points carefully before submitting your
comment. If your post falls into any of the categories mentioned
there, it will be rejected by one of the editors.
</p>

<ul>
<li>If you are trying to report a bug, or request a new feature,
you're in the wrong place. Bugs (and requests!) should be reported at
<a href="http://bugs.php.net">bugs.php.net</a> as 'PHP-GTK related'.</li>
<li>If you are just commenting on the fact that something is not documented,
save your energy. This is where <b>you</b> add to the documentation, not
where you ask <b>us</b> to add the documentation.</li>
<li>This is also not the correct place to ask questions (even if you see
others have done that before). Support is available through either the
general mailing list or IRC; see our
<a href="http://gtk.php.net/resources.php">resources page</a> for details.</li>
</ul>

<p>
<b>If you post a note in any of the categories above, it will be removed.</b>
However, please feel free to come back and add a note here when your
question is answered or you find a solution to your problem!
</p>

<p>
Please note that there is a chance of the information in the user notes
being incorporated into the manual at a later date. This means that any
note posted here becomes the property of the PHP-GTK Documentation Group.
</p>

<a name = 'notes' />
<form name = 'msgform' action = "<?php echo $_SERVER['PHP_SELF'];?>" method = 'POST'>
<table border='0' cellpadding='3' bgcolor='#e0e0e0' align='center' width=<?php echo isset($SIDEBAR_DATA) ? '90%' : '80%'; ?>>
 <tr>
  <th colspan='2' align='left'>Please choose a display option for your personal data:</th>
 </tr>
 <tr>
  <td colspan='2'>
   <input type="radio" name="antispam" value="standard" <?php if (!isset($_POST['antispam']) || (isset($_POST['antispam']) && $antispam == 'standard')) echo 'checked' ?>> Obfuscate my email address before displaying it, e.g. 'user at example dot com' (default)<br />
  </td>
 </tr>
 <tr>
  <td colspan='2'>
   <input type="radio" name="antispam" value="nospam" <?php if (isset($_POST['antispam']) && $antispam == 'nospam') echo 'checked' ?>> Add NOSPAM to my email address before displaying it, e.g. 'user at NOSPAM example dot com'<br />
  </td>
 </tr>
 <tr>
  <td colspan='2'>
   <input type="radio" name="antispam" value="random" <?php if (isset($_POST['antispam']) && $antispam == 'random') echo 'checked' ?>> Randomize part of my email address before displaying it, e.g. 'user at mepelxa dot com'<br />
  </td>
 </tr>
 <tr>
  <td colspan='2'>
  <input type="radio" name="antispam" value="usename" <?php if (isset($_POST['antispam']) && $antispam == 'usename') echo 'checked' ?>> Display my name instead of my email address, e.g. 'User L. Schmidt'<br />
  </td>
 </tr>
 <tr>
  <th align='right'>Your name:</th>
  <td><input type='text' name='name' size='40' maxlength='40' value="<?php if (isset($_POST['name'])) echo $usename; ?>"></td>
 </tr>
 <tr>
  <th align='right'>Your email address:</th>
  <td><input type='text' name='email' size='40' maxlength='40' value="<?php if (isset($_POST['email'])) echo $email; ?>"></td>
 </tr>
 <tr>
  <th align='right' valign='top'>Your note:</th>
  <td>
   <textarea name='note' rows='15' cols='65' wrap='soft'><?php if (isset($_POST['note'])) echo $content; ?></textarea>
   <br />
  </td>
 </tr>
 <tr>
  <td>&nbsp;</td>
  <td>
   <input type = "hidden" name = "referer" value = "<?php echo $referrer; ?>">
   <input type = 'submit' name = 'cancel' value = 'Cancel'>
   <input type = 'submit' name = 'preview' value = 'Preview'>
   <input type = 'submit' name = 'add' value = 'Add note' onClick = 'return check_email();'>
  </td>
 </tr>
</table>
</form>

<?php
	}
} else {
	/* hide everything if the notes mechanism is down */
	print stretchPage(22);
	print "<p>The PHP-GTK manual notes system is off-line at present. Please try again later!</p>";
	print "<p><a href = '$referrer'>Back</a></p>";
	print "</div>";
}

commonFooter();
?>
