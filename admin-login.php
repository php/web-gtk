<?php

// 
// rather than have login pages spread throughout the site let's have one place for logging in
// that's easy to remember.
// 

//require_once 'cvs-auth.inc';

if (isset($MAGIC_COOKIE)) {
	list($user, $pass) = explode(":", base64_decode($MAGIC_COOKIE));
}
if ($user && $pass) {
	if( $saveme ) {
		SetCookie("MAGIC_COOKIE", base64_encode("$user:$pass"), time()+(86400*7), '/' );
	}else {
		SetCookie("MAGIC_COOKIE", base64_encode("$user:$pass"));
	}
}

commonHeader("Administration Login");

if (isset($MAGIC_COOKIE)) {
	print("
		<h1>You're logged in</h1>
		Where do you really want to go today?
		<br>
		<br>
		<ul>
			<li><a href='/apps/admin-apps.php'>Application Administration</a><br><br>
			<li><a href='/manual/admin-notes.php'>Notes Administration</a>
		</ul>
	");
}else {
	echo "<h1>Administration Login</h1>\n\n";

	echo '<FORM method="POST" action="/admin-login.php">';
	echo '<TABLE BORDER="0" CELLPADDING="5" CELLSPACING="0" BGCOLOR="#e0e0e0">';
	echo '<TR valign="top"><TD align="right"><small>Your CVS username:<br></small></TD>' .
		'<TD><INPUT type="text" size="8" name="user" value="' . $user . '"><BR></TD></TR>';
	echo '<TR valign="top"><TD align="right"><small>Your CVS password:<br></small></TD>' .
		'<TD><INPUT type="password" size="8" name="pass" value="' . $pass . '"><BR></TD></TR>';
	echo '<TR valign="top"><TD align="right"><small>Remember me:<br></small></TD>' .
		'<TD><INPUT type="checkbox" name="saveme" checked value="1"><BR></TD></TR>';

	echo '<TR><TD colspan="2"><INPUT type="submit" name="action" value="login"></TD></TR>';
	echo "</TABLE></FORM>\n";
}

commonFooter();

?>
