<?php if (!defined('PmWiki')) exit();
/*  Copyright 2004 Patrick R. Michaud (pmichaud@pobox.com)
    This file is part of PmWiki; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.  See pmwiki.php for full details.

    This file attempts to provide 0.5 layout compatibility for PmWiki 
    version 0.6 by restoring the previous definitions of $PageHeaderFmt,
    $PageEditFmt, etc.

    To use this file, simply place

            include_once("scripts/layout-0.5.php");

    at the very beginning of your local/config.php file.
*/

$EnableStdLayout = 0;					# turn off stdlayout
$EnableTemplateLayout = 0;                              # turn off tlayout

$ScriptDir = preg_replace("#/[^/]*\$#","",$ScriptUrl,1);
$WikiImgUrl = "$ScriptDir/pub/pmwiki-32.gif";
$BodyWidth = 600;
$BodyLeft = 20;
$HTMLHeaderFmt = "<style type='text/css'>
  HR { text-align:left; }
  .wikiheader { font-size:32px; font-weight:bold; }
  .wikiops, .wikifooter { font-size:13px; }
  .wikibody { margin-left:\$BodyLeftpx; width:\$BodyWidthpx; }
  .diffbox { border:1px #999999 solid; }
  .diffauthor { font-weight:bold; }
  .difftime
    { font-family:verdana,sans-serif; font-size:66%; background-color:#dddddd; }
  .difftype
    { font-family:verdana,sans-serif; font-size:66%; font-weight:bold; }
  .diffadd
    { border-left:5px #99ff99 solid; padding-left:5px; }
  .diffdel
    { border-left:5px #ffff99 solid; padding-left:5px; }
  .diffrestore
    { font-family:verdana,sans-serif; font-size:66%; margin:1.5em 0px; }
</style>";
$HTMLBodyFmt = "</head><body bgcolor='#ffffff'><div class='wikibody'>";
$HTMLStartFmt = array('headers:',&$HTMLDoctypeFmt,&$HTMLTitleFmt,
  &$HTMLHeaderFmt,&$HTMLBodyFmt);
$HTMLEndFmt = "</div></body></html>";
$PageNameFmt = '$Group.$Title_';
$PageFileFmt = '$PageName';
$PageUrlFmt = '$ScriptUrl/$Group/$Title_';
$PageHeaderFmt = "
  <table width='\$BodyWidth' cellpadding='0' cellspacing='0' border='0'>
  <tr><td valign='bottom' align='left' width='10%'>\$WikiImg&nbsp;&nbsp;</td>
    <td valign='bottom' align='left'><a href='\$ScriptUrl/\$Group'>\$Group</a> /<br />
      <span class='wikiheader'><a href='\$PageUrl?action=search&amp;text=\$Title_'>\$Title</a></span></td>
    <td valign='bottom' align='right' class='wikiops'>
      <a href='\$ScriptUrl/$[Main/SearchWiki]'>$[SearchWiki]</a><br />
      <a href='\$ScriptUrl/$[\$Group/RecentChanges]'>\$Group.$[RecentChanges]</a><br />
      <a href='\$PageUrl?action=edit'>$[Edit Page]</a><br />
      <a href='\$PageUrl?action=diff'>$[Page Revisions]</a></td>
   </tr></table><hr /><p />";
$PageTitleFmt = '';
$PageRedirectFmt = "<i>($[redirected from] <a href='\$PageUrl?action=edit'>\$PageName</a>)</i><p />\n";
$PageFooterFmt = "<hr /><small>
  <a href='\$PageUrl?action=edit'>$[Edit Page]</a> - 
  <a href='\$PageUrl?action=diff'>$[Page Revisions]</a> -
  <a href='\$ScriptUrl/$[PmWiki/WikiHelp]'>$[WikiHelp]</a> -
  <a href='\$ScriptUrl/$[Main/SearchWiki]'>$[SearchWiki]</a> -
  <a href='\$ScriptUrl/$[\$Group/RecentChanges]'>$[RecentChanges]</a><br />
  $[Page last modified on \$LastModified]</small>";
$PageEditFmt = "<a id='top' name='top'></a><h1>Editing \$PageName</h1>
  <form action='\$PageUrl' method='post'>
  <input type='hidden' name='pagename' value='\$PageName' />
  <input type='hidden' name='action' value='edit' />
  <textarea name='text' rows='25' cols='80'
    onkeydown='if (event.keyCode == 27) event.returnValue=false;'
    >\$Text</textarea><br />
  <input type='submit' name='post' value=' $[Save] ' />
  <input type='submit' name='preview' value=' $[Preview] ' />
  <input type='reset' value=' $[Reset] ' />
  </form>";
$PagePreviewFmt = array(
  "function:ProcessTextDirectives",
  "<h2>Preview \$PageName</h2><b>Page is unsaved</b><hr /><p />",
  "function:PrintText",
  "<hr /><b>End of preview -- remember to save</b>
   <br /><a href='#top'>$[Top]</a>");
$PageDiffFmt = "<h1><a href='\$PageUrl'>\$PageName</a> $[Revisions]</h1>";
$PageDiffFootFmt = "<p /><hr />$[Back to] <a href='\$PageUrl'>\$PageName</a>";
$PageAttrFmt = "<h1>$[\$PageName Attributes]</h1>
    <p>Enter new attributes for this page below.  Leaving a field blank
    will leave the attribute unchanged.  To clear an attribute, enter 
    'clear'.</p>";
$PageStartFmt = &$HTMLStartFmt;
$PageEndFmt = &$HTMLEndFmt;
$HandleBrowseFmt = array(&$HTMLStartFmt,&$PageHeaderFmt,&$PageTitleFmt,
  &$PageRedirectFmt,"function:PrintText",&$PageFooterFmt,&$HTMLEndFmt);
$HandleEditFmt = array(&$HTMLStartFmt,&$PageEditFmt,
  "wiki:$[PmWiki.EditQuickReference]",&$PagePreviewFmt,&$HTMLEndFmt);
#$HandleDiffFmt = array(&$HTMLStartFmt,&$PageDiffFmt,'function:PrintDiff',
#  &$HTMLEndFmt);

$WikiPageExistsFmt = "<a href='\$PageUrl\$Fragment'>\$LinkText</a>";
$WikiPageCreateFmt = 
  "\$LinkText<a href='\$PageUrl?action=edit'>?</a>";
$WikiPageCreateSpaceFmt =
  "\$LinkText<a href='\$PageUrl?action=edit'>?</a>";
$UrlLinkFmt = "<a href='\$Url'>\$LinkText</a>";
$UrlImgFmt = "<img src='\$Url' border='0' alt='' img>";

$RecentChanges = array(
  "Main.AllRecentChanges"=>'* $Group.$Tlink . . . $CurrentTime',
  '$Group.RecentChanges'=>'* $Group/$Tlink . . . $CurrentTime');
SDV($WikiImg,"<a href='\$ScriptUrl'><img src='$WikiImgUrl' alt='$WikiTitle'
  border='0' /></a>");

?>
