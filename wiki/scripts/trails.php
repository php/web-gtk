<?php if (!defined('PmWiki')) exit();
/*  Copyright 2002-2004 Patrick R. Michaud (pmichaud@pobox.com)
    This file is part of PmWiki; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.  See pmwiki.php for full details.

    This script enables markup of the form <<|TrailPage|>> to be 
    used to build "trails" through wiki documents.

    This feature is automatically included from stdconfig.php unless
    disabled by $EnableWikiTrails = 0; .  To explicitly include this feature,
    execute
   	include_once("scripts/trails.php");
    from config.php somewhere.

    Once enabled, the <<|TrailPage|>> markup is replaced with
    << PrevPage | TrailPage | NextPage >> on output.  TrailPage should
    contain either a bullet or number list defining the sequence of pages
    in the "trail".

    The ^|TrailPage|^ markup uses the depth of the bullets to display
    the ancestry of the TrailPage to the current one.  The <|TrailPage|> 
    markup is like <<|TrailPage|>> except that "< PrevPage |" and 
    "| NextPage >" are omitted if at the beginning or end of the 
    trail respectively.  Thanks to John Rankin for contributing these
    markups and the original suggestion for WikiTrails.
*/

$TrailLinkPattern = 
  "(?:($GroupNamePattern)([\\/.]))?(($WikiWordPattern)|($FreeLinkPattern))";
$DoubleBrackets["/&lt;&lt;\\|($TrailLinkPattern)\\|&gt;&gt;/e"] 
  = 'MakeTrailStop("$1");';
$DoubleBrackets["/&lt;\\|($TrailLinkPattern)\\|&gt;/e"]
  = 'MakeTrailStopB("$1");';
$DoubleBrackets["/\\^\\|($TrailLinkPattern)\\|\\^/e"] 
  = 'MakeTrailPath("$1");';
SDV($TrailPathSep,' | ');


function MakeTrailStop($link) {
  global $pagename;
  $t = ReadTrail($link);
  $prev = ''; $next = '';
  for($i=0;$i<count($t);$i++) {
    if ($t[$i]['name']==$pagename) {
      if ($i>0) $prev = $t[$i-1]['link'];
      if ($i+1<count($t)) $next = $t[$i+1]['link'];
    }
  }
  return 
    "<span class='wikitrail'>&lt;&lt; $prev | $link | $next &gt;&gt;</span>";
}

function MakeTrailStopB($link) {
  global $pagename;
  $t = ReadTrail($link);
  $prev = ''; $next = '';
  for($i=0;$i<count($t);$i++) {
    if ($t[$i]['name']==$pagename) {
      if ($i>0) $prev = '&lt; '.$t[$i-1]['link'].' | ';
      if ($i+1<count($t)) $next = ' | '.$t[$i+1]['link'].' &gt;';
    }
  }
  return "<span class='wikitrail'>$prev$link$next</span>";
}

function MakeTrailPath($link) {
  global $pagename,$TrailPathSep;
  $t = ReadTrail($link);
  for($i=0;$i<count($t);$i++) {
    if ($t[$i]['name']==$pagename) {
      while ($t[$i]['depth']>0) {
        $crumbs = $TrailPathSep.$t[$i]['link'].$crumbs;
        $i = $t[$i]['parent'];
      }
      return "<span class='wikitrail'>$link$crumbs</span>";
    }
  }
  return $link;
}

function ReadTrail($link) {
  global $pagename,$TrailLinkPattern;
  $trailname = FmtWikiLink('',$link,NULL,'PageName');
  $trailpage = ReadPage($trailname);
  if ($trailpage) {
    $trailgroup = FmtPageName('$Group',$trailname);
    $n = 0;
    foreach(explode("\n",$trailpage['text']) as $x) {
      if (preg_match("/([#*]+)\\s*(\\[\\[)?($TrailLinkPattern)/",$x,$match)) {
        $t[$n]['depth'] = $depth = strlen($match[1]); 
        $link = $match[3];
        if (!preg_match('![./]!',$link)) $link="$trailgroup/$link";
        $t[$n]['link'] = $link;
        $t[$n]['name'] = FmtWikiLink('',$link,NULL,'PageName',$trailname);
        if ($match[2]>'' && 
            preg_match("/^[#*]+\\s*\\[\\[($TrailLinkPattern)((?:\\s.*?)?\\]\\])/",$x,$dbm))
          $t[$n]['link'] = "[[$link".array_pop($dbm);
        for($i=$depth;$i<10;$i++) $d[$i] = $n;
        if ($depth>1) $t[$n]['parent']=@$d[$depth-1];
        $n++;
      } 
    }
  }
  return $t;
}

?>
