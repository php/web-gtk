<?php if (!defined('PmWiki')) exit();
/*  Copyright 2004 Patrick R. Michaud (pmichaud@pobox.com)
    This file is part of PmWiki; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.  See pmwiki.php for full details.

    This script defines the ?action=print action to give a printable
    view of a page.  Essentially it performs the following modifications:
      - Changes the page skin to 'print' (locally defined by $PrintSkin)
      - Redefines the standard layout to a format suitable for printing
      - Redefines internal links to keep ?action=print
      - Changes the display of URL and mailto: links
      - Uses GroupPrintHeader and GroupPrintFooter pages instead
        of GroupHeader and GroupFooter
*/

if ($action=='print') {
  SDV($PrintTemplateFmt,"$FarmD/pub/skins/print/print.tmpl");
  $PageTemplateFmt = $PrintTemplateFmt;
  $WikiPageExistsFmt = "<a class='wikilink' href='\$PageUrl?action=print\$Fragment'>\$LinkText</a>";
  $UrlLinkTextFmt = "<cite class='urllink'>\$LinkText</cite> [<a class='urllink' href='\$Url'>\$Url</a>]";
  SDV($GroupPrintHeaderFmt,'$Group.GroupPrintHeader');
  SDV($GroupPrintFooterFmt,'$Group.GroupPrintFooter');
  $GroupHeaderFmt = $GroupPrintHeaderFmt;
  $GroupFooterFmt = $GroupPrintFooterFmt;
  $DoubleBrackets["/\\[\\[mailto:($UrlPathPattern)(.*?)\\]\\]/"] = 
    "''\$2'' [mailto:\$1]";
}

?>
