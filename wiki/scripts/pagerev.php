<?php if (!defined('PmWiki')) exit();
/*  Copyright 2004 Patrick R. Michaud (pmichaud@pobox.com)
    This file is part of PmWiki; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.  See pmwiki.php for full details.

    This script defines routines for displaying page revisions.  It
    is included by default from the stdconfig.php script.
*/

SDV($DiffShow['minor'],(@$_REQUEST['minor']!='n')?'y':'n');
SDV($DiffShow['source'],(@$_REQUEST['source']=='y')?'y':'n');
SDV($DiffMinorFmt, ($DiffShow['minor']=='y') ?
  "<a href='\$PageUrl?action=diff&amp;source=".$DiffShow['source']."&amp;minor=n'>$[Hide minor edits]</a>" :
  "<a href='\$PageUrl?action=diff&amp;source=".$DiffShow['source']."&amp;minor=y'>$[Show minor edits]</a>" );
SDV($DiffSourceFmt, ($DiffShow['source']=='y') ?
  "<a href='\$PageUrl?action=diff&amp;source=n&amp;minor=".$DiffShow['minor']."'>$[Show changes to output]</a>" :
  "<a href='\$PageUrl?action=diff&amp;source=y&amp;minor=".$DiffShow['minor']."'>$[Show changes to markup]</a>");
SDV($PageDiffFmt,"<h1 class='wikiaction'>$[\$PageName History]</h1>
  <p>$DiffMinorFmt - $DiffSourceFmt</p>
  ");
SDV($DiffStartFmt,"
      <div class='diffbox'><div class='difftime'>\$DiffTime 
        \$[by] <span class='diffauthor'>\$DiffAuthor</span></div>");
SDV($DiffDelFmt['a'],"
        <div class='difftype'>\$[Deleted line \$DiffLines:]</div>
        <div class='diffdel'>");
SDV($DiffDelFmt['c'],"
        <div class='difftype'>\$[Changed line \$DiffLines from:]</div>
        <div class='diffdel'>");
SDV($DiffAddFmt['d'],"
        <div class='difftype'>\$[Added line \$DiffLines:]</div>
        <div class='diffadd'>");
SDV($DiffAddFmt['c'],"</div>
        <div class='difftype'>$[to:]</div>
        <div class='diffadd'>");
SDV($DiffEndDelAddFmt,"</div>");
SDV($DiffEndFmt,"</div>");
SDV($DiffRestoreFmt,"
      <div class='diffrestore'><a href='\$PageUrl?action=edit&amp;restore=\$DiffId&amp;preview=y'>$[Restore]</a></div>");
SDV($DiffAuthorPageExistsFmt,"<a class='authorlink'
   href='\$ScriptUrl/\$DiffAuthorPage'>\$DiffAuthor</a>");
SDV($DiffAuthorPageMissingFmt,"\$DiffAuthor");

$HandleActions['diff']='HandleDiff';

function PrintDiff($pagename) {
  global $DiffClass,$DiffId,$DiffTime,$DiffAuthor,$TimeFmt,
    $DiffStartFmt,$DiffEndFmt,$DiffAddFmt,$DiffDelFmt,
    $DiffEndDelAddFmt,$DiffRestoreFmt,$PatchFunction,$DiffShow,$GCount,
    $DiffAuthorPage,$DiffAuthorPageExistsFmt,$DiffAuthorPageMissingFmt,
    $AuthorGroup,$DiffChangeSum;
  $page = ReadPage($pagename);
  if (!$page) return;
  Lock(0); 
  krsort($page); reset($page);
  foreach($page as $k=>$v) {
    if (!preg_match("/^diff:(\d+):(\d+):?([^:]*)/",$k,$match)) continue;
    $DiffClass = $match[3];
    if ($DiffClass=='minor' && $DiffShow['minor']!='y') continue;
    $DiffGmt = $match[1]; $DiffTime = strftime($TimeFmt,$DiffGmt); 
    $DiffAuthor = @$page["author:$DiffGmt"]; 
    if (!$DiffAuthor) @$DiffAuthor=$page["host:$DiffGmt"];
    if (!$DiffAuthor) $DiffAuthor="unknown";
    if ($a = FreeLink('{{'.$DiffAuthor.'}}')) {
      $DiffAuthorPage="$AuthorGroup/".$a['name']; $GCount=0;
      if (PageExists($DiffAuthorPage)) 
        $DiffAuthor=FmtPageName($DiffAuthorPageExistsFmt,$pagename);
      else $DiffAuthor=FmtPageName($DiffAuthorPageMissingFmt,$pagename);
    }
    $DiffChangeSum = @$page["csum:$DiffGmt"];
    $DiffId = $k; $GCount=0;
    echo FmtPageName($DiffStartFmt,$pagename);
    $difflines = explode("\n",$v."\n");
    $in=array(); $out=array(); $dtype='';
    foreach($difflines as $d) {
      if ($d>'') {
        if ($d[0]=='-' || $d[0]=='\\') continue;
        if ($d[0]=='<') { $out[]=substr($d,2); continue; }
        if ($d[0]=='>') { $in[]=substr($d,2); continue; }
      }
      if (preg_match("/^(\\d+)(,(\\d+))?([adc])\\d/",$dtype,$match)) {
        if ($match[3]>'') { $lines='lines'; $count=$match[1].'-'.$match[3]; }
        else { $lines='line'; $count=$match[1]; }
        if ($match[4]=='a' || $match[4]=='c') {
          $txt = str_replace('line',$lines,$DiffDelFmt[$match[4]]);
          $txt = FmtPageName($txt,$pagename);
          echo str_replace('$DiffLines',$count,$txt);
          if ($DiffShow['source']=='y') 
            echo "<code>",
              str_replace("\n","<br />",htmlspecialchars(join("\n",$in))),
              "</code>";
          else PrintText($pagename,join("\n",$in));
        }
        if ($match[4]=='d' || $match[4]=='c') {
          $txt = str_replace('line',$lines,$DiffAddFmt[$match[4]]);
          $txt = FmtPageName($txt,$pagename);
          echo str_replace('$DiffLines',$count,$txt);
          if ($DiffShow['source']=='y') 
            echo "<code>",
              str_replace("\n","<br />",htmlspecialchars(join("\n",$out))),
              "</code>";
          else PrintText($pagename,join("\n",$out));
        }
        echo FmtPageName($DiffEndDelAddFmt,$pagename);
      }
      $in=array(); $out=array(); $dtype=$d;
    }
    echo FmtPageName($DiffEndFmt,$pagename);
    if ($PatchFunction) echo FmtPageName($DiffRestoreFmt,$pagename);
  }
}

function HandleDiff($pagename) {
  global $DiffAccessLevel,$HandleDiffFmt,
    $PageStartFmt,$PageDiffFmt,$PageEndFmt;
  SDV($DiffAccessLevel,'read');
  $page = RetrieveAuthPage($pagename,$DiffAccessLevel);
  if (!$page) { Abort("?cannot diff $pagename"); }
  SetPageVars($pagename,$page,"$pagename History");
  SDV($HandleDiffFmt,array(&$PageStartFmt,
    &$PageDiffFmt,'function:PrintDiff',
    &$PageEndFmt));
  PrintFmt($pagename,$HandleDiffFmt);
}
