<?php

require_once('cvs-auth.inc');
require_once('email-validation.inc');

$referer = isset($_POST['referer']) ? $_POST['referer'] : null;

if ($user = get_user()) {

	if (!$referer) {
		$referer = '../admin-login.php';
	}

	/* set up a test db and a cookie to notify the rest of the site */
	if (array_key_exists('test', $_GET) && in_array($user, $docteam)) {

		print "<form method = 'POST' action = '{$_SERVER['PHP_SELF']}'>";
		print "<p>Please enter a valid email address where you can accept test messages:</p>";
		print "<input type = 'text' name = 'adminmail' size = '40' maxlength = '40' />";
		print "<input type = 'hidden' name = 'referer' value = '$referer' />";
		print "<input type = 'submit' value = 'Submit' />";
		print "</form>";
		exit;
	}

	if (isset($_POST['adminmail']) && in_array($user, $docteam)) {

		/* validate it */
		if (!preg_match($email_regex, $_POST['adminmail']) || strstr($_POST['adminmail'], 'lists.php')) {
			header("Location: $referer");
			exit;
		}

		if (file_exists($notesfile) && file_exists($queuefile) && file_exists($last_id)) {
			if (!file_exists(DB_DIR."/$user.notes.sqlite")) {
				if (!copy($notesfile, DB_DIR."/$user.notes.sqlite") ||
					!copy($queuefile, DB_DIR."/$user.queue.sqlite") ||
					!copy($last_id, DB_DIR."/$user.lastid.txt")) {

					if (file_exists(DB_DIR."/$user.notes.sqlite")) unlink(DB_DIR."/$user.notes.sqlite");
					if (file_exists(DB_DIR."/$user.queue.sqlite")) unlink(DB_DIR."/$user.queue.sqlite");
					if (file_exists(DB_DIR."/$user.lastid.txt")) unlink(DB_DIR."/$user.lastid.txt");

					print "<p>Unable to create a test environment at this time. Complain to Steph!</p>";
					print "<a href = '$referer'>Back</a>";
					exit;
				}
			}
			$adminmail = trim($_POST['adminmail']);
			setcookie($user, $adminmail, time()+(3600*6), '/');
		}

	} elseif (array_key_exists('m', $_GET)) {

		/* switch outgoing mail on/off */
		if (in_array($user, $systems)) {
			if (file_exists($mailfile)) {
				unlink($mailfile);
			} else {
				file_put_contents($mailfile, 'OK');
			}
		}

	} else {

		/* switch public viewing of manual notes on/off */
		if (in_array($user, $systems)) {
			if (file_exists($okfile)) {
				unlink($okfile);
			} else {
				file_put_contents($okfile, 'OK');
			}
		}
	}
}

if (!$referer) {
	$referer = '/';
}

header("Location: $referer");

?>
