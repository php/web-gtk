<?php

/* notes admin addresses */
$mailto    = 'php-gtk-webmaster@lists.php.net';
$mailfrom  = 'notes@gtk.php.net';

/* filepaths */
define('DB_DIR', '../../db');

$notesfile =  DB_DIR.'/gtknotes.sqlite';
$queuefile =  DB_DIR.'/gtkqueue.sqlite';
$blockfile =  DB_DIR.'/gtkblocked.txt';
$stats     =  DB_DIR.'/gtkstats.txt';
$last_id   =  DB_DIR.'/gtklastid.txt';

/* db update checks. Settings of 15, 10 and 2 could have prevented phpdoc's last attack */
$recent     = strtotime("15 minutes ago");
$veryrecent = strtotime("10 minutes ago");
$likely     = 2;

?>
