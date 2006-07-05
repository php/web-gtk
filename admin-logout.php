<?php

/* allow for timezone differences */
setcookie('GTK', '', time() - (3600*24), '/');

header("Location: {$_SERVER['HTTP_REFERER']}");
exit;

?>
