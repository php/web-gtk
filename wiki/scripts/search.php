<?php if (!defined('PmWiki')) exit();
/*  Copyright 2002-2004 Patrick R. Michaud (pmichaud@pobox.com)
    This file is part of PmWiki; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.  See pmwiki.php for full details.

    This script provides search capabilities for PmWiki.  It is included
    by default from the stdconfig.php script unless disabled by
    $EnableSearch=0; in config.php.
*/

XLSDV('en',array(
  'SearchFor' => 'Results of searching for <em>$Needle</em>:',
  'SearchFound' => 
    '$MatchCount pages found out of $MatchSearched pages searched.'
));

SDV($HandleActions['search'],'HandleSearch');
if (isset($EnablePathInfo) && !$EnablePathInfo) 
  SDV($SearchTagFmt,"<form class='wikisearch' action='\$ScriptUrl' 
    method='get'><input type='hidden' name='pagename' 
    value='$[Main/SearchWiki]'><input class='wikisearchbox' type='text' 
    name='text' value='\$Needle' size='40' /><input class='wikisearchbutton'
    type='submit' value='$[Search]' /></form>");
SDV($SearchTagFmt,"<form class='wikisearch' 
  action='\$ScriptUrl/$[Main/SearchWiki]' method='get'><input 
  class='wikisearchbox' type='text' name='text' value='\$Needle' 
  size='40' /><input class='wikisearchbutton' type='submit' 
  value='$[Search]' /></form>");
SDV($SearchResultsFmt,"$[SearchFor]
  $HTMLVSpace<dl class='wikisearch'>\$MatchList</dl>
  $HTMLVSpace$[SearchFound]$HTMLVSpace");
SDV($PageSearchFmt,
  "<h1 class='wikiaction'>$[Search Results]</h1>\$SearchResults");
SDV($SearchListItemFmt,'<dd><a href="$PageUrl">$Title</a></dd>');
SDV($SearchListGroupFmt,'<dt><a href="$ScriptUrl/$Group">$Group</a> /</dt>');
SDV($InlineReplacements['/\\[\\[\\$Search\\]\\]/e'],
  "FmtPageName(\$GLOBALS['SearchTagFmt'],\$pagename)");
SDV($InlineReplacements['/\\[\\[\\$Searchresults\\]\\]/e'],
  "Keep(SearchResults(\$pagename))");

foreach(array('group'=>'SearchGroup','text'=>'Needle') as $k=>$v) {
  $Search[$k]='';
  if (isset($_POST[$k])) $Search[$k]=stripmagic($_POST[$k]);
  if (isset($_GET[$k])) $Search[$k]=stripmagic($_GET[$k]);
}
if (preg_match("!^($GroupNamePattern)?/!i",$Search['text'],$match))
  $Search['group'] = $match[1]; 
if ($action!='edit') {
  $Needle = str_replace('$','&#036;',htmlentities($Search['text'],ENT_QUOTES));
  $SearchGroup = htmlentities($Search['group'],ENT_QUOTES);
}

function SearchResults($pagename) {
  global $Search,$WikiLibDirs,$GroupNamePattern,$SearchExcludePatterns,
    $SearchListItemFmt,$SearchListGroupFmt,$SearchResultsFmt,
    $GroupFreeLinkPattern,$PageNameSpace;
  if (!$Search['text']) return "";
  $matches = array(); $matchsearched = 0;
  $group = $Search['group'];
  $terms = preg_replace("!^($GroupNamePattern)?/!i","",$Search['text']);
  $terms = preg_split('/((?<!\\S)[-+]?[\'"].*?[\'"](?!\\S)|\\S+)/',$terms,-1,
    PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_NO_EMPTY);
  $excl = array(); $incl = array();
  foreach($terms as $t) {
    if (trim($t)=="") continue;
    preg_match('/^([-+]?)([\'"]?)(.+?)\\2$/',$t,$match);
    if ($match[1]=='-') $excl[] = $match[3];
    else $incl[] = $match[3];
  }
  $dirlist = (array)$WikiLibDirs;
  while (count($dirlist)>0) {
    $dir = array_shift($dirlist);
    $dfp = opendir($dir); if (!$dfp) continue;
    while (($pagefile=readdir($dfp))!=false) {
      if (substr($pagefile,0,1)=='.') continue;
      if (is_dir("$dir/$pagefile")) 
        { array_push($dirlist,"$dir/$pagefile"); continue; }
      if (@$seen[$pagefile]++) continue;
      if ($group && strcasecmp(FmtPageName('$Group',$pagefile),$group)!=0) 
        continue;
      if (isset($SearchExcludePatterns))
        foreach((array)$SearchExcludePatterns as $t) 
          if (preg_match($t,$pagefile)) continue 2;
      $page = ReadPage($pagefile);  Lock(0);  if (!$page) continue;
      $matchsearched++;
      $text = $pagefile."\n".preg_replace("/$GroupFreeLinkPattern/e","'$0'.preg_replace('/\\s+/','$PageNameSpace',ucwords('$3'.'$4')).' '.'$3'.'$5'",$page['text']);
      foreach($excl as $t) if (stristr($text,$t)) continue 2;
      foreach($incl as $t) if (!stristr($text,$t)) continue 2;
      $matches[] = $pagefile; 
    }
    closedir($dfp);
  }
  sort($matches); reset($matches);
  $MatchList = array();
  foreach($matches as $pagefile) { 
    $pgroup = FmtPageName($SearchListGroupFmt,$pagefile);
    if ($pgroup!=@$lgroup) {
      $MatchList[] = $pgroup;
      $lgroup = $pgroup;
    }
    $MatchList[] = FmtPageName($SearchListItemFmt,$pagefile); 
  }
  $GLOBALS['MatchList'] = join('',$MatchList);
  $GLOBALS['MatchCount'] = count($matches);
  $GLOBALS['MatchSearched'] = $matchsearched;
  $GLOBALS['SearchIncl'] = $incl;
  $GLOBALS['SearchExcl'] = $excl; 
  $GLOBALS['GCount'] = 0;
  return FmtPageName($SearchResultsFmt,$pagename);
}

function HandleSearch($pagename) {
  global $HandleSearchFmt,$SearchResults,$CurrentTime;
  global $PageStartFmt,$PageSearchFmt,$PageEndFmt;
  $SearchResults = SearchResults($pagename); 
  $GLOBALS['LastModified'] = $CurrentTime;
  $GLOBALS['LastModifiedBy'] = @$Author;
  $GLOBALS['HTMLTitle'] = 'Search Results';
  $GLOBALS['GCount'] = 0;
  SDV($HandleSearchFmt,array(&$PageStartFmt, &$PageSearchFmt, &$PageEndFmt));
  PrintFmt($pagename,$HandleSearchFmt);
}

?>
