<?php // -*- C++ -*-

require_once 'prepend.php';
require_once 'manual-lookup.inc';

/* -- Override this for now.. -- */
$lang="en";

if (!$function && $pattern) $function = $pattern;
$function = strtolower($function);
if (!isset($lang)) $lang = default_language();

$file = find_manual_page($lang, $function);

if ($file) {
    header("Location: $file");
    exit;
}

//$notfound = $prevsearch = $function;
//include 'quickref.php';
/* -- We need to setup htdig and sort out quick ref at some point */
header("Location: http://gtk.php.net/");
exit;

?>
