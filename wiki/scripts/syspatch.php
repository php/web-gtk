<?php
/*  Copyright 2004 Patrick R. Michaud (pmichaud@pobox.com)
    This file is part of PmWiki; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.  See pmwiki.php for full details.

    This script contains the Patch function that existed in versions
    of PmWiki prior to 0.6.18.  This function is used to restore
    previous versions of a page from a page's history, and makes use
    of an external call to patch(1) to recover the page.  

    The use of the external patch(1) program has some potential
    disadvantages:
      1. It requires a call to an external program
      2. It sometimes leaves temporary files in the wiki.d/ directory
      3. It doesn't always work right for normal diff output
      4. The repeated reading/writing of files to disk may be
         slower than a PHP-based patch

    However, the use of external patch(1) may have some advantages in
    speed and robustness in handling a variety of diff output formats,
    therefore this module is included as an option.  

    To enable the Patch functionality contained here, simply add the line
        include_once('scripts/syspatch.php');
    to the local/config.php file.  This will return PmWiki to using
    the external patch utility and the algorithm in versions of PmWiki
    prior to 0.6.18.
*/

SDV($PatchFunction,'SysPatch');
SDV($SysPatchCmd,'/usr/bin/patch --silent');

function SysPatch($page,$restore) {
  global $WikiDir,$SysPatchCmd;
  Lock(2);
  $txtfile = tempnam($WikiDir,"txt");
  $patfile = tempnam($WikiDir,"pat");
  if ($txtfp = fopen($txtfile,"w")) {
    fputs($txtfp,$page['text']);
    fclose($txtfp);
  }
  krsort($page); reset($page);
  foreach($page as $k=>$v) {
    if ($k < $restore) break;
    if (!preg_match('/^diff:/',$k)) continue;
    if ($patfp = fopen($patfile,"w")) {
      fputs($patfp,$v);
      fclose($patfp);
    }
    system("$SysPatchCmd $txtfile $patfile");
  }
  $text = implode('',file($txtfile));
  @unlink($txtfile); @unlink($patfile);
  return $text;
}

?>
