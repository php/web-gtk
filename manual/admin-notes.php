<?

require_once 'cvs-auth.inc';
require_once 'email-validation.inc';
require_once 'shared-manual.inc';


$mailto = 'gtk-webmaster@php.net';
$num_entries_per_page = 50;

if (isset($MAGIC_COOKIE)) {
	list($cookie_user, $cookie_pass) = explode(":", base64_decode($MAGIC_COOKIE));
}
if($save && $user && $pass) {
	SetCookie("MAGIC_COOKIE",base64_encode("$user:$pass"),time()+3600*24*12,'/');
}

/*
if(!strstr($MYSITE,"www.php.net")) {
	Header("Location: http://www.php.net/manual/admin-notes.php");
	exit;
}
*/

commonHeader("Manual Errata Admin");

echo "<P>If you just want to browse the errata, you're better off <A href=\"http://gtk.php.net/manual/browse-errata.php\">here</A>.\n";

mysql_pconnect("localhost","nobody","");
mysql_select_db("gtk");

if ($action != '') {
	if (!verify_password($user,$pass) && !verify_password($cookie_user, $cookie_pass) ) {
		echo "<P><B>Authorization failed.</P>";
		commonFooter();
		exit;
	}

	list ($action, $id) = explode(' ', $action);
	$u = ($user) ? $user:$cookie_user;

	switch($action) {
	case 'delete':
		$query = 'SELECT *,UNIX_TIMESTAMP(ts) AS xwhen FROM note WHERE id='.$id;
		if ($result = mysql_query($query)) {
			$row = mysql_fetch_array($result);
			mail($mailto, "note ".$row['id']." deleted from ".$row['sect']." by $u",stripslashes($row['note']),"From: ".$u."@php.net");
			$query = 'DELETE FROM note WHERE id=' . $id;
			if (mysql_query($query)) {
				echo '<P><B>Note deleted.</B></P>';
                                if ($popup) {
					echo '<script language="javascript">window.close();</script>';
				}
			}
		}
		break;

	case 'reject':
		$reject_text  = "If you are receiving this email is because your note posted\n";
		$reject_text .= "to the on-line PHP-GTK manual has been removed by one of the editors.\n\n";
		$reject_text .= "Read the following paragraphs carefully, because they contain\n";
		$reject_text .= "pointers to resources better suited for requesting support or\n";
		$reject_text .= "reporting bugs, none of which are to be included in manual notes\n";
		$reject_text .= "because there are mechanisms and groups in place to deal with\n";
		$reject_text .= "those issues.\n\n";
		$reject_text .= "The user contributed notes are not an appropriate place to\n";
		$reject_text .= "ask questions, report bugs or suggest new features; please\n";
		$reject_text .= "use the resources listed in <http://gtk.php.net/support.php>\n";
		$reject_text .= "for those purposes. This was clearly stated in the page\n";
		$reject_text .= "you used to submit your note, please carefully re-read\n";
		$reject_text .= "those instructions before submitting future contributions.\n\n";
		$reject_text .= "Bug Submissions should be entered at <http://gtk.php.net/bugs/>\n";
		$reject_text .= "Feature Requests should also be entered at <http://gtk.php.net/bugs/>\n";
		$reject_text .= "Support and ways to find answers to your guestions can be found\n";
		$reject_text .= "at <http://gtk.php.net/support.php>\n\n";
		$reject_text .= "Your note has been removed from the on-line manual.\n\n";
		$query = 'SELECT *,UNIX_TIMESTAMP(ts) AS xwhen FROM note WHERE id='.$id;
		if ($result = mysql_query($query)) {
			$row = mysql_fetch_array($result);
			// email the submitter if the address looks reasonable
			// uses functions in include/email-validation.inc
			$submitter = clean_AntiSPAM($row['user']);
			echo "<P>Note ".$row['id']." by: ".$row['user']." ($submitter) ";
			if (is_emailable_address($submitter)) {
				mail($submitter,"note ".$row['id']." rejected and deleted from ".$row['sect']." by notes editor $u",$reject_text."----- Copy of your note below -----\n\n".stripslashes($row['note']),"From: ".$u."@php.net");
			}
			// email to the list
			mail($mailto, "note ".$row['id']." rejected and deleted from ".$row['sect']." by $u",stripslashes($row['note']),"From: ".$u."@php.net");
			$query = 'DELETE FROM note WHERE id=' . $id;
			if (mysql_query($query)) {
				echo '<B>rejected and deleted.</B></P>';
			}
			if ($popup) {
				echo '<script language="javascript">window.close();</script>';
			}
		}
		break;

	case 'edit':
		$query = 'SELECT *,UNIX_TIMESTAMP(ts) AS xwhen FROM note WHERE id='.$id;
		if ($result = mysql_query($query)) {
			$row = mysql_fetch_array($result);
			echo '<FORM method="POST" action="/manual/admin-notes.php">';
			echo '<INPUT type="hidden" name="user" value="'.$user.'">';
			echo '<INPUT type="hidden" name="pass" value="'.$pass.'">';
			echo '<TABLE BORDER="0" CELLPADDING="5" CELLSPACING="0" BGCOLOR="#D0D0D0">';
			echo '<TR valign="top"><TD><B>E-mail:</B></TD><TD><INPUT type="text" size="40" name="nuser" value="',$row['user'], '"></TD></TR>';
			echo '<TR valign="top"><TD><B>Note:</B></TD><TD><TEXTAREA name="note" rows="8" cols="50">', $row['note'],'</TEXTAREA></TD></TR>';
			echo '<TR><TD colspan="2"><FONT SIZE="-1"><INPUT type="submit" name="action" value="modify ', $id, '"></TD></TR>';
			echo "</TABLE></FORM>\n";
			commonFooter();
			exit;
		} else {
			echo "<P><B>Unable to find note for editing.</B></P>\n";
		}
		break;

	case 'modify':
		$query = 'SELECT *,UNIX_TIMESTAMP(ts) AS xwhen FROM note WHERE id='.$id;
		if ($result = mysql_query($query)) {
			$row = mysql_fetch_array($result);
		}
		$add_url = "\n\nhttp://gtk.php.net/manual/en/".sect_to_file($row['sect'])."\n";
		$query = "UPDATE note SET user='$nuser',note='$note' WHERE id=$id";
		if (mysql_query($query)) {
			echo "<P><B>Record modified.</B>";
			mail($mailto, "note ".$row['id']." modified in ".$row['sect']." by $u",stripslashes($note).$add_url,"From: ".$u."@php.net");
		} else {
			echo "<P><B>Record not modified (query failed).</B></P>";
		}
		break;

	default:
		if (!empty($action)) {
			echo "<P><B>Didn't understand action '$action'.</B></P>";
		}
	} // end of switch

} // end of if($action != "")

if(!$last_entry) {
	$limit = " LIMIT $num_entries_per_page";
	$last_entry = $num_entries_per_page;
} else {
	$limit = " LIMIT $last_entry,$num_entries_per_page";
	$last_entry += $num_entries_per_page;
}

// Aparently using "xwhen" does not contend w/ the MySQL namespace
// I could not find docs in which there was a "WHEN" keyword for MySQL

$query = 'SELECT *,UNIX_TIMESTAMP(ts) AS xwhen FROM note ORDER BY sect,ts'.$limit;
$result = mysql_query($query);
if ($error = mysql_error()) {
	echo "<br>ERROR in MySQL: ".mysql_error()."<br>";
	echo "$query<br>";
}
if (!$brief && mysql_num_rows($result) > 0) {
	echo "<P><a href=\"/manual/admin-notes.php?last_entry=$last_entry\">Next $num_entries_per_page entries</a><P>\n";
	echo '<FORM method="POST" action="/manual/admin-notes.php">';
	echo '<INPUT type=hidden name="last_entry" value="'.($last_entry-$num_entries_per_page).'">';
	echo '<TABLE><TR><TD>CVS user:</TD><TD><INPUT type=text name="user" size=8 value="'.$cookie_user.'"></TD>';
	echo '<TD>CVS password:</TD><TD><INPUT type=password name="pass" size=8 value="'.$cookie_pass.'"></TD>';
	echo '<TD>Remember my login/password:</TD><TD><input type=checkbox name=save '.($MAGIC_COOKIE?'CHECKED':'').'></TD></TR>';
	echo '</TABLE>';

	echo '<table border="0" cellpadding="4" cellspacing="0" width="100%">';
	$last = '';
	while ($row = mysql_fetch_array($result)) {
		if ($row['sect'] != $last)  {
			makeTitle($row['sect']);
			$last = $row['sect'];
		}
		makeEntry($row['xwhen'], $row['user'], htmlspecialchars($row['note']), $row['id']);
	}
	echo '</TABLE>';
	echo '</FORM>';
	echo "<a href=\"/manual/admin-notes.php?last_entry=$last_entry\">Next $num_entries_per_page entries</a><P>\n";

} else if (!$brief) {

	echo "<P><B>There are no notes in the system.";

}

commonFooter();

?>
