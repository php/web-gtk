<?php if (!defined('PmWiki')) exit();
/*  This script enables markup of the form [*http:path*] to be
    substituted with the contents of another web document.
    Note that this can introduce some bizarre effects and potentially
    introduce some security holes, so be careful!  You probably don't
    want to enable this if your pages are editable by the world at large.
*/

$DoubleBrackets['/\[\*(http:.*?)\*\]/e'] = 'fp("$1");';
$InlineReplacements["/\265(\\d+)\265/e"] = 
   'join("",file(str_replace("&amp;","&",$GLOBALS["fpv"][$1])));';
function fp($str) {
  global $fpv,$fpcount;
  $fpcount++; $fpv[$fpcount] = $str;
  return "\265$fpcount\265";
}
?>
