<?php if (!defined('PmWiki')) exit();
/*  Copyright 2002-2004 Patrick R. Michaud (pmichaud@pobox.com)
    This file is part of PmWiki; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.  See pmwiki.php for full details.

    This script defines the ThisPage:, ThisGroup:, and ThisWiki: 
    InterMap links.  It is included by default from the stdconfig.php
    script unless disabled by $EnableThisWiki=0; in config.php.

    To explicitly enable this feature, execute
	include_once("scripts/thiswiki.php");
    from config.php somewhere.

    Note that any changes to $ScriptUrl or $UrlPathPattern must occur 
    prior to executing this script.
*/

$LinkPatterns[100]["ThisWiki:($UrlPathPattern)"] = $FmtUrlLink;
$LinkPatterns[100]["ThisPage:($UrlPathPattern)"] = $FmtUrlLink;
$LinkPatterns[100]["ThisGroup:($UrlPathPattern)"] = $FmtUrlLink;
$LinkPatterns[100]["ThisSite:($UrlPathPattern)"] = $FmtUrlLink;
$InterMapUrls['ThisWiki'] = $ScriptUrl.'$1';
$InterMapUrls['ThisPage'] = FmtPageName('$PageUrl$1',$pagename);
$InterMapUrls['ThisGroup'] = FmtPageName('$ScriptUrl/$Group/$1',$pagename);
$InterMapUrls['ThisSite'] = 'http://'.$_SERVER['HTTP_HOST'].'$1';
?>
