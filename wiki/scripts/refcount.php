<?php if (!defined('PmWiki')) exit();
/*  Copyright 2002-2004 Patrick R. Michaud (pmichaud@pobox.com)
    This file is part of PmWiki; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.  See pmwiki.php for full details.

    This file adds the capability to perform reference counts on
    pages in the PmWiki database.  Simply use "?action=refcount" to
    bring up the reference count form.  The output is a table
    where each row of the table contains a page name or link reference,
    the number of (non-RecentChanges) pages that contain links to the
    page, the number of RecentChanges pages with links to the page, and
    the total number of references in all pages.

    This script can be activated by placing 
	include_once("scripts/refcount.php");
    in the config.php file.
*/

SDV($PageRefCountFmt,"<h1>Reference Count Results</h1><p>");
SDV($RefCountTimeFmt," <small>%Y-%b-%d %H:%M</small>");
SDV($HandleActions['refcount'],'HandleRefCount');

function PrintRefCount() {
  global $WikiLibDirs,$WikiDir,$GroupNamePattern,$PageTitlePattern,
    $PageRefCountFmt,$WikiWordPattern,$FreeLinkPattern,$UrlPathPattern,
    $WikiPageExistsFmt, $WikiPageCreateFmt, $WikiPageCreateSpaceFmt,
    $RefCountTimeFmt,$InterMapUrls,$LinkPatterns;
  if (!isset($WikiLibDirs)) $WikiLibDirs = array($WikiDir,"wikilib.d");
  $grouplist = array('all' => ' all groups');
  foreach($WikiLibDirs as $d) {
    $dp = opendir($d);
    if (!$dp) continue;
    while (($pagename = readdir($dp))!==false) {
      if (!preg_match("/^($GroupNamePattern)\.$PageTitlePattern\$/",$pagename,
          $match)) continue;
      $pagelist[$pagename] = $pagename;
      $grouplist[$match[1]] = $match[1];  
    }
    closedir($dp);
  }
  asort($grouplist);

  $wlist = array('all','missing','existing','orphaned');
  $tlist = isset($_REQUEST['tlist']) ? $_REQUEST['tlist'] : array('all');
  $flist = isset($_REQUEST['flist']) ? $_REQUEST['flist'] : array('all');
  $whichrefs = @$_REQUEST['whichrefs'];
  $showrefs = @$_REQUEST['showrefs'];
  $submit = @$_REQUEST['submit'];

  $WikiPageExistsFmt = "<a target='_blank' href='\$PageUrl'>\$LinkText</a>";
  $WikiPageCreateFmt = 
    "\$LinkText<a target='_blank' href='\$PageUrl?action=edit'>?</a>";
  $WikiPageCreateSpaceFmt = $WikiPageCreateFmt;
  
  echo FmtPageName($PageRefCountFmt,NULL);
  echo "<form method='post'><input type='hidden' action='refcount'>
    <table cellspacing='10'><tr><td valign='top'>Show 
    <br><select name='whichrefs'>";
  foreach($wlist as $w)  
    echo "<option ",($whichrefs==$w) ? 'selected' : ''," value='$w'>$w\n";
  echo "</select></td><td valign='top'> page names in group<br>
    <select name='tlist[]' multiple size='4'>";
  foreach($grouplist as $g=>$t) 
    echo "<option ",in_array($g,$tlist) ? 'selected' : ''," value='$g'>$t\n";
  echo "</select></td><td valign='top'> referenced from pages in<br>
    <select name='flist[]' multiple size='4'>";
  foreach($grouplist as $g=>$t) 
    echo "<option ",in_array($g,$flist) ? 'selected' : ''," value='$g'>$t\n";
  echo "</select></td></tr></table>
    <p><input type='checkbox' name='showrefs' value='checked' $showrefs> 
      Display referencing pages
    <p><input type='submit' name='submit' value='Search'></form><p><hr>";
  if ($submit) {
    ksort($LinkPatterns); 
    foreach($LinkPatterns as $n=>$a)
      foreach($a as $p=>$r) $linkpats[$p]=$r;
    foreach($pagelist as $pagename) { 
      $ref=array(); 
      $page = ReadPage($pagename);  Lock(0);
      if (!$page) continue;
      $tref[$pagename]['time'] = $page['time'];
      if (!in_array('all',$flist) && 
          !in_array(FmtPageName('$Group',$pagename),$flist)) continue;
      $text = preg_replace("/\\[\\=.*?\\=\\]/s",' ',$page['text']);
      foreach($linkpats as $p=>$r)
        $text = preg_replace("/\\[\\[($p)(\\s*.*?)?\\]\\]/",'$1',$text);
      $text = preg_replace("/\\w+:($UrlPathPattern)/",' ',$text);
      $text = preg_replace("/\\$$WikiWordPattern/",' ',$text);
      $text = preg_replace("/\\[\\[#[A-Za-z][-.:\\w]*?\\]\\]/",' ',$text);
      foreach($InterMapUrls as $mapid=>$mapurl) {
        $text = preg_replace("/\\b$mapid:($UrlPathPattern)/",' ',$text);
      }
      if (!preg_match_all("/(($GroupNamePattern)[\\/.])?(($WikiWordPattern)|($FreeLinkPattern))/",$text,$match)) continue;
      for($i=0;$i<count($match[0]);$i++) {
        @$ref[FmtWikiLink('',$match[0][$i],NULL,'PageName',$pagename)]++;
      }
      $rc = preg_match('/RecentChanges$/',$pagename);
      foreach($ref as $r=>$c) {
        @$tref[$r]['tot'] += $c;
        if ($rc) @$tref[$r]['rc']++;
        else { @$tref[$r]['page']++; @$pref[$r][$pagename]++; }
      }
    }
    uasort($tref,'RefCountCmp');
    echo "<table >
      <tr><th></th><th colspan='2'>Referring pages</th><th>Total</th></tr>
      <tr><th>Name / Time</th><th>All</th><th>R.C.</th><th>Refs</th></tr>";
    reset($tref);
    foreach($tref as $p=>$c) {
      if (!in_array('all',$tlist) &&
          !in_array(FmtPageName('$Group',$p),$tlist)) continue;
      if ($whichrefs=='missing' && PageExists($p)) continue;
      elseif ($whichrefs=='existing' && !PageExists($p)) continue;
      elseif ($whichrefs=='orphaned' && 
        (@$tref[$p]['page']>0 || !PageExists($p))) continue;
      echo "<tr><td valign='top'>",FmtWikiLink('',$p,NULL);
      if (@$tref[$p]['time']) echo strftime($RefCountTimeFmt,$tref[$p]['time']);
      if ($showrefs && is_array(@$pref[$p])) {
        foreach($pref[$p] as $pr=>$pc) echo "<dd>",FmtWikiLink('',$pr,NULL);
      }
      echo "</td>";
      echo "<td align='center' valign='top'>",
        FmtPageName("<a href='\$PageUrl?action=search&amp;text=\$Title_'
          target='_blank'>",$p),@$tref[$p]['page']+0,"</a></td>";
      echo "<td align='center' valign='top'>",@$tref[$p]['rc'],"</td>";
      echo "<td align='center' valign='top'>",@$tref[$p]['tot'],"</td>";
      echo "</tr>";
    }
    echo "</table>";
  }
  EndHTML();
}

function RefCountCmp($ua,$ub) {
  if (@($ua['page']!=$ub['page'])) return @($ub['page']-$ua['page']);
  if (@($ua['rc']!=$ub['rc'])) return @($ub['rc']-$ua['rc']);
  if (@($ua['tot']!=$ub['tot'])) return @($ub['tot']-$ua['tot']);
  return @($ub['time']-$ua['time']);
}

function HandleRefCount($pagename) {
  global $HandleRefCountFmt,$PageStartFmt,$PageEndFmt;
  $page = array('timefmt'=>@$GLOBALS['CurrentTime'], 
    'author'=>@$GLOBALS['Author']);
  SetPageVars($pagename,$page,"Reference Counts");
  SDV($HandleRefCountFmt,array(&$PageStartFmt,
    'function:PrintRefCount',&$PageEndFmt));
  PrintFmt($pagename,$HandleRefCountFmt);
}
  
?>
