<?php

SetCookie('MAGIC_COOKIE', '', 0, '/');
unset($MAGIC_COOKIE);

commonHeader('Administration Logout');

echo "<h1>Administration Logout</h1>";

if(!isset($MAGIC_COOKIE) {
	echo "You have been logged out.  Click <a href = '$_SERVER[HTTP_REFERER]'>here</a> for it to really take effect.";
	}

else {
	echo "Unable to log you out.";
	}

commonFooter();

?>
