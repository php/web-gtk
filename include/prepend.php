<?php

if (isset($_SERVER['PATH_INFO'])) {
	$clean = str_replace($_SERVER['PATH_INFO'], '', $_SERVER['PHP_SELF']);
	header("Location: $clean");
	exit;
}

require_once 'site.php';
require_once 'layout.php';

?>