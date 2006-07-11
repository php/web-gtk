<?php

require_once('cvs-auth.inc');

if (!get_user()) {
	$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';

	header("Location: $referrer");
	exit;
}

phpinfo();

?>
