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
	SetCookie("MAGIC_COOKIE", base64_encode("$user:$pass"), time()+3600*24*12, '/');
}

/*
if(!strstr($MYSITE,"www.php.net")) {
	Header("Location: http://www.php.net/manual/admin-notes.php");
	exit;
}
*/

commonHeader("Manual Notes Administration");

echo "<P>If you just want to browse the manual notes, you're better off " .
	"<A href=\"http://gtk.php.net/manual/browse-notes.php\">here</A>.</P>\n";

mysql_pconnect("localhost","nobody","");
mysql_select_db("gtk");

if ($action != '') {

	if (!verify_password($user,$pass) && !verify_password($cookie_user, $cookie_pass) ) {
		echo "<P><B>Authorization failed.</P>";
		commonFooter();
		exit;
	}

	list ($action, $id) = explode(' ', $action);
	$u = ($user) ? $user : $cookie_user;

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
			echo '<TABLE BORDER="0" CELLPADDING="5" CELLSPACING="0" BGCOLOR="#e0e0e0">';
			echo '<TR valign="top"><TD align="right">E-mail:</TD>' .
				'<TD><INPUT type="text" size="40" name="nuser" value="',$row['user'], '"><BR></TD></TR>';
			echo '<TR valign="top"><TD align="right">Note: </TD>' .
				'<TD><TEXTAREA name="note" rows="8" cols="50">', $row['note'],'</TEXTAREA><BR></TD></TR>';

			echo '<TR valign="top"><TD align="right">Your CVS username:<BR></TD>' .
				'<TD><INPUT type="text" size="8" name="user" value="' . $user . '"><BR></TD></TR>';
			echo '<TR valign="top"><TD align="right">Your CVS password:<BR></TD>' .
				'<TD><INPUT type="password" size="8" name="pass" value="' . $pass . '"><BR></TD></TR>';
			echo '<TR valign="top"><TD align="right">Remember me:<BR></TD>' .
				'<TD><INPUT type="checkbox" name="saved" checked value="1"><BR></TD></TR>';

			echo '<TR><TD colspan="2"><INPUT type="submit" name="action" value="modify ' .  $id . '"></TD></TR>';
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
		$add_url = "\n\nhttp://gtk.php.net/manual/en/".$row['sect']."\n";
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


include 'browse.php';


commonFooter();

