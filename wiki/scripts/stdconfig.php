<?php if (!defined('PmWiki')) exit();
/*  Copyright 2002-2004 Patrick R. Michaud (pmichaud@pobox.com)
    This file is part of PmWiki; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.  See pmwiki.php for full details.

    This file allows features to be easily enabled/disabled in config.php.
    Simply set variables for the features to be enabled/disabled in config.php
    before including this file.  For example:
	$EnableQAMarkup=0;			#disable Q: and A: tags
        $EnableDefaultWikiStyles=1;		#include default wikistyles
    Each feature has a default setting, if the corresponding $Enable
    variable is not set then you get the default.

    To avoid processing any of the features of this file, set 
        $EnableStdConfig = 0;
    in config.php.
*/

SDV($DefaultPage,"$DefaultGroup/$DefaultTitle");
if ($pagename=='') $pagename=$DefaultPage;

if (isset($EnableStdConfig) && !$EnableStdConfig) return;

if (!isset($EnablePerGroupCust) || $EnablePerGroupCust)
  include_once("$FarmD/scripts/pgcust.php");
if (!isset($EnableAuthorTracking) || $EnableAuthorTracking)
  include_once("$FarmD/scripts/author.php");
if (!isset($EnablePrint) || $EnablePrint)
  include_once("$FarmD/scripts/print.php");
if (!isset($EnableTemplateLayout) || $EnableTemplateLayout)
  include_once("$FarmD/scripts/tlayout.php");
if ($action=='diff' && @!$HandleActions['diff'])
  include_once("$FarmD/scripts/pagerev.php");
if (!isset($EnableQAMarkup) || $EnableQAMarkup)
  include_once("$FarmD/scripts/faq.php");
if (!isset($EnableWikiTrails) || $EnableWikiTrails)
  include_once("$FarmD/scripts/trails.php");
if (!isset($EnableStdWikiStyles) || $EnableStdWikiStyles)
  include_once("$FarmD/scripts/wikistyles.php");
if (!isset($EnableThisWiki) || $EnableThisWiki)
  include_once("$FarmD/scripts/thiswiki.php");
if (@$EnableMailPosts)
  include_once("$FarmD/scripts/mailposts.php");
if (@$EnableUpload)
  include_once("$FarmD/scripts/upload.php");
if (!isset($EnableSearch) || $EnableSearch)
  include_once("$FarmD/scripts/search.php");
if (!isset($EnableVarMarkup) || $EnableVarMarkup)
  include_once("$FarmD/scripts/vardoc.php");
if (@(!isset($EnablePreviewOnRequestOnly) || $EnablePreviewOnRequestOnly)
  && @!$preview) $PagePreviewFmt='';
if (!isset($EnableCrypt) || $EnableCrypt)
  include_once("$FarmD/scripts/crypt.php");
SDV($MetaRobots,
  ($action!='browse' || preg_match('#^PmWiki[./](?!PmWiki$)#',$pagename))
    ? 'noindex,nofollow' : 'index,follow');
if ($MetaRobots) 
  $HTMLHeaderFmt[] = "  <meta name='robots' content='$MetaRobots' />\n";

if (@$EnableDiag) 
  include_once("$FarmD/scripts/diag.php");
?>
