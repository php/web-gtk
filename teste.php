<?php
echo $_SERVER['PATH_INFO'];
echo "<br>";
echo $_SERVER['PHP_SELF'];
$clean = str_replace($_SERVER['PATH_INFO'], '', $_SERVER['PHP_SELF']);
echo "<br>";
echo $clean;
?>