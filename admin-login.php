<?php

// rather than have login pages spread throughout the site let's have one place for logging in
// that's easy to remember

require_once('config.inc');
require_once('cvs-auth.inc');

commonHeader("Administration Login");
print "<br />\n";

if (!isset($_COOKIE['GTK'])) {
	if (isset($_POST['submit']) && isset($_POST['pass'])) {
		verify_password($_POST['user'], $_POST['pass']);
	} else {
		$user = null;
?>
	<h1>Administration Login</h1>
	<form action = "<?php echo $_SERVER['PHP_SELF'];?>" method = 'POST'>
	<table border='0' cellpadding='3' bgcolor='#e0e0e0' width=<?php echo isset($SIDEBAR_DATA) ? '50%' : '40%'; ?>>
	<tr>
	<td>User name:</td>
	<td><input type = 'text' name = 'user' value = "<?php echo $user;?>"><br /></td>
	<tr>
	<td>Password:</td>
	<td><input type = 'password' name = 'pass' value = '' size = '12'><br /></td>
	<tr>
	<td colspan='2' align='right'><input type = 'submit' name = 'submit'></td>
	</tr>
	</table>
	</form>

<?php
	}
} else {
	unset($user);
	unset($pass);
	print("
		<h1>You are logged in</h1>
		<br />
		<ul>
			<li>Application Administration (currently offline)<br /></li>
			<li><a href='manual/browse-notes.php'>Notes Administration</a><br /></li>
			<li><a href='info.php'>Check phpinfo()</a><br /></li>
			<li><a href='admin-logout.php'>Log out</a></li>
		</ul>
	");
}

print stretchPage(11);
print "&nbsp;</div>\n";
commonFooter();

?>
