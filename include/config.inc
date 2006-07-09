<?php

/* notes admin addresses */
$mailto    = 'php-gtk-webmaster@lists.php.net';
$mailfrom  = 'notes@gtk.php.net';

/* filepaths */
define('DB_DIR', '/local/Web/php-gtk-notes-db');

/**
 * NOTE: We need a stable 'lastid' because the databases are out of
 * sync, both with each other and with the mail archives we're currently
 * using to monitor activity. If we 'lose' the mail part in the future
 * (which we probably will if it's all looking stable) we can move to
 * using sqlite_last_insert_rowid(). Just in case y'all wondered :)
 */
$notesfile  =  DB_DIR.'/gtknotes.sqlite';
$queuefile  =  DB_DIR.'/gtkqueue.sqlite';
$blockfile  =  DB_DIR.'/gtkblocked.txt';
$stats      =  DB_DIR.'/gtkstats.txt';
$last_id    =  DB_DIR.'/gtklastid.txt';
$okfile     =  DB_DIR.'/gtkgolive.txt';
$mailfile   =  DB_DIR.'/gktmaillive.txt';

/* db update checks. Settings of 15, 10 and 2 could have prevented phpdoc's last attack */
$recent     = strtotime("15 minutes ago");
$veryrecent = strtotime("10 minutes ago");
$likely     = 2;

/* some things need restricted access */
$systems = array('andrei', 'sfox');
$docteam = array('andrei', 'cweiske', 'sfox', 'anant', 'scottmattocks');

$user = get_user();
if ($user && isset($_COOKIE[$user])) {
	$mailto    = $_COOKIE[$user];
	$notesfile = DB_DIR."/$user.notes.sqlite";
	$queuefile = DB_DIR."/$user.queue.sqlite";
	$last_id   = DB_DIR."/$user.lastid.txt";
}

$mail = file_exists($mailfile) ? true : false;

?>
