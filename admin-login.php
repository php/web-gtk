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
	Header("Location: http://master.php.net/manage/users.php");
	exit;
}

commonFooter();

?>
