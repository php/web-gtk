<?php

require_once 'config.inc';
require_once 'cvs-auth.inc';
require_once 'shared-manual.inc';

if (isset($_POST['cancel'])) {
	header("Location: {$_SERVER['REQUEST_URI']}");
	exit;
}

makeAdminOpts();

if ($user = get_user()) {
	commonHeader("Manual Notes Administration");

	$order = isset($_POST['order']) ? $_POST['order'] : null;
	if (isset($order)) {
		if (!isset($_COOKIE['order']) || (isset($_COOKIE['order']) && $order != $_COOKIE['order'])) {
			setcookie('order', $order, time()+(3600*24), '/');
		}
	} else {
		$order = $_COOKIE['order'];
	}

	echo "<h1>Manual Notes Administration</h1>\n\n";
	$admin = true;
	$id = null;

	if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
		$id = $_GET['delete'];
	}

	if (isset($_GET['reject']) && is_numeric($_GET['reject'])) {
		$id = $_GET['reject'];
		$reject_text  = "If you are receiving this email, it is because a note you posted for the\n";
		$reject_text .= "on-line PHP-GTK manual has been rejected by one of the editors.\n\n";
		$reject_text .= "The user contributed notes are not an appropriate place to ask questions,\n";
		$reject_text .= "ask questions, report bugs or suggest new features.\n\n";
		$reject_text .= "Bug reports and feature requests should be entered as 'PHP-GTK related'\n";
		$reject_text .= "at <a href = 'http://bugs.php.net'>bugs.php.net</a>.\n";
		$reject_text .= "Support and ways to find answers to your questions can be found at\n";
		$reject_text .= "<a href='http://gtk.php.net/resources.php'>gtk.php.net/resources.php</a>.\n\n";
		$reject_text .= "Your note has been removed from the on-line manual.\n\n";
	}

	if ($id) {
		$db = sqlite_open($notesfile);
		$query = sqlite_query($db, "SELECT * FROM notes WHERE id = '$id'");
		$row = sqlite_fetch_array($query, SQLITE_ASSOC);
		if (sqlite_exec($db, "DELETE FROM notes WHERE id = '$id'")) {
			if (isset($_GET['reject'])) {
				if (!substr($row['email'], 0, 3) == 'GTK_') {
					/* email user */
					//mail($row['email'], "note {$row['id']} rejected: {$row['page']}", $reject_text."----- Copy of your note below -----\n\n".stripslashes($row['comment']), "From: $user@php.net");
				}
				$actioned = 'rejected';
			} else {
				$actioned = 'deleted';
			}
			//mail($mailto, "note $id $actioned: {$row['page']}", "Content of note:\n\n".stripslashes($row['comment']), "From: $user@php.net");
			print "<p><b>Note $id deleted successfully</b></p>";
		} else {
			print "<p><b>Unable to delete note $id</b></p>";
		}
		sqlite_close($db);
	}

	if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
		$db = sqlite_open($notesfile);
		$query = sqlite_query($db, "SELECT * FROM notes WHERE id = ".$_GET['edit']);
		$row = sqlite_fetch_array($query, SQLITE_ASSOC);
		$email = stripslashes($row['email']);
		$comment = stripslashes($row['comment']);
		if (substr($email, 0, 3) == 'GTK_') {
			$email = null;
		}
		$get = isset($_GET['let']) ? "?let={$_GET['let']}" : null;
		if (!$get) {
			$get = isset($_GET['y']) ? "?y={$_GET['y']}" : null;
		}
		echo '<form method="POST" action="'.$_SERVER['PHP_SELF'].$get.'">';
		echo '<table border="0" cellpadding="5" width="80%" bgcolor="#e0e0e0">';
		echo '<tr><td align="right">E-mail:<br /></td>' .
			'<td><input type="text" size="40" name="email" value="'.$email.'" />&nbsp;&nbsp;ID: '.$_GET['edit'].'<br /></td></tr>';
		echo '<input type="hidden" name="id" value='.$_GET['edit'].' />';
		echo '<tr valign="top"><td align="right">Note:<br /></td>' .
				'<td><textarea name="note" rows="15" cols="70">'.$comment.'</textarea><br /></td></tr>';
		echo '<tr bgcolor="#cccccc"><td colspan="2"></td></tr>';
		echo '<tr><td colspan="2" align="right"><input type="submit" name="modify" value="Save changes">';
		echo '&nbsp;&nbsp;<input type="submit" name="cancel" value="Cancel" /></td></tr>';
		echo "</table>\n</form>\n";
		sqlite_close($db);
		commonFooter();
		exit;
	}

	if (isset($_POST['modify'])) {
		$db = sqlite_open($notesfile);
		$query = sqlite_query($db, "SELECT * FROM notes WHERE id = ".$_POST['id']);
		$row = sqlite_fetch_array($query, SQLITE_ASSOC);
		$add_url = "\n\nhttp://gtk.php.net/manual/{$row['lang']}/{$row['page']}\n";
		$note = htmlentities($_POST['note'], ENT_COMPAT, 'UTF-8');
		$note = sqlite_escape_string($note);
		$note = stripslashes($note); // get rid of double slashes
		$query = "UPDATE notes SET";
		if (!empty($_POST['email'])) $query .= " email='{$_POST['email']}',";
		$query .= " comment='$note' WHERE id='{$row['id']}'";
		if (sqlite_exec($db, $query)) {
			echo "<p><b>Record {$row['id']} modified successfully</b></p>";
			//mail($mailto, "note {$row['id']} modified: {$row['page']}", $note.$add_url, "From: $user@php.net");
		} else {
			echo "<p><b>Record {$row['id']} not modified (query failed)</b></p>";
		}
		sqlite_close($db);
	}

} else {
	/* hide everything while we sort it all out */
	if (file_exists($okfile)) {
		commonHeader("Browse Manual Notes");

		$order = isset($_POST['order']) ? $_POST['order'] : null;
		if (isset($order)) {
			if (!isset($_COOKIE['order']) || (isset($_COOKIE['order']) && $order != $_COOKIE['order'])) {
				setcookie('order', $order, time()+(3600*24), '/');
			}
		} else {
			$order = $_COOKIE['order'];
		}
	} else {
		commonHeader("Browse Manual Notes");
		echo '<h1>Browse Manual Notes</h1>';
		$admin = false;
		print stretchPage(22);
		print "<p>The PHP-GTK manual notes system is off-line at present. Please try again later!</p>";
		print "<p><a href = '{$_SERVER['HTTP_REFERER']}'>Back</a></p>";
		print "</div>";
		commonFooter();
		exit;
	}
}

ob_start();
include('browse.php');

commonFooter();

?>
