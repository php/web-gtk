<?
commonHeader('Magic Cookie');

echo '<h1>Magic Cookie</h1>';

if (isset($user) && isset($pass)) {
	$MAGIC_COOKIE = base64_encode("$user:$pass");
	# we set a cookie good for five years
	SetCookie("MAGIC_COOKIE", base64_encode("$user:$pass"), time()+157248000);
	echo "<P><b>Cookie set</b>.</P>";
}
if (isset($MAGIC_COOKIE)) {
	list($user,$pass) = explode(":", base64_decode($MAGIC_COOKIE));
}

?>

<form action="<?echo $PHP_SELF;?>" method="POST">
User: <input type=text name=user value="<?echo $user;?>">
<br>
Pass: <input type=password name=pass value="<?echo $pass;?>">
<br>
<input type="submit">
</form>

<?

commonFooter();

?>
