<?php if (!defined('PmWiki')) exit();
/*  Copyright 2003-2004 Patrick R. Michaud (pmichaud@pobox.com)
    This file is part of PmWiki; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.  See pmwiki.php for full details.

    This file adds the "?action=diag" action to PmWiki.  This produces
    lots of diagnostic output that may be helpful to the software authors
    when debugging PmWiki or other scripts.

    This file is automatically included by stdconfig.php if
        $EnableDiag = 1;
    is set in config.php.
*/

if ($action=='diag') {
  header("Content-type: text/plain");
  print_r($GLOBALS);
  exit();
}

if ($action=='phpinfo') { phpinfo(); exit(); }

?>
