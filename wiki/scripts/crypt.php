<?php if (!defined('PmWiki')) exit();
/*  Copyright 2002-2004 Patrick R. Michaud (pmichaud@pobox.com)
    This file is part of PmWiki; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.  See pmwiki.php for full details.

    This script defines ?action=crypt, providing help for WikiAdministrators
    to set up site-wide passwords in the installation.
*/

if ($action=='crypt') { HandleCrypt(); exit; }

function HandleCrypt() {
  global $ScriptUrl;
  StartHTML("","Encrypt Password");
  $passwd = @$_POST["passwd"];
  echo "<form action='$ScriptUrl' method='POST'><p>
    Enter password to encrypt: <input type='text' name='passwd' value='$passwd' />
    <input type='submit' />
    <input type='hidden' name='action' value='crypt' /></p></form>";
  if ($passwd) { 
    $crypt = crypt($passwd);
    echo "<p>Encrypted password = $crypt</p>"; 
    echo "<p>To set a site-wide password, insert the line below
      in your <i>config.php</i> file, <br />replacing <tt>'type'</tt> with
      one of <tt>'admin'</tt>, <tt>'read'</tt>, <tt>'edit'</tt>,
      or <tt>'attr'</tt>.  <br />See <a 
      href='$ScriptUrl?pagename=PmWiki.PasswordsAdmin'>PasswordsAdmin</a> for more
      details.</p><pre>  \$DefaultPasswords['type']='$crypt';</pre>";
  }
  EndHTML();
}

?>
