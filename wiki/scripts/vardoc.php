<?php if (!defined('PmWiki')) exit();
/*  Copyright 2002-2004 Patrick R. Michaud (pmichaud@pobox.com)
    This file is part of PmWiki; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.  See pmwiki.php for full details.

    This script provides special handling for WikiWords that are
    preceded by a $, treating them as PmWiki variables to be looked up
    in the variable documentation pages if such documentation exists.
    The $VarPagesFmt variable contains a list of pages to be searched
    to build an index of the variable documentation.  This index is only
    generated once per browse request, and then only when needed.
*/

# These statements set up the default values and add $VariableName 
# links into the markup
SDV($VarPagesFmt,array('PmWiki.Variables','PmWiki.BasicVariables',
  'PmWiki.LayoutVariables','PmWiki.LinkVariables','PmWiki.EditVariables',
  'PmWiki.UploadVariables','PmWiki.OtherVariables','PmWiki.MailPosts'));
SDV($VarLinkExistsFmt,"<a class='varlink' href='\$_Url'><code class='varlink'>\$_LinkText</code></a>");
SDV($VarLinkMissingFmt,"\$_LinkText");
$DoubleBrackets["/^:\\$($WikiWordPattern):/"] = ":[[#$1]]\$$1:";
$LinkPatterns[780]["\\$$WikiWordPattern"] = 'FmtVarLink';
$InlineReplacements['/\\[\\[\\$Varindex\\]\\]/e'] = 'Keep(VarIndexList())';

# FmtVarLink(...) is called when the $LinkPattern (above) is seen,
# it returns a string based on whether a variable has been documented
function FmtVarLink($pat,$ref,$txt) {
  global $VarIndex,$VarLinkExistsFmt,$VarLinkMissingFmt;
  if (!isset($VarIndex)) { VarIndexLoad(); }
  $link = substr($ref,1);
  $rtxt = (!is_null($txt)) ? $txt : $ref;
  if (!$VarIndex[$link]['url']) 
    return str_replace('$_LinkText',$rtxt,$VarLinkMissingFmt);
  return str_replace(array('$_LinkText','$_Url'),
    array($rtxt,$VarIndex[$link]['url']),$VarLinkExistsFmt);
}

# VarIndexLoad() loads $VarIndex with the variable definitions from the 
# pages given by $VarPagesFmt 
function VarIndexLoad() {
  global $VarPagesFmt,$VarIndex,$WikiWordPattern;
  if (!isset($VarIndex)) $VarIndex=array();
  foreach($VarPagesFmt as $v) {
    $vname = FmtPageName('$PageName',$v);
    $vpage = ReadPage($v);
    if (!$vpage) continue;
    if (!preg_match_all("/\n:\\$($WikiWordPattern):/",$vpage['text'],$match))
      continue;
    foreach($match[1] as $n) {
      $VarIndex[$n]['page']=$vname;
      $VarIndex[$n]['url']=FmtPageName("\$PageUrl#$n",$vname);
    }
  }
}

# VarIndexList() generates a table of all indexed variables.
function VarIndexList() {
  global $VarIndex;
  if (!isset($VarIndex)) VarIndexLoad();
  ksort($VarIndex);
  $out = "<table><tr><th>Variable</th><th>Documented in</th></tr>\n";
  foreach($VarIndex as $v=>$a) 
    $out .= FmtPageName("<tr><td><a class='varlink' href='{$a['url']}'><code>&#036;$v</code></a></td><td><a 
      href='\$PageUrl'>\$Title</a></td></tr>\n",$a['page']);
  $out .= "</table>";
  return $out;
}

?>
