<?
if (!isset($_SERVER['HTTP_REFERER'])) {
	$_SERVER['HTTP_REFERER']="-";
}

if (!isset($download_file)
	|| !file_exists("distributions/$download_file")) {
	exit("Invalid file requested for download!");
}

header("Location: http://$SERVER_NAME/distributions/$download_file");

$remote_addr = $_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];

$remote_log =
	@fopen("http://gtk.php.net/log_download.php".
		"?download_file=" . urlencode($download_file).
		"&mirror=" . urlencode($_SERVER['SERVER_NAME']).
		"&user_referer=" . urlencode($_SERVER['HTTP_REFERER']).
		"&user_ip=" . urlencode($remote_addr),
	'r');

if ($remote_log) {
	fread($remote_log, 1024);
	fclose($remote_log);
}

?>
