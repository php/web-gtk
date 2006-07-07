<?php

/* allow for timezone differences */
setcookie('GTK', '', time() - (3600*24), '/');

$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $_SERVER['REQUEST_URI'];
header("Location: $referrer");
exit;

?>
