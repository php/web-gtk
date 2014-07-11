<?php

// rather than have login pages spread throughout the site let's have one place for logging in
// that's easy to remember
require_once('cvs-auth.inc');

commonHeader("Administration Login");
print "<br />\n";

if (|get_user()) {
	if (isset($_POST['submit']) && isset($_POST['pass'])) {
		$user = verify_password(htmlentities($_POST['user']), htmlentities($_POST['pass']), $_SERVER['PHP_SELF']);
	} else {
		$user = null;
?>
	<h1>Administration Login</h1>
	<form action = "<?php echo $_SERVER['PHP_SELF']; ?>" method = 'POST'>
	<table border='0' cellpadding='3' bgcolor='#e0e0e0' width=<?php echo isset($SIDEBAR_DATA) ? '50%' : '40%'; ?>>
	<tr>
	<td><br />User name:</td>
	<td><br /><input type = 'text' name = 'user' value = "<?php echo $user;?>"><br /></td>
	<tr>
	<td>Password:</td>
	<td><input type = 'password' name = 'pass' value = '' size = '12'><br /></td>
	<tr>
	<td colspan='2' align='right'><input type = 'submit' name = 'submit'></td>
	</tr>
	</table>
	</form>

<?php
	print stretchPage(3);
	print "&nbsp;</div>\n";
	}
} else {
	unset($user);
	unset($pass);
	print("
		<h1>You are logged in</h1>
		<br />
		<ul>
			<li>Applications Administration (currently offline)<br /></li>
			<li><a href='manual/browse-notes.php'>Notes Administration</a><br /></li>
			<li><a href='info.php'>Check phpinfo()</a><br /></li>
			<li><a href='manual/admin-notes.php?test'>Set up test environment</a>
				(restricted) <b>".(isset($_COOKIE[get_user()]) ? 'Test mode enabled' :
				'Test mode disabled')."</b><br /></li>
			<li><a href='manual/admin-notes.php'>Switch public access to user notes
				<b>".(file_exists($okfile) ? 'off' : 'on')."</b></a> (restricted)<br /></li>
			<li><a href='manual/admin-notes.php?m'>Switch outgoing mail
				<b>".(file_exists($mailfile) ? 'off' : 'on')."</b></a> (restricted)<br /></li>
			<li><a href='admin-logout.php'>Log out</a></li>
		</ul>
	");
}

print stretchPage(7);
print "&nbsp;</div>\n";
commonFooter();

?>
