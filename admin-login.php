<?php

// rather than have login pages spread throughout the site let's have one place for logging in
// that's easy to remember

require_once('config.inc');
require_once('cvs-auth.inc');

commonHeader("Administration Login");

if (!isset($_COOKIE['GTK'])) {
	if (isset($_POST['submit']) && isset($_POST['pass'])) {
		verify_password($_POST['user'], $_POST['pass']);
	} else {
		$user = null;
?>

		<form action = "<?php echo $_SERVER['PHP_SELF'];?>" method = 'POST'>
		User: <input type = 'text' name = 'user' value = "<?php echo $user;?>">
		<br />
		Pass: <input type = 'password' name = 'pass' value = '' size = '12'>
		<br />
		<br />
		<input type = 'submit' name = 'submit'>
		</form>

<?php
	}
} else {
	unset($user);
	unset($pass);
	print("
		<h1>You're logged in</h1>
		Where do you want to go today?
		<br />
		<br />
		<ul>
			<li><a href='/apps/admin-apps.php'>Application Administration</a>
			<br />
			<li><a href='/manual/admin-notes.php'>Notes Administration</a>
			<br />
			<li><a href='admin-logout.php'>Log out</a>
		</ul>
	");
}

commonFooter();

?>
