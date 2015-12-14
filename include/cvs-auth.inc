<?php
/* $Id$ */
require_once('config.inc');

function get_auth($name, $pass, $connect = null) {

	static $cvs_encode = array(
		32, 120,  53,  35,  36, 109,  72, 108,
		70,  64,  76,  67, 116,  74,  68,  87,
		111,  52,  75, 119,  49,  34,  82,  81,
		95,  65, 112,  86, 118, 110, 122, 105,
		64,  57,  83,  43,  46, 102,  40,  89,
		38, 103,  45,  50,  42, 123,  91,  35,
		125,  55,  54,  66, 124, 126,  59,  47,
		92,  71, 115,  91,  92,  93,  94,  56,
		96, 121, 117, 104, 101, 100,  69,  73,
		99,  63,  94,  93,  39,  37,  61,  48,
		58, 113,  32,  90,  44,  98,  60,  51,
		33,  97,  62, 123, 124, 125, 126, 127);

	$encoded = 'A';
	$l = strlen($pass);

	for ($i = 0; $i < $l; $i++) {
		$o = ord($pass{$i});
		if ($o >= 32 && $o <= 127) {
			$encoded .= chr($cvs_encode[$o - 32]);
		} else {
			$encoded .= $pass{$i};
		}
	}

	if (!$connect) {
		$encrypted = crypt($encoded);
		return $encrypted;
	}

	$cvs = fsockopen('cvs.php.net', 2401, $errno, $errstr);
	if (!$cvs)
		return false;

	$pkt = "BEGIN VERIFICATION REQUEST\n/repository\n$name\n$encoded\nEND VERIFICATION REQUEST\n";

	fwrite($cvs, $pkt);
	$response = fgets($cvs);
	fclose($cvs);
	return 0 == strncmp($response, 'I LOVE YOU', 10) ? true : false;
}

function verify_password($user, $pass, $ref) {

	if (strlen($user) > 0 && strlen($pass) > 0) {

		if (!isset($_COOKIE['PHP-GTK'])) {

			$auth = get_auth($user, $pass, true);

			if ($auth == true) {
				$encoded = get_auth($user, $pass);
				setcookie('PHP-GTK', base64_encode($user.':'.$encoded), time()+(3600*6), '/');
				file_put_contents(DB_DIR."/$user.txt", $encoded);
			}
		}
	}
	header("Location: $ref");
}

function get_user() {

	// TODO: kill magic cookie
	if (isset($_COOKIE['PHP-GTK'])) {
		list($user, $pass) = explode(':', base64_decode($_COOKIE['PHP-GTK']));
		// using the same username validation as done for new accounts on php.net
		if (!preg_match('!^[a-z]\w+$!', $user)) {
			return false;
		}
		// TODO: kill file based password storage
		if (!file_exists(DB_DIR."/$user.txt")) {
			return false;
		}
		if ($pass === file_get_contents(DB_DIR."/$user.txt")) {
			return $user;
		}
	}
	return false;
}

?>
