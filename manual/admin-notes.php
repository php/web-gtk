<?

//require_once 'cvs-auth.inc';
require_once 'email-validation.inc';
require_once 'shared-manual.inc';

$mailto = 'php-gtk-webmaster@lists.php.net';
$num_entries_per_page = 50;

if (isset($MAGIC_COOKIE)) {
	list($user, $pass) = explode(":", base64_decode($MAGIC_COOKIE));
}

/*
if(!strstr($MYSITE,"www.php.net")) {
	Header("Location: http://www.php.net/manual/admin-notes.php");
	exit;
}
*/

updateNotesVoting();

commonHeader("Manual Notes Administration");
echo "<h1>Manual Notes Administration</h1>\n\n";

echo "<P>If you just want to browse the manual notes, you're better off " .
	"<A href=\"http://gtk.php.net/manual/browse-notes.php\">here</A>.</P>\n";

if ($action != '') {

	list ($action, $id) = explode(' ', $action);

	if ($action!='edit'&& !isset($MAGIC_COOKIE)) {
		echo "<P><B>Authorization failed.</B></P>";
		commonFooter();
		exit;
	}

	switch($action) {
	case 'delete':
		$query = 'SELECT *,UNIX_TIMESTAMP(ts) AS xwhen FROM note WHERE id='.$id;
		if ($result = mysql_query($query)) {
			$row = mysql_fetch_array($result);
			mail($mailto, "note ".$row['id']." deleted from ".$row['sect']." by $user",stripslashes($row['note']),"From: ".$user."@php.net");
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
		$reject_text .= "use the resources listed in <http://www.php.net/support.php>\n";
		$reject_text .= "for those purposes. This was clearly stated in the page\n";
		$reject_text .= "you used to submit your note, please carefully re-read\n";
		$reject_text .= "those instructions before submitting future contributions.\n\n";
		$reject_text .= "Bug Submissions should be entered at <http://gtk.php.net/bugs/>\n";
		$reject_text .= "Feature Requests should also be entered at <http://gtk.php.net/bugs/>\n";
		$reject_text .= "Support and ways to find answers to your guestions can be found\n";
		$reject_text .= "at <http://www.php.net/support.php>\n\n";
		$reject_text .= "Your note has been removed from the on-line manual.\n\n";
		$query = 'SELECT *,UNIX_TIMESTAMP(ts) AS xwhen FROM note WHERE id='.$id;
		if ($result = mysql_query($query)) {
			$row = mysql_fetch_array($result);
			// email the submitter if the address looks reasonable
			// uses functions in include/email-validation.inc
			$submitter = clean_AntiSPAM($row['user']);
			echo "<P>Note ".$row['id']." by: ".$row['user']." ($submitter) ";
			if (is_emailable_address($submitter)) {
				mail($submitter,"note ".$row['id']." rejected and deleted from ".$row['sect']." by notes editor $user",$reject_text."----- Copy of your note below -----\n\n".stripslashes($row['note']),"From: ".$user."@php.net");
			}
			// email to the list
			mail($mailto, "note ".$row['id']." rejected and deleted from ".$row['sect']." by $user",stripslashes($row['note']),"From: ".$user."@php.net");
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
		echo "<P>Only people with " . make_link('http://www.php.net/cvs-php.php', 'CVS accounts') . 
			" are able to edit the manual notes, so please don't email us asking when this doesn't work for you.</P>";
		$query = 'SELECT *,UNIX_TIMESTAMP(ts) AS xwhen FROM note WHERE id='.$id;
		if ($result = mysql_query($query)) {
			$row = mysql_fetch_array($result);
			echo '<FORM method="POST" action="/manual/admin-notes.php">';
			echo '<TABLE BORDER="0" CELLPADDING="5" CELLSPACING="0" BGCOLOR="#e0e0e0">';
			echo '<TR valign="top"><TD align="right"><small>E-mail:<br></small></TD>' .
				'<TD><INPUT type="text" size="40" name="nuser" value="',$row['user'], '"><BR></TD></TR>';
			echo '<TR valign="top"><TD align="right"><small>Note:<br></small></TD>' .
				'<TD><TEXTAREA name="note" rows="8" cols="50">' . $row['note'] . '</TEXTAREA><BR></TD></TR>';
			echo '<TR valign="top"><TD align="right"><small>Reset rating:<br></small></TD>' .
				'<TD><SELECT name="rating">';
			echo '<OPTION VALUE="0">leave unchanged';
			echo '<OPTION VALUE="-1">clear all votes';
			for ($i=1; $i<=5; $i++) {
				echo '<OPTION VALUE="' . $i . '">set to '.$i. "\n";
			}
			echo '</SELECT><BR></TD></TR>';

			echo '<tr bgcolor="#cccccc"><td colspan="2"></td></tr>';

			echo '<TR valign="top"><TD align="right"><small>Your CVS username:<br></small></TD>' .
				'<TD><INPUT type="text" size="8" name="user" value="' . $user . '"><BR></TD></TR>';
			echo '<TR valign="top"><TD align="right"><small>Your CVS password:<br></small></TD>' .
				'<TD><INPUT type="password" size="8" name="pass" value="' . $pass . '"><BR></TD></TR>';
			echo '<TR valign="top"><TD align="right"><small>Remember me:<br></small></TD>' .
				'<TD><INPUT type="checkbox" name="saveme" checked value="1"><BR></TD></TR>';

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
		$query = "UPDATE note SET user='$nuser',note='$note'";
		$rating = (int)$rating;
		if ($rating==-1) {
			$query .= ",votes=0,rating=0";
		} else if ($rating > 0) {
			$query .= ",votes=10,rating=(10*".$rating.")";
		}
		$query .= " WHERE id=$id";
		if (mysql_query($query)) {
			echo "<P><B>Record modified.</B></P>";
			mail($mailto, "note ".$row['id']." modified in ".$row['sect']." by $user",stripslashes($note).$add_url,"From: ".$user."@php.net");
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


$MAGIC_COOKIE = 'temp';
include 'browse.php';


commonFooter();

