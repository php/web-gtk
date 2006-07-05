<?php

if (!isset($_COOKIE['MAGIC_COOKIE'])) { /* remember to change this, assuming everything works */
	header("Location: {$_SERVER['HTTP_REFERER']}");
	exit;
}

phpinfo();

?>
