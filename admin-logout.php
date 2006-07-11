<?php

require('cvs-auth.inc');

/* allow for timezone differences */
setcookie($user = get_user(), '', time() - (3600*24), '/');
setcookie('PHP-GTK', '', time() - (3600*24), '/');

/* kill any test data */
if (file_exists(DB_DIR."/$user.notes.sqlite")) unlink(DB_DIR."/$user.notes.sqlite");
if (file_exists(DB_DIR."/$user.queue.sqlite")) unlink(DB_DIR."/$user.queue.sqlite");
if (file_exists(DB_DIR."/$user.lastid.txt")) unlink(DB_DIR."/$user.lastid.txt");

$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';

header("Location: $referrer");
exit;

?>
