<?
SetCookie('MAGIC_COOKIE', '', 0, '/');
unset($MAGIC_COOKIE);

commonHeader('Magic Cookie');

echo '<h1>Magic Cookie</h1>';
echo '<P><b>Cookie unset</b>.</P>';

commonFooter();


