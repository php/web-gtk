<?php if (!defined('PmWiki')) exit();
/*  Copyright 2004 Patrick R. Michaud (pmichaud@pobox.com)
    This file is part of PmWiki; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.  See pmwiki.php for full details.

    This script handles author tracking.
*/

SDV($AuthorCookieExpires,$Now+60*60*24*30);
SDV($AuthorCookieDir,'/');
SDV($AuthorGroup,'Profiles');
SDV($AuthorRequiredFmt,
  "<h3 class='wikimessage'>$[An author name is required.]</h3>");
$DoubleBrackets['/{{~([[:alpha:]][-\\w\\s]*)}}/'] =
  "$AuthorGroup/\{\{$1}}";

if (!isset($Author)) {
  if (isset($_POST['author'])) {
    $Author = htmlspecialchars(stripmagic($_POST['author']),ENT_QUOTES);
    setcookie('author',$Author,$AuthorCookieExpires,$AuthorCookieDir);
  } else {
    $Author = htmlspecialchars(stripmagic(@$_COOKIE['author']),ENT_QUOTES);
  }
  $Author = preg_replace('/(^[^[:alpha:]]+)|[^\\w- ]/','',$Author);
}
if ($k=FreeLink("{{".$Author."}}")) {
  SDV($AuthorPage,"$AuthorGroup/".$k['name']);
  SDV($AuthorLink,"$AuthorGroup/{{".$k['name']."}}");
}
SDV($AuthorLink,$Author);

if ($EnablePostAuthorRequired && $Author=='' 
    && $action=='edit' && $_POST['post']) {
  unset($_POST['post']);
  $preview = 'y';
  $EditMessageFmt .= $AuthorRequiredFmt;
}

?>
