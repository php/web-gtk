<?php if (!defined('PmWiki')) exit();
/*  Copyright 2004 Patrick R. Michaud (pmichaud@pobox.com)
    This file is part of PmWiki; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.  See pmwiki.php for full details.

    This module sets the values of $PageStartFmt and $PageEndFmt,
    used by various modules to generate output pages.  The general
    mechanism for page output is that a function such as HandleBrowse
    or HandleEdit will output the value of $PageStartFmt, followed
    by the action-specific content, followed by $PageEndFmt.  The
    HTML comment <!--PageText--> in the template file denotes the
    location where $PageStart ends and $PageEnd begins.  The
    HTML comment <!--HeaderText--> denotes where the contents of
    $HTMLHeaderFmt should be generated.

    The template file may also contain HTML comments of the form
    <!--PageHeaderFmt-->, <!--PageFooterFmt-->, etc.  These
    have the side effect of putting the strings that follow into
    the variables $PageHeaderFmt, $PageFooterFmt, etc. and then
    placing references to those variables into $PageStartFmt or 
    $PageEndFmt.  This allows HandleBrowse and other functions to
    selectively disable headers and footers by setting the corresponding
    variable to the empty string.

    Versions 0.6.1 and 0.6.2 made use of an $HTMLHeaders variable
    that is now deprecated, use <!--HeaderText--> and $HTMLHeaderFmt
    instead.
*/

SDV($FarmPubDirUrl,$PubDirUrl);
SDV($PageTemplateFmt,"$FarmD/pub/skins/pmwiki/pmwiki.tmpl");
SDV($PageLogoUrl,"$FarmPubDirUrl/skins/pmwiki/pmwiki-32.gif");
SDV($PageLogoFmt,"<div id='wikilogo'><a href='$ScriptUrl'><img 
  src='$PageLogoUrl' alt='$WikiTitle' border='0' /></a></div>");
SDV($PageCSSListFmt,array(
  'pub/css/local.css' => '$PubDirUrl/css/local.css',
  'pub/css/$Group.css' => '$PubDirUrl/css/$Group.css',
  'pub/css/$Group.$Title_.css' => '$PubDirUrl/css/$Group.$Title_.css'));

foreach((array)$PageCSSListFmt as $k=>$v) 
  if (file_exists(FmtPageName($k,$pagename))) 
    $HTMLHeaderFmt[] = "<link rel='stylesheet' type='text/css' href='$v' />\n";

if ($PageTemplateFmt) LoadPageTemplate($PageTemplateFmt);

function LoadPageTemplate($tfilefmt) {
  global $PageStartFmt,$PageEndFmt,$BasicLayoutVars,$HTMLHeaderFmt;
  SDV($BasicLayoutVars,array('HeaderText','PageHeaderFmt','PageLeftFmt',
    'PageTitleFmt', 'PageText','PageRightFmt','PageFooterFmt'));

  $k = str_replace('$HTMLHeaders','<!--HeaderText-->',           # deprecated
    implode('',file(FmtPageName($tfilefmt,$pagename))));
  $sect = preg_split('#[[<]!--(/?Page[A-Za-z]+Fmt|PageText|HeaderText)--[]>]#',
    $k,0,PREG_SPLIT_DELIM_CAPTURE);
  $PageStartFmt = array_merge(array('headers:'),
    preg_split('/[[<]!--((?:wiki|file|function):.*?)--[]>]/',array_shift($sect),
      0,PREG_SPLIT_DELIM_CAPTURE));
  $PageEndFmt = array();
  $ps = 'PageStartFmt';
  while (count($sect)>0) {
    $k = array_shift($sect);
    $v = preg_split('/[[<]!--((?:wiki|file|function):.*?)--[]>]/',
      array_shift($sect),0,PREG_SPLIT_DELIM_CAPTURE);
    if (substr($k,0,1)=='/') {
      $GLOBALS[$ps][] = "<!--$k-->";
      $GLOBALS[$ps][] = (count($v)>1) ? $v : $v[0];
      continue;
    } 
    $GLOBALS[$k] = (count($v)>1) ? $v : $v[0];
    if (in_array($k,$BasicLayoutVars)) {
      $GLOBALS[$ps][] = "<!--$k-->";
      if ($k=='PageText') { $ps = 'PageEndFmt'; }
      if ($k=='HeaderText') $GLOBALS[$ps][] = &$HTMLHeaderFmt;
      $GLOBALS[$ps][] =& $GLOBALS[$k];
    }
  }
  array_push($PageStartFmt,"\n<div id='wikitext'>\n");
  array_unshift($PageEndFmt,'</div>');
}

?>
