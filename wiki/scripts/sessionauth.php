<?php if (!defined('PmWiki')) exit();
/*  Copyright 2002-2003 Patrick R. Michaud (pmichaud@pobox.com)
    This file is part of PmWiki; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.  See pmwiki.php for full details.
*/

session_start();
$AuthFunction = 'SessionAuth';
if (@$_POST['authpw']) 
  $_SESSION['authpw'] = $_POST['authpw'];
SDV($SessionAuthFmt,"<b>Password required</b><p>
  <form name='authform' action='{$_SERVER['REQUEST_URI']}' 
    method='post'>Password: 
    <input tabindex='1' type='password' name='authpw' value='' />
    <input type='submit' value='OK' />
  </form>");

function SessionAuth($pagename,$level,$authprompt=true) {
  global $GroupAttributesFmt,$DefaultPasswords,
    $AllowPassword,$HTMLBodyFmt,$SessionAuthFmt;
  $page = ReadPage($pagename);
  if (!$page) { return false; }
  @$passwd = $page["passwd$level"];
  if ($passwd=="") {
    $grouppg = ReadPage(FmtPageName($GroupAttributesFmt,$pagename));
    @$passwd = $grouppg["passwd$level"];
  }
  if (crypt($AllowPassword,$passwd)==$passwd) return $page;
  if ($passwd=="") { $passwd=@$DefaultPasswords[$level]; }
  if ($passwd=="") return $page;
  $authpw = $_SESSION['authpw'];
  foreach(array_merge($DefaultPasswords['admin'],$passwd) as $pw)
    if (crypt($authpw,$pw)==$pw) return $page;
  if (!$authprompt) return false;
  $HTMLBodyFmt = str_replace('<body ',
    '<body onload="document.authform.authpw.focus()" ',$HTMLBodyFmt);
  $action = $GLOBALS['action']; 
  StartHTML($pagename,"Authorization required");
  PrintFmt($pagename,$SessionAuthFmt);
  EndHTML();
  exit;
}

?>
