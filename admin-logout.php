<?php

setcookie('MAGIC_COOKIE', '', time() - 3600, '/');
unset($MAGIC_COOKIE);

commonHeader('Administration Logout');

echo '<h1>Administration Logout</h1>';
echo 'You have been logged out.  Click somewhere for it to really take effect.';

commonFooter();

?>
