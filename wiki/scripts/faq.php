<?php if (!defined('PmWiki')) exit();
/*  Copyright 2002-2004 Patrick R. Michaud (pmichaud@pobox.com)
    This file is part of PmWiki; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.  See pmwiki.php for full details.

    This file adds the 'Q:' and 'A:' markup to PmWiki.  A line beginning
    with 'Q:' is rendered in boldface, and a line beginning with 'A:'
    is converted to a first-level indent.  

    This file is automatically included by stdconfig.php unless
    disabled by
	$EnableQAMarkup = 0;
    in config.php.
*/

$DoubleBrackets['/^Q:(.*)$/'] = '<b>$1</b>';
$DoubleBrackets['/^A:/'] = ': :';
?>
