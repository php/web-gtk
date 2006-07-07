<?php

require_once('cvs-auth.inc');

if (!get_user()) {
	$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));

	header("Location: $referrer");
	exit;
}

phpinfo();

?>
