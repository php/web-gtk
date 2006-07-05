<?php

if (!isset($_COOKIE['GTK'])) { /* remember to change this, assuming everything works */
	header("Location: {$_SERVER['HTTP_REFERER']}");
	exit;
}

phpinfo();

?>
