<?php

	// 
	// All the links to screenshots pass through this file.  The url looks something like this:
	// http://host.com/apps/screenshot.php/8.jpg.  This would read 8.jpg from APP_SCREENSHOT_DIR.
	// 

	Header("Content-type: image/jpeg");
	require_once("apps.inc");

	readfile(APP_SCREENSHOT_DIR . $PATH_INFO);
?>
