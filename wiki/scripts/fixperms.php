<?php if (!defined('PmWiki')) exit();
/*  Copyright 2002-2004 Patrick R. Michaud (pmichaud@pobox.com)
    This file is part of PmWiki; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.  See pmwiki.php for full details.

    This script will attempt to fix ownerships and permissions on wiki
    page files in the wiki.d directory as pages are accessed.  It does
    this by checking that the page being accessed is writable, and if not
    it renames the file to append a date, makes a copy of the file back to
    the original name (thus restoring file ownership), and explicitly
    sets file permissions on the new file according to the current umask.

    It also checks the permissions on the .flock file and removes it
    as appropriate.

    Finally, this script adds ?action=fixallperms, which will check
    and fix all pages in $WikiDir (wiki.d) with invalid permissions.

    You can enable this script by adding the following line at the end
    of config.php:
	include_once("scripts/fixperms.php");
*/

if (file_exists("$WikiDir/.flock") && !is_writable("$WikiDir/.flock")) 
  unlink("$WikiDir/.flock");
$pagefile = FmtPageName("$WikiDir/$PageFileFmt",$pagename);
if (file_exists($pagefile) && !is_writable($pagefile)) {
  Lock(2);
  @rename($pagefile,"$pagefile,$Now") &&
    @copy("$pagefile,$Now",$pagefile) &&
    @chmod($pagefile,0666 & ~umask());
  Lock(0);
}

if ($action=='fixallperms') {
  Lock(2);
  $dfp=opendir($WikiDir); 
  $uid=posix_geteuid();
  if ($dfp) {
    while(($pf=readdir($dfp))!=false) {
      if (!preg_match("/^$GroupNamePattern\.$PageTitlePattern\$/",$pf))
        continue;
      $pagefile="$WikiDir/$pf";
      if (fileowner($pagefile)==$uid && is_writable($pagefile)) continue;
      @rename($pagefile,"$pagefile,$Now") &&
        @copy("$pagefile,$Now",$pagefile) &&
        @chmod($pagefile,0666 & ~umask());
    }
    closedir($dfp);
  }
  Lock(0);
}

?>
