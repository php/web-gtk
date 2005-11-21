<?php
/*
    PmWiki
    Copyright 2001-2004 Patrick R. Michaud 
    pmichaud@pobox.com
    http://www.pmichaud.com/

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
if (ini_get('register_globals')) {
  foreach($_REQUEST as $k=>$v) { unset(${$k}); }
}
$UnsafeGlobals = array_keys($GLOBALS);
SDV($FarmD,dirname(__FILE__));
define('PmWiki',1);
@include_once("$FarmD/scripts/version.php");
$WikiTitle = "PmWiki";
$DefaultGroup = "Main";
$DefaultTitle = "HomePage";
$ScriptUrl = 'http://'.htmlspecialchars($_SERVER['HTTP_HOST']);
$ScriptUrl .= htmlspecialchars($_SERVER['SCRIPT_NAME']);
$PubDirUrl = preg_replace("#/[^/]*\$#","/pub",$ScriptUrl,1);
$DiffKeepDays = 3650;
$WikiDir = "wiki.d";
$WikiLibDirs = array(&$WikiDir,"$FarmD/wikilib.d");
$DeleteKeyWord = "delete";
$RedirectDelay = 0;
$AuthFunction = 'BasicAuth';
$AsSpacedFunction = 'AsSpaced';
$AllowPassword = 'nopass';
$DiffFunction = 'Diff';
$SysDiffCmd = '/usr/bin/diff';
$PatchFunction = 'Patch';
$DefaultPasswords = array('admin'=>'*','attr'=>'','edit'=>'','read'=>'');
$AuthRealmFmt = '$WikiTitle';
$AuthDeniedFmt = 'A valid password is required to access this feature.';
$DefaultPageTextFmt = '$[Describe $Tlink here.]';
$PageRedirectFmt = "<i>($[redirected from] <a href='\$PageUrl?action=edit'>\$PageName</a>)</i><p />\n";
$IncludeBadAnchorFmt = "include:\$Group.\$Tlink - #\$BadAnchor \$[not found]\n";
$PageEditFmt=array("
  <div id='wikiedit'>
  <a id='top' name='top'></a><h1 class='wikiaction'>$[Editing \$PageName]</h1>
  <form action='\$PageUrl' method='post'>
  <input type='hidden' name='pagename' value='\$PageName' />
  <input type='hidden' name='action' value='edit' />
  \$EditMessageFmt
  <textarea name='text' rows='25' cols='60'
    onkeydown='if (event.keyCode == 27) event.returnValue=false;'
    >\$Text</textarea><br />
  $[Author]: <input type='text' name='author' value='\$Author' />
  <input type='checkbox' name='diffclass' value='minor' \$DiffClassMinor />
    $[This is a minor edit]<br />
  <input type='submit' name='post' value=' $[Save] ' />
  <input type='submit' name='preview' value=' $[Preview] ' />
  <input type='reset' value=' $[Reset] ' />
  </form></div>",'wiki:$[PmWiki.EditQuickReference]');
$EditMessageFmt='';
$PagePreviewFmt=array(
  "function:ProcessTextDirectives",
  "<h2 class='wikiaction'>Preview \$PageName</h2>
    <b>Page is unsaved</b><hr /><p></p>",
  "function:PrintText",
  "<hr /><b>End of preview -- remember to save</b>
   <br /><a href='#top'>$[Top]</a>");
$PageAttrFmt="<h1 class='wikiaction'>$[\$PageName Attributes]</h1>
  <p>Enter new attributes for this page below.  Leaving a field blank
  will leave the attribute unchanged.  To clear an attribute, enter
  'clear'.</p>";

$GroupHeaderFmt = '$Group.GroupHeader';
$GroupFooterFmt = '$Group.GroupFooter';
$GroupAttributesFmt = '$Group.GroupAttributes';
$TimeFmt = "%B %d, %Y, at %I:%M %p";
$SpaceWikiWordsString = ' ';
$PageNameFmt = '$Group.$Title_';
$PageFileFmt = '$PageName';
$PageUrlFmt = '$ScriptUrl/$Group/$Title_';
$HTTPHeaders=array(
  "Expires: Tue, 01 Jan 2002 00:00:00 GMT",
  "Last-Modified: ".gmstrftime('%a, %d %b %Y %H:%M:%S GMT'),
  "Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0",
  "Pragma: no-cache",
  "Content-Type: text/html; charset=iso-8859-1;");
$HTMLDoctypeFmt = 
  "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" 
    \"http://www.w3.org/TR/html40/loose.dtd\">
<html><head>\n";
$HTMLTitleFmt = "  <title>\$WikiTitle - \$HTMLTitle</title>\n";
$HTMLHeaders = '';
$HTMLHeaderFmt = array(&$HTMLHeaders);
$HTMLBodyFmt = "</head>\n<body>";
$HTMLStartFmt = array('headers:',&$HTMLDoctypeFmt,&$HTMLHeaderFmt,
  &$HTMLTitleFmt,&$HTMLBodyFmt);
$HTMLEndFmt = "\n</body>\n</html>";
$PageStartFmt = array(&$HTMLStartFmt,"\n<div id='wikitext'>\n");
$PageEndFmt = array('</div>',&$HTMLEndFmt);
$HTMLVSpace = "<p></p>";
$HTMLLineBreak = '';

$XLLangs = array('en');

$FmtWikiLink = 'FmtWikiLink';
$FmtUrlLink = 'FmtUrlLink';
$WikiWordPagePathFmt = array('$Group.$1','$1.$1');
$WikiPageExistsFmt = "<a class='wikilink' href='\$PageUrl\$Fragment'>\$LinkText</a>";
$WikiPageCreateFmt = 
  "<span class='createlink'>\$LinkText</span><a class='createlink' href='\$PageUrl?action=edit'>?</a>";
$WikiWordCountMax = 1000000;
$WikiWordCount['PmWiki'] = 1;
$UrlLinkFmt = "<a class='urllink' href='\$Url'>\$LinkText</a>";
$UrlImgFmt = "<img src='\$Url' border='0' alt='' img>";
$GroupNamePattern="[[:upper:]][[:alnum:]]+";
$WikiWordPattern="[[:upper:]][[:alnum:]]*(?:[[:upper:]][[:lower:]0-9]|[[:lower:]0-9][[:upper:]])[[:alnum:]]*";
$GroupFreeLinkPattern="{{(?>(?:($GroupNamePattern)([.\\/]))?([[:alpha:]][[:alnum:]]*(?:(?:[\\s_]*|-)[[:alnum:]]+)*)(?:\\|((?:(?:[\\s_]*|-)[[:alnum:]])*))?)}}((?:-?[[:alnum:]]+)*)";                                         # deprecated 0.6
$FreeLinkPattern = $GroupFreeLinkPattern;
$FragmentPattern="#([A-Za-z][-.:\\w]*)";
$PageTitlePattern="[[:upper:]][[:alnum:]]*(?:-[[:alnum:]]+)*";
$UrlPathPattern="[^\\s<>[\\]\"\'()`|^]*[^\\s<>[\\]\"\'()`|^,.?]";
$UrlMethodPattern="http|ftp|news|file|gopher|nap|https";
$ImgExtPattern="\\.(gif|jpg|jpeg|png)";
$InterMapFiles=array("$FarmD/scripts/intermap.txt","$FarmD/local/farmmap.txt",
  'localmap.txt', 'local/localmap.txt');
$LinkPatterns=array();

$PostFields = array('text');
$RCDelimPattern = ' \\. ';
$RecentChanges = array(
  'Main.AllRecentChanges'=>'* $Group.$Tlink . . . $CurrentTime by $AuthorLink',
  '$Group.RecentChanges'=>'* $Group/$Tlink . . . $CurrentTime by $AuthorLink');
$BrowseDirectives = array(
  '[[spacewikiwords]]' => '$GLOBALS["SpaceWikiWords"]=1;',
  '[[noheader]]' => '$GLOBALS["PageHeaderFmt"]="";',
  '[[notitle]]' => '$GLOBALS["PageTitleFmt"]="";',
  '[[nofooter]]' => '$GLOBALS["PageFooterFmt"]="";',
  '[[nogroupheader]]' => '', '[[nogroupfooter]]' => '');
$DoubleBrackets = array('[[$Group]]'=>'$Group', '[[$Title]]'=>'$Title',
  '[[$Groupspaced]]'=>'$Groupspaced','[[$Titlespaced]]'=>'$Titlespaced',
  '[[$Tlink]]'=>'$Tlink',
  '[[$LastModifiedBy]]'=>'$LastModifiedBy',
  '[[$LastModifiedHost]]'=>'$LastModifiedHost',
  '[[$LastModified]]'=>'$LastModified',
  '[[$Author]]'=>'$Author',
  '[[$Version]]'=>'$Version',
  '[[$DefaultGroup]]'=>'$DefaultGroup',
  '[[$Edit' => '[[$PageUrl?action=edit ',
  '[[$Diff' => '[[$PageUrl?action=diff ');
$InlineReplacements = array(
  "/'''''(.*?)'''''/" => "<em><strong>\$1</strong></em>",
  "/'''(.*?)'''/" => "<strong>\$1</strong>",
  "/''(.*?)''/" => "<em>\$1</em>",
  "/@@(.*?)@@/" => "<code>\$1</code>",
  "/\\[\\[&lt;&lt;\\]\\]/" => "<br clear='all' />",
  "/\\[(\\++)(.*?)\\1\\]/e" =>
    "'<span style=\'font-size:'.(round(pow(1.2,strlen('$1'))*100,0)).'%\'>'.str_replace('\\\"','\"','$2').'</span>'",
  "/\\[(-+)(.*?)\\1\\]/e" =>
    "'<span style=\'font-size:'.(round(pow(5/6,strlen('$1'))*100,0)).'%\'>'.str_replace('\\\"','\"','$2').'</span>'",
  "/^----+/" => "<hr />",
  "/&amp;([A-Za-z0-9]+;|#\d+;|#[xX][A-Fa-f0-9]+;)/" => "&\$1");
$PageAttributes = array(
  'passwdread' => '$[Set new read password:]',
  'passwdedit' => '$[Set new edit password:]',
  'passwdattr' => '$[Set new attribute password:]');
$HandleActions = array(
  'edit' => 'HandleEdit', 'post' => 'HandlePost',
  'attr' => 'HandleAttr', 'postattr' => 'HandlePostAttr',
  'source' => 'HandleSource');
$WikiStylePattern = '%%|%[A-Za-z][-,=:#\\w\\s]*%';
$WikiStyleTags = array(
  'color' => array( 'style' => 'color:$value; ', 
                    'a' => 'style=\'color:$value\' '), 
  'bgcolor' => array( 'style' => 'background-color:$value; '),
  'font-size' => array( 'style' => 'font-size:$value; '),
  'font-family' => array( 'style' => 'font-family:$value; '),
  'font-style' => array( 'style' => 'font-style:$value; '),
  'font-weight' => array( 'style' => 'font-weight:$value; '),
  'text-decoration' => array( 'style' => 'text-decoration:$value; '),
  'class' => array( 'class' => 'class=\'$value\''),
  'target' => array( 'a' => 'target=\'$value\' '),
  'rel' => array('a' => 'rel=\'$value\' '),
  'hspace' => array( 'img' => 'hspace=\'$value\' '),
  'vspace' => array( 'img' => 'vspace=\'$value\' '),
  'width' => array( 'img' => 'width=\'$value\' '),
  'height' => array( 'img' => 'height=\'$value\' ')
);

$Now = time(); 
$MaxIncludes = 10;
$TableAttr = "";
$TableCellAttr = "valign='top'";
$Newline = "\262";
$KeepToken = "\263"; $KPCount=0;
$LinkToken = "\037"; 
$StyleToken = "\036";
$EnableStdConfig = 1;

umask(is_writable($WikiDir) ? (fileperms($WikiDir)^0777) : 002);
if (setlocale(LC_ALL,0)=='C') setlocale(LC_ALL,'en_US');

if (strpos(@$_SERVER['QUERY_STRING'],'?')!==false) { 
  unset($_GET); 
  parse_str(str_replace('?','&',$_SERVER['QUERY_STRING']),$_GET);
}
$gvars = array('pagename','action','text','restore','preview');
foreach($gvars as $v) {
  if (isset($_GET[$v])) $$v=$_GET[$v];
  elseif (isset($_POST[$v])) $$v=$_POST[$v];
  else $$v = '';
}

SDV($EnablePathInfo,!preg_match("/^cgi/",php_sapi_name()));
if ($pagename=='' && $EnablePathInfo)
  $pagename = @substr(htmlspecialchars($_SERVER['PATH_INFO']),1);
if (preg_match('/[\\x80-\\xbf]/',$pagename)) $pagename=utf8_decode($pagename);
if ($action=='') $action='browse';

error_reporting(E_ALL ^ E_NOTICE);
if (file_exists("$FarmD/local/farmconfig.php"))
  include_once("$FarmD/local/farmconfig.php");
if (!isset($EnableLocalConfig) || $EnableLocalConfig) {
  if (file_exists('local/config.php'))
    { include_once('local/config.php'); $LocalConf=1; }
  elseif (file_exists('local.php'))                          # deprecated 0.6
    { include_once('local.php'); $LocalConf=1; }             # deprecated 0.6
  elseif (file_exists('local/local.php'))                    # deprecated 0.6
    { include_once('local/local.php'); $LocalConf=1; }       # deprecated 0.6
}

SDV($DefaultPage,"$DefaultGroup/$DefaultTitle");
if ($pagename=='') $pagename=$DefaultPage;

if ($EnableStdConfig)
  @include_once("$FarmD/scripts/stdconfig.php");

mkgiddir($WikiDir);
if (!file_exists("$WikiDir/.htaccess") && 
    $fp=@fopen("$WikiDir/.htaccess","w")) {
  fwrite($fp,"Order Deny,Allow\nDeny from all\n");
  fclose($fp);
}
SDV($UrlLinkTextFmt,$UrlLinkFmt);
SDV($RedirectPattern,"\\[\\[redirect:(\\S+)\\]\\]");
SDV($WikiPageCreateSpaceFmt,$WikiPageCreateFmt);

$LinkPatterns[200]["\\bmailto:($UrlPathPattern)"] = "<a href='$0'>$1</a>";
$LinkPatterns[300]["\\b($UrlMethodPattern):($UrlPathPattern)"] = $FmtUrlLink;

foreach($InterMapFiles as $mapfile) {
  if (@!($mapfd=fopen($mapfile,"r"))) continue;
  while ($mapline=fgets($mapfd,1024)) {
    if (preg_match("/^\\s*\$/",$mapline)) continue;
    list($mapid,$mapurl) = preg_split("/\\s+/",$mapline);
    if (strpos($mapurl,'$1')===false) $mapurl .= '$1';
    $LinkPatterns[400]["\\b$mapid:($UrlPathPattern)"] = $FmtUrlLink;
    $InterMapUrls[$mapid] = $mapurl;
  }
  fclose($mapfd);
}

$LinkPatterns[480]["($WikiStylePattern)"] = "$StyleToken$1";
$LinkPatterns[500]["\\b($GroupNamePattern([\\/.]))?($FreeLinkPattern)($FragmentPattern)?"] = $FmtWikiLink;
$LinkPatterns[600]["$FreeLinkPattern($FragmentPattern)?"]  = $FmtWikiLink;
$LinkPatterns[700]["\\b$GroupNamePattern([\\/.])$WikiWordPattern($FragmentPattern)?"] = $FmtWikiLink;
$LinkPatterns[780]["\\[\\[$FragmentPattern\\]\\]"] = 
  "<a name='$1' id='$1'></a>";
$LinkPatterns[780]["\\[\\[$FragmentPattern\\s(.+?)\\]\\]"] =
  "<a href='#$1'>$2</a>";
$LinkPatterns[800]["\\b$WikiWordPattern($FragmentPattern)?"] = $FmtWikiLink;

$CurrentTime = strftime($TimeFmt,$Now);

if (preg_match("/^($GroupNamePattern)[\\/.]?\$/",$pagename,$match)) {
  if (PageExists($match[1].'.'.$match[1])) Redirect($match[1].'.'.$match[1]);
  else Redirect($match[1].".$DefaultTitle");
}
if (!preg_match("/^($GroupNamePattern)[\\/.]($PageTitlePattern)\$/",$pagename,
    $match))
  Abort("'$pagename' is not a valid PmWiki page name");
$pagename=FmtPageName('$PageName',$pagename);

$handle = @$HandleActions[$action];
if (function_exists($handle)) $handle($pagename);
else { HandleBrowse($pagename); }
EndHTML();
Lock(-1);

function SDV(&$var,$val) { if (!isset($var)) $var=$val; }
function SDVA(&$var,$val) {
  foreach($val as $k=>$v) if (!isset($var[$k])) $var[$k]=$v;
}
function stripmagic($s) 
  { return get_magic_quotes_gpc() ? stripslashes($s) : $s; } 

function mkgiddir($dir) {
  global $ForceMkdir;
  $dir = preg_replace('!/$!','',$dir);
  if (is_dir($dir)) return;
  if (!$ForceMkdir) {
    $parent = dirname($dir);
    $rparent = realpath($parent);
    $perms = fileperms($parent);
    if (umask()!=0 && posix_getegid()!=filegroup($parent) && 
        ($perms & 02000)==0) 
      Abort("PmWiki wants setgid permissions enabled on <tt>$rparent</tt><br />
        before it creates the <tt>$dir</tt> directory.  <br />
        Try executing <pre>    chmod 2777 $rparent</pre> 
        on your server and reloading this page.  Afterwards, you 
        can restore the permissions<br />to their current setting by executing
        <pre>    chmod ".decoct($perms & 03777)." $rparent</pre>If this
        doesn't work for you, see the link below.","Setgid");
  }
  mkdir($dir,0777) or 
    Abort("Cannot create <tt>$dir</tt><br />
      Current directory is <tt>".getcwd()."</tt>","Mkdir");
}

function Abort($msg,$aref = NULL) {
  StartHTML("","Program error");
  echo("<h3>PmWiki can't process your request</h3>
    <p>$msg</p><p>We are sorry for any inconvenience.</p>");
  if ($aref) {
    $href = "http://www.pmichaud.com/ref/PmWiki/$aref";
    echo("<p><a href='$href' target='_blank'>$href</a></p>");
  }
  EndHTML();
  exit();
}

function SetPageVars($pagename,&$page,$title) {
  $GLOBALS['LastModified'] = $page['timefmt'];
  $GLOBALS['LastModifiedBy'] = @$page['author'];
  $GLOBALS['LastModifiedHost'] = @$page['host'];
  $GLOBALS['HTMLTitle'] = $title;
  $GLOBALS['GCount'] = 0;
}

function StartHTML($pagename,$title = "") {
  global $calledStartHTML; if ($calledStartHTML++) return;
  global $HTMLStartFmt,$GCount;
  $GLOBALS['HTMLTitle']=$title; $GCount=0;
  PrintFmt($pagename,$HTMLStartFmt);
}

function EndHTML($pagename=NULL,$x=NULL) {
  static $called; if ($called++) return;
  global $calledStartHTML,$HTMLEndFmt;
  if ($calledStartHTML) PrintFmt($pagename,$HTMLEndFmt);
}

function Redirect($pagename,$urlfmt='$PageUrl') {
  global $RedirectDelay,$ScriptUrl,$DefaultPage;
  clearstatcache();
  if (!PageExists($pagename)) $pagename=$DefaultPage;
  $pageurl=FmtPageName($urlfmt,$pagename);
  header("Location: $pageurl");
  header("Content-type: text/html");
  print("<html><head>
    <meta http-equiv='Refresh' Content='$RedirectDelay; URL=$pageurl'>
    <title>Redirect</title></head><body></body></html>");
  exit;
}

function AsSpaced($word) {
  global $SpaceWikiWords,$SpaceWikiWordsString;
  $word = str_replace('_',$SpaceWikiWordsString,$word);
  $word = preg_replace("/([[:lower:]\\d])([[:upper:]])/",
    '$1'.$SpaceWikiWordsString.'$2',$word);
  if ($SpaceWikiWords==2)
    $word = preg_replace("/([[:lower:]])(\\d+( |\$))/",
      '$1'.$SpaceWikiWordsString.'$2',$word);
  else 
    $word = preg_replace("/(?<![-\\d])(\\d+( |\$))/",
      $SpaceWikiWordsString.'$1',$word);
  return preg_replace("/([[:upper:]])([[:upper:]][[:lower:]\\d])/",
    '$1'.$SpaceWikiWordsString.'$2',$word);
}

function FreeLink($link) {
  global $GroupFreeLinkPattern,$PageNameSpace;
  if (!preg_match("/$GroupFreeLinkPattern/",$link,$match)) return NULL;
  $name = preg_replace('/[_\\s]+/',' ',$match[3].$match[4]);
  $name = str_replace(' ',$PageNameSpace,ucwords($name));
  return array('name'=>$name,'text'=>$match[3].$match[5],
    'group'=>$match[1],'sep'=>$match[2]);
}

function PrintFmt($pagename,$fmt) {
  global $HTTPHeaders;
  if (is_array($fmt)) 
    { foreach($fmt as $f) PrintFmt($pagename,$f); return; }
  $x = FmtPageName($fmt,$pagename);
  if (preg_match("/^headers:/",$x)) {
    foreach($HTTPHeaders as $h) (@$sent++) ? @header($h) : header($h);
    return; 
  }
  if (preg_match("/^function:(\S+)\s*(.*)\$/s",$x,$match) && 
      function_exists($match[1])) 
    { $f = $match[1]; $f($pagename,$match[2]); return; }
  if (preg_match("/^wiki:(.+)\$/s",$x,$match))
    { PrintWikiPage($pagename,$match[1]); return; }
  if (preg_match("/^file:(.+)/s",$x,$match)) {
    $filelist = preg_split('/[\\s]+/',$match[1],-1,PREG_SPLIT_NO_EMPTY);
    foreach($filelist as $f) {
      if (file_exists($f)) { include($f); return; }
    }
    return;
  }
  print $x;
}

function FmtUrlLink($pat,$ref,$txt) {
  global $InterMapUrls,$ImgExtPattern,$UrlLinkFmt,$UrlImgFmt,$UrlLinkTextFmt;
  $link = $UrlLinkFmt; $rtxt=$ref;
  if (!is_null($txt)) { $rtxt=$txt; $link=$UrlLinkTextFmt; }
  elseif (preg_match("/$ImgExtPattern\$/",$ref)) { $link=$UrlImgFmt; }
  if (preg_match('/^([^:]*):/',$ref,$match)) {
    if (@$InterMapUrls[$match[1]]) 
      $ref=preg_replace("/^$pat\$/",$InterMapUrls[$match[1]],$ref);
  }
  $link = str_replace('$Url',$ref,$link);
  return str_replace('$LinkText',$rtxt,$link);
}

function FmtWikiLink($pat,$ref,$btext,$out=NULL,$rname=NULL) {
  global $GroupNamePattern,$PageNameSpace,$SpaceWikiWords,
    $WikiPageExistsFmt,$WikiPageCreateSpaceFmt,$WikiPageCreateFmt,
    $PageTitlePattern,$FragmentPattern,$WikiWordPagePathFmt,
    $WikiWordPattern,$WikiWordReplaceFmt,$WWCount,$WikiWordCountMax,
    $AsSpacedFunction;
  $lref=$ref; $fragment='';
  if (preg_match("/^(.*)($FragmentPattern)\$/",$lref,$match)) 
    { $lref=$match[1]; $fragment=$match[2]; }
  if ($fl=FreeLink($lref)) { $name=$fl['name']; $txt=$fl['text']; } 
  else { 
    $name = preg_replace('/^.*[\\/.]/','',$lref);
    $txt = ($SpaceWikiWords) ? $AsSpacedFunction($name) : $name;
  }
  if (preg_match("/^($GroupNamePattern)([\\/.])/",$lref,$match)) 
    { $fl['group']=$match[1]; $fl['sep']=$match[2]; }
  if ($fl['group']) {
    $pname = $fl['group'].'.'.$name;;
    if ($fl['sep']=='.') $txt=$fl['group'].'.'.$txt; 
  } else {
    if ($rname=='') $rname=$GLOBALS['pagename'];
    foreach((array)$WikiWordPagePathFmt as $pg) {
      $pn=FmtPageName(str_replace('$1',$name,$pg),$rname);
      if (PageExists($pn)) { $pname=$pn; break; }
      if (@$pname=='') $pname=$pn;
    }
  }
  if ($out=='PageName') return $pname;
  if (!preg_match("/\.$PageTitlePattern\$/",$pname)) return $ref;
  $txt .= $fragment;
  if (!is_null($btext)) $txt=$btext;
  if (PageExists($pname)) $fmt=$WikiPageExistsFmt;
  elseif (preg_match('/\\s/',$txt)) $fmt=$WikiPageCreateSpaceFmt;
  else $fmt=$WikiPageCreateFmt;
  if (is_null($btext) && preg_match("/^$WikiWordPattern\$/",$ref)) {
    if (@$WikiWordReplaceFmt[$name]) $fmt=$WikiWordReplaceFmt[$name];
    else {
      if (!isset($WWCount[$name])) $WWCount[$name]=$WikiWordCountMax;
      if ($WWCount[$name]-- < 1) return $ref;
    }
  }
  $fmt=str_replace(array('$LinkText','$Fragment'),array($txt,$fragment),$fmt);
  return FmtPageName($fmt,$pname);
}

function XL($key) {
  global $XL,$XLLangs;
  foreach($XLLangs as $l) { if (isset($XL[$l][$key])) return $XL[$l][$key]; }
  return $key;
}
function XLSDV($lang,$a) {
  global $XL;
  foreach($a as $k=>$v) { if (!isset($XL[$lang][$k])) $XL[$lang][$k]=$v; }
}
function XLPage($lang,$p) {
  global $TimeFmt,$XLLangs,$FarmD;
  $page = ReadPage($p);
  if (!$page) return;
  $text = preg_replace("/=>\\s*\n/",'=> ',$page['text']);
  foreach(explode("\n",$text) as $l) 
    if (preg_match('/^\\s*[\'"](.+?)[\'"]\\s*=>\\s*[\'"](.+)[\'"]/',$l,$match))
      $xl[stripslashes($match[1])] = stripslashes($match[2]); 
  if ($xl) {
    if ($xl['xlpage-i18n']) {
      $i18n = preg_replace('/[^-\\w]/','',$xl['xlpage-i18n']);
      include_once("$FarmD/scripts/xlpage-$i18n.php");
    }
    if ($xl['Locale']) setlocale(LC_ALL,$xl['Locale']);
    if ($xl['TimeFmt']) $TimeFmt=$xl['TimeFmt'];
    array_unshift($XLLangs,$lang);
    XLSDV($lang,$xl); 
  }
}

function FmtPageName($fmt,$pagename) {
  if (strpos($fmt,'$')===false) return $fmt;
  global $UnsafeGlobals,$GroupNamePattern,$PageTitlePattern,
    $PageUrlFmt,$EnablePathInfo,$PageNameFmt,$WikiWordPattern,$GCount,
    $AsSpacedFunction;
  static $g;
  static $qk = array('$ScriptUrl','$Groupspaced','$Group',
    '$Titlespaced','$Title_','$Title','$Tlink');
  if (!is_null($pagename) && !preg_match("/^($GroupNamePattern)[\\/.]($PageTitlePattern)\$/",$pagename,$match)) return "";
  $fmt = preg_replace('/\\$([A-Z]\\w*Fmt)\\b/e','$GLOBALS[\'$1\']',$fmt);
  $fmt = preg_replace("/\\$\\[(.+?)\\]/e","XL(stripslashes('$1'))",$fmt);
  $qv = @array($GLOBALS['ScriptUrl'],$AsSpacedFunction($match[1]),$match[1],
    $AsSpacedFunction($match[2]),$match[2],str_replace('_',' ',$match[2]),
    preg_match("/^$WikiWordPattern\$/",$match[2]) ? $match[2] :
      '{{'.str_replace('_',' ',$match[2]).'}}');
  $fmt=str_replace('$PageUrl',$PageUrlFmt,$fmt);
  $fmt=str_replace('$PageName',$PageNameFmt,$fmt);
  if (isset($EnablePathInfo) && !$EnablePathInfo) 
    $fmt = preg_replace('!\\$ScriptUrl/([^\'"\\s?./]+)(?:[./]([^\'"\\s?]*))?(?:\\?([^\'"\\s]*))?!e',"'\$ScriptUrl?pagename=$1'.(('$2')?'.$2':'').(('$3')?'&amp;$3':'')",$fmt);
  $fmt=str_replace($qk,$qv,$fmt);
  if (strpos($fmt,'$')===false) return $fmt;
  if (count($GLOBALS)!=$GCount) {
    foreach($GLOBALS as $n=>$v) {
      if ($n == 'Text') continue;
      if (in_array($n,$UnsafeGlobals)) continue;
      if (is_array($v)) { $UnsafeGlobals[]=$n; continue; }
      $g["\$$n"]= $GLOBALS[$n];
    }
    $GCount = count($GLOBALS);
    krsort($g); reset($g);
  }
  if (isset($g[$fmt])) return $g[$fmt];
  $fmt = str_replace(array_keys($g),array_values($g),$fmt);
  $fmt = str_replace('$Text',
    @htmlspecialchars($GLOBALS['Text'],ENT_NOQUOTES),$fmt);
  return $fmt;
}

function Diff($oldtext,$newtext) {
  global $WikiDir,$SysDiffCmd;
  if (!$SysDiffCmd) return '';
  $tempold = tempnam($WikiDir,"old");
  if ($oldfp = fopen($tempold,"w")) { 
    fputs($oldfp,$oldtext); 
    fclose($oldfp); 
  }
  $tempnew = tempnam($WikiDir,"new");
  if ($newfp = fopen($tempnew,"w")) { 
    fputs($newfp,$newtext); 
    fclose($newfp); 
  }
  $diff = '';
  $diff_handle = popen("$SysDiffCmd $tempold $tempnew","r");
  if ($diff_handle) {
    while (!feof($diff_handle)) { $diff .= fread($diff_handle,1024); }
    pclose($diff_handle);
  }            
  @unlink($tempold); @unlink($tempnew);
  return $diff;
}

function Patch($page,$restore) {
  $text = $page['text'];
  krsort($page); reset($page);
  $t = explode("\n",$text);
  $nl = (substr($text,-1)=="\n");
  if ($nl) array_pop($t);
  foreach($page as $k=>$v) {
    if ($k<$restore) break;
    if (substr($k,0,5)!='diff:') continue;
    foreach(explode("\n",$v) as $x) {
      if (preg_match('/^(\\d+)(,(\\d+))?([adc])(\\d+)/',$x,$match)) {
        $a1 = $a2 = $match[1];
        if ($match[3]) $a2=$match[3];
        $b1 = $match[5];
        if ($match[4]=='d') array_splice($t,$b1,$a2-$a1+1);
        if ($match[4]=='c') array_splice($t,$b1-1,$a2-$a1+1);
        continue;
      }
      if (substr($x,0,2)=='< ') { $nlflag=true; continue; }
      if (preg_match('/^> (.*)$/',$x,$match)) {
        $nlflag=false;
        array_splice($t,$b1-1,0,$match[1]); $b1++;
      }
      if ($x=='\\ No newline at end of file') $nl=$nlflag;
    }
  }
  if ($nl) $t[]='';
  return implode("\n",$t);
}

function PageExists($pagename) {
  global $WikiLibDirs,$PageFileFmt;
  $pagefile = FmtPageName($PageFileFmt,$pagename);
  if (!$pagefile) return false;
  foreach ($WikiLibDirs as $dir) {
    if (file_exists("$dir/$pagefile")) return true;
  }
  return false;
}
    
function Lock($op) {
  global $WikiDir;
  static $lockfp,$curop;
  if (!$lockfp) {
    $lockfp=fopen("$WikiDir/.flock","w") or 
      Abort("Cannot acquire lockfile","Lockfile");
  }
  if ($op<0) { flock($lockfp,LOCK_UN); fclose($lockfp); $lockfp=0; $curop=0; }
  elseif ($op==0) { flock($lockfp,LOCK_UN); $curop=0; }
  elseif ($op==1 && $curop<1) { flock($lockfp,LOCK_SH); $curop=1; }
  elseif ($op==2 && $curop<2) { flock($lockfp,LOCK_EX); $curop=2; }
}

function ReadPage($pagename,$defaulttext=NULL) {
  global $WikiLibDirs,$PageFileFmt,$DefaultPageTextFmt,$Now,$TimeFmt;
  $pagefile = FmtPageName($PageFileFmt,$pagename);
  if (!$pagefile) return false;
  if (is_null($defaulttext)) $defaulttext=$DefaultPageTextFmt;
  $page["text"] = FmtPageName($defaulttext,$pagename);
  $page["time"] = $Now;
  $newline = "\262";
  Lock(1);
  foreach ($WikiLibDirs as $dir) {
    $fp = @fopen("$dir/$pagefile","r");
    if ($fp) break;
  }
  if ($fp) {
    while (!feof($fp)) {
      $line = fgets($fp,4096);
      while (!strstr($line,"\n") && !feof($fp)) { $line .= fgets($fp,4096); }
      @list($k,$v) = explode("=",rtrim($line),2);
      if ($k=='newline') { $newline=$v; continue; }
      $page[$k] = str_replace($newline,"\n",$v);
    }
    fclose($fp);
  }
  $page['timefmt'] = strftime($TimeFmt,$page['time']);
  return $page;
}

function WritePage($pagename,$page) {
  global $Now,$WikiDir,$PageFileFmt,$Version,$Newline;
  if( preg_match_all( '|http://|', $page['text'], $arMatches) > 20) { die( 'too much links'); }
  Lock(2);
  foreach (array('timefmt','pagename','action','version','newline') as $k)
    unset($page[$k]);
  $page['name'] = $pagename;
  $page['time'] = $Now; 
  $page['host'] = $_SERVER['REMOTE_ADDR'];
  $page['agent'] = $_SERVER['HTTP_USER_AGENT'];
  $page['rev'] = @$page['rev']+1;
  $pagefile = FmtPageName("$WikiDir/$PageFileFmt",$pagename);
  $pagedir = preg_replace('#/[^/]*$#','',$pagefile);
  if ($pagedir) mkgiddir($pagedir);
  $s = false;
  if ($pagefile && ($fp=fopen("$pagefile.new","w"))) {
    $s = true && fputs($fp,"version=$Version\nnewline=$Newline\n");
    foreach($page as $k=>$v) 
      if ($k>"") $s = $s && fputs($fp,str_replace("\n",$Newline,"$k=$v")."\n"); 
    $s = fclose($fp) && $s;
    if (file_exists($pagefile)) $s = $s && unlink($pagefile);
    $s = $s && rename("$pagefile.new",$pagefile);
  } 
  if (!$s) 
    Abort("Cannot write text to $pagename ($pagefile)...changes not saved"); 
}  

function Keep($text) {
  global $KeepToken,$KPV,$KPCount;
  $KPCount++; $KPV[$KPCount]=$text;
  return $KeepToken.$KPCount.$KeepToken;
}

function KeepWikiEscapes($text) {
  $e0 = array('=' => '', '@' => '<code>');
  $e1 = array('=' => '', '@' => '</code>');
  return preg_replace("/\\[([=@])(.*?)\\1\\]/se",
    "Keep(\$e0['$1'].htmlspecialchars(str_replace('\\\"','\"','$2'),ENT_NOQUOTES).\$e1['$1'])",$text);
}

function QuoteAttrs($attr) {
  return preg_replace('/([a-zA-Z]=)([^\'"]\\S*)/',"\$1'\$2'",$attr);
}
  
function EmitCode($code,$depth,$attr="") {
  global $HTMLVSpace;
  static $cs,$vspaces;
  static $li = array('dl'=>'</dd>','ul'=>'</li>','ol'=>'</li>',
    'indent' => '</div>');
  static $le = array('dl'=>'</dl>','ul'=>'</ul>','ol'=>'</ol>');
  $attr = QuoteAttrs($attr);
  if (!$cs) { $cs = array(); }
  if ($code=='p') { $vspaces.="\n"; return; }
  if ((@$cs[0]=='table' || @$cs[0]=='pre') && $code!=@$cs[0]) 
    while (count($cs)>0) { echo "</",array_pop($cs),">"; }
  while (count($cs)>$depth) 
    { $c=array_pop($cs); echo @$li[$c],@$le[$c]; }
  if ($depth>0 && $depth==count($cs) && $cs[$depth-1]!=$code) 
    { $c=array_pop($cs); echo @$li[$c],@$le[$c]; }
  if ($vspaces) 
    { echo (@$cs[0]=='pre') ? $vspaces : $HTMLVSpace; $vspaces=''; }
  if ($depth==0) return;
  if ($depth==count($cs)) { echo @$li[$code]; return; }
  while (count($cs)<$depth-1) { array_push($cs,'dl'); echo '<dl><dd>'; }
  while (count($cs)<$depth) { 
    array_push($cs,$code); 
    if ($code!='indent') echo "<$code $attr>"; 
  }
}

function FormatTableRow($x,$cellattr) {
  $x = preg_replace("/\\|\\|\$/","",$x);
  $td = explode('||',$x); $y='';
  for($i=0;$i<count($td);$i++) {
    if ($td[$i]=='') continue;
    $attr=" $cellattr";
    if (preg_match('/^\\s+\$/',$td[$i])) $td[$i]='&nbsp;';
    if (preg_match('/^!(.*?)!$/',$td[$i],$match)) 
      { $td[$i]=$match[1]; $t='caption'; $attr=''; }
    elseif (preg_match('/^!(.*?)$/',$td[$i],$match)) 
      { $td[$i]=$match[1]; $t='th'; }
    else $t='td';
    if (preg_match('/^\\s.*\\s$/',$td[$i])) { $attr .= " align='center'"; }
    elseif (preg_match('/^\\s/',$td[$i])) { $attr .= " align='right'"; }
    elseif (preg_match('/\\s$/',$td[$i])) { $attr .= " align='left'"; }
    for($colspan=1;$i+$colspan<count($td);$colspan++) 
      if ($td[$colspan+$i] != '') break;
    if ($colspan>1) { $attr .= " colspan='$colspan'"; }
    $y .= "<$t$attr>".$td[$i]."</$t>";
  }
  if ($t=='caption') return $y;
  return "<tr>$y</tr>";
}

function EmitCell($x,$y) {
  static $tableattr,$intable;
  $y = QuoteAttrs($y);
  if ($x == 'cell' || $x == 'cellnr') {
    if (!$intable) { echo "<table $tableattr><tr><td $y>"; $intable=1; }
    else if ($x == 'cellnr') { echo "</td></tr><tr><td $y>"; }
    else { echo "</td><td $y>"; }
    return;
  } 
  if ($intable) { echo "</td></tr></table>"; $intable=0; }
  $tableattr = $y;
}

function ApplyStyles($x) {
  global $WikiStylePattern,$WikiStyle,$WikiStyleTags,$StyleToken;
  $lineparts = preg_split("/$StyleToken($WikiStylePattern)/",$x,-1,
    PREG_SPLIT_DELIM_CAPTURE);
  $out='';
  $style = array();
  while ($lineparts) {
    $WikiStyle['curr']=$style; $style = array();
    if (preg_match("/^$WikiStylePattern\$/",$lineparts[0])) {
      $slist=preg_split('/[^-#=:,\\w]+/',array_shift($lineparts),-1,
        PREG_SPLIT_NO_EMPTY);
      foreach($slist as $s) {
        if (preg_match('/^([^=:]+)[=:](.*)$/',$s,$match)) {
          $style[$match[1]] = $match[2];
        } else { $style = array_merge($style,(array)@$WikiStyle[$s]); }
      }
      if (@$style['define']) { 
        $d = $style['define']; unset($style['define']);
        $WikiStyle[$d] = $style;
      }
    }
    $l = array_shift($lineparts);
    if ($l>"") {
      $styleattr = '';
      $classattr = '';
      foreach($style as $k=>$v) {
        if (!is_array($WikiStyleTags[$k])) continue;
        foreach($WikiStyleTags[$k] as $tag=>$w) {
          $w = str_replace('$value',$v,$w);
          if ($tag=='style') $styleattr.=$w;
          elseif ($tag=='class') $classattr=$w;
          else $l=preg_replace("/(<$tag )/","\$1$w ",$l);
        }
      }
      if ($styleattr) { $styleattr="style='$styleattr'"; }
      if ($styleattr || $classattr) 
        $out .= "<span $classattr $styleattr>$l</span>";
      else $out .= $l;
    }
  }
  return $out;
}
  
function PrintText($pagename,$text="") {
  global $KeepToken,$KPV,$LinkToken,$LinkPatterns,$ImgExtPattern,
    $DoubleBrackets,$TableAttr,$TableCellAttr,$HTMLLineBreak,
    $InlineReplacements,$WikiStylePattern,$Text,$WWCount,$WikiWordCount;
  static $refcount;
  $WWCount=$WikiWordCount;
  if ($text=="") $text=$Text;
  ksort($LinkPatterns);
  foreach($LinkPatterns as $n=>$a)
    foreach($a as $p=>$r) $linkpats[$p]=$r;
  $lp=$LinkToken;
  $text = KeepWikiEscapes($text);
  $text = htmlspecialchars($text,ENT_NOQUOTES);
  $text = str_replace("\r","",$text);
  $text = preg_replace("/(\\\\*)\\\\\n/e",
    "' '.str_repeat('<br />',strlen('$1'))",$text);
  foreach($DoubleBrackets as $n=>$fmt) {
    if ($n[0]!='/') $text=str_replace($n,FmtPageName($fmt,$pagename),$text);
  }
  $lines = explode("\n",$text);
  foreach($lines as $x) {
    foreach($DoubleBrackets as $n=>$fmt) {
      if ($n[0]=='/') $x=preg_replace($n,$fmt,$x);
    }
    $lpcount = 0;
    $lpv = array();
    foreach($linkpats as $pat=>$rep) {
      $re = "/\\[\\[($pat)(\\s.*?)?(\\]\\])/";
      while(preg_match($re,$x,$match)) {
        $x=preg_replace($re,"$lp$lpcount$lp",$x,1);
        array_pop($match); $txt=array_pop($match);
        if ($txt=="") $txt="$lp#$lp";
        else {
          $txt = ltrim($txt);
          if (preg_match("/$ImgExtPattern\$/",$txt)) {
            foreach($linkpats as $p=>$r) {
              if (preg_match("/^$p\$/",$txt)) {
                if (function_exists($r)) $txt = $r($p,$txt,NULL); 
                else $txt = preg_replace($p,$r,$txt);
                break;
              }
            }
          } 
        }
        if (function_exists($rep)) 
          $txt = $rep($pat,$match[1],$txt);
        else {
          $r = preg_replace("/^$pat\$/",$rep,$match[1]);
          preg_match("/(name|href)='.*?'/",$r,$match);
          $txt = "<a ".@$match[0].">$txt</a>";
        }
        $lpv[$lpcount++] = $txt;
      }
    }
    foreach($linkpats as $pat=>$rep) {
      $re = "/($pat)/";
      while(preg_match($re,$x,$match)) {
        $x=preg_replace($re,"$lp$lpcount$lp",$x,1);
        if (function_exists($rep)) 
          $txt = $rep($pat,$match[1],NULL);
        else $txt = preg_replace("/^$pat\$/",$rep,$match[1]);
        $lpv[$lpcount++] = $txt;
      }
    }
    if (preg_match("/^\\[\\[(table|cell|cellnr|tableend)(\\s.*?)?\\]\\]/",$x,$match)) {
      EmitCode("",0);
      @EmitCell($match[1],$match[2]);
      $x=preg_replace("/^\\[\\[.*?\\]\\]/","",$x);
    }
    else if (preg_match("/^\\s*\$/",$x)) { EmitCode("p",0); continue; }
    if (preg_match("/^(:+)[^:]*:/",$x,$match)) {
      $x=preg_replace("/^:+([^:]*):/","<dt>\\1</dt><dd>",$x);
      EmitCode("dl",strlen($match[1]));
    } elseif (preg_match("/^(\\*+)/",$x,$match)) {
      $x=preg_replace("/^\\*+/","<li>",$x);
      EmitCode("ul",strlen($match[1]));
    } elseif (preg_match("/^(#+)/",$x,$match)) {
      $x=preg_replace("/^#+/","<li>",$x);
      EmitCode("ol",strlen($match[1]));
    } elseif (preg_match("/^\s/",$x)) {
      EmitCode("pre",1);
    } elseif (preg_match("/^\\|\\|.*\\|\\|/",$x,$match)) {
      EmitCode("table",1,$TableAttr);
      $x=FormatTableRow($x,$TableCellAttr);
    } elseif (preg_match("/^\\|\\|(.*)/",$x,$match)) {
      EmitCode("",0);
      $TableAttr = $match[1];
      continue;
    } elseif (preg_match("/^(!{1,6})/",$x,$match)) {
      $h="h".strlen($match[1]);
      $x=preg_replace("/^(!{1,6})/","<$h>",$x)."</$h>";
      EmitCode("",0);
    } elseif (preg_match("/^(-+)&gt;/",$x,$match)) {
      $x=preg_replace("/^(-+)&gt;/","<div class='indent'>",$x);
      EmitCode("indent",strlen($match[1]));
    } else { $x.=$HTMLLineBreak; EmitCode("",0); }
    foreach ($InlineReplacements as $pat => $rep) 
      $x = preg_replace($pat,$rep,$x);
    if (preg_match("/^\\s*($lp(\\d+)$lp)\\s*\$/",$x,$match)) 
      $x = str_replace(" img>"," /><br />",$lpv[$match[2]]); 
    if (preg_match("/^\\s*($lp(\\d+)$lp).*\\S/",$x,$match)) 
      $x = str_replace($match[1],
        str_replace(" img>"," align='left' />",$lpv[$match[2]]), $x); 
    if (preg_match("/\\S.*($lp(\\d+)$lp)\\s*\$/",$x,$match)) {
      $rt = str_replace(" img>"," align='right' />",$lpv[$match[2]]);
      if (strstr($rt,"<img")) $x=$rt.str_replace($match[1],"",$x);
      else $x=str_replace($match[1],$rt,$x);
    } 
    $x = preg_replace("/$lp(\\d+)$lp/e",
      'str_replace(" img>"," />",$lpv[$1])',$x);
    $x = preg_replace("/$lp#$lp/e",'"[".++$refcount."]"',$x);
    if ($WikiStylePattern) $x = ApplyStyles($x);
    while (preg_match("/$KeepToken(\\d+?)$KeepToken/",$x)) 
      $x = preg_replace("/$KeepToken(\\d+?)$KeepToken/e",'$KPV[$1]',$x);
    echo $x,"\n";
  }
  EmitCode("",0);
  EmitCell("","");
}

function PrintWikiPage($pagename,$wikilist=NULL) {
  global $PrintWikiPageNotFoundFmt;
  if (is_null($wikilist)) $wikilist=$pagename;
  $pagelist = preg_split('/\s+/',$wikilist,-1,PREG_SPLIT_NO_EMPTY);
  foreach($pagelist as $p) {
    if (PageExists($p)) {
      $page = RetrieveAuthPage($p,"read",false);
      if ($page['text']) 
        PrintText($pagename,ProcessIncludes($pagename,$page['text']));
      return;
    }
  }
  if ($PrintWikiPageNotFoundFmt>'') 
    print FmtPageName(@$PrintWikiPageNotFoundFmt,array_pop($pagelist));
}

function ProcessIncludes($pagename,$text="") {
  global $MaxIncludes,$IncludeBadAnchorFmt,$GroupNamePattern,$PageTitlePattern;
  $inclcount=0;
  while ($inclcount<$MaxIncludes &&
      preg_match("/\\[\\[include:(($GroupNamePattern([\\/.]))?$PageTitlePattern)(#(\\w[-.:\\w]*)?(#(\\w[-.:\\w]*)?)?)?\\]\\]/",$text,$match)) {
    list($inclrepl,$inclname,$group,$dot,$a,$aa,$b,$bb) = $match;
    if (!$group) $inclname=FmtPageName('$Group.',$pagename).$inclname;
    $inclpage = RetrieveAuthPage($inclname,"read",false);
    $incltext = $inclpage['text'];
    $badanchor = '';
    if ($bb && !preg_match('/^\\d+$/',$bb) && 
      strpos($incltext,"[[#$bb]]")===false) $badanchor=$bb;
    if ($aa && !preg_match('/^\\d+$/',$aa) && 
      strpos($incltext,"[[#$aa]]")===false) $badanchor=$aa;
    if ($badanchor)
      $incltext=FmtPageName(str_replace('$BadAnchor',$badanchor,
        $IncludeBadAnchorFmt),$inclname);
    if (preg_match('/^\\d+$/',$bb)) 
      $incltext=preg_replace("/^(([^\\n]*\\n)\{0,$bb}).*$/s",'$1',$incltext,1);
    elseif ($bb) 
      $incltext=preg_replace("/[^\\n]*\\[\\[#$bb\\]\\].*$/s",'',$incltext,1);
    if (preg_match('/^\\d+$/',$aa)) {
      $aa--; $incltext=preg_replace("/^([^\\n]*\\n)\{0,$aa}/s",'',$incltext,1);
      if (!$b) $incltext=preg_replace("/\\n.*$/s",'',$incltext);
    } elseif ($aa && $b)
      $incltext=preg_replace("/^.*?([^\\n]*\\[\\[#$aa\\]\\])/s",'$1',$incltext,1);
    elseif ($aa)
      $incltext=preg_replace("/^.*?([^\\n]*\\[\\[#$aa\\]\\]( *\\n)?[^\\n]*).*/s",'$1',$incltext,1);
    $text = str_replace($inclrepl,$incltext,$text);
    $inclcount++;
  }
  return $text;
}

function ProcessTextDirectives($pagename,$text="") {
  global $Text,$GroupHeaderFmt,$GroupFooterFmt,$BrowseDirectives;
  if (!$text) $text=$Text;
  $text = KeepWikiEscapes($text);
  $text = ProcessIncludes($pagename,$text);
  if (!strstr($text,"[[nogroupheader]]")) {
    $hdname = FmtPageName($GroupHeaderFmt,$pagename);
    if ($hdname != $pagename) { 
      $hdpage=ReadPage($hdname,""); 
      if ($hdpage['text'] && substr($hdpage['text'],-1,1)!="\n" &&
        substr($text,0,1)!="\n") $hdpage['text'] .= "\n";
      $text = $hdpage['text'].$text; 
    }
  }
  if (!strstr($text,"[[nogroupfooter]]")) {
    $hdname = FmtPageName($GroupFooterFmt,$pagename);
    if ($hdname != $pagename) { 
      $hdpage=ReadPage($hdname,""); 
      if ($hdpage['text'] && substr($hdpage['text'],0,1)!="\n" &&
        substr($text,-1,1)!="\n") $text .= "\n";
      $text .= $hdpage['text']; 
    }
  }
  Lock(0);
  foreach($BrowseDirectives as $p=>$s) {
    if ($p[0]=='/') $text=preg_replace($p,$s,$text);
    else if (strstr($text,$p)) $text = str_replace($p,eval($s),$text);
  }
  $Text = $text;
}

function HandleBrowse($pagename) {
  global $Text,$PageRedirectFmt,$RedirectPattern,
    $HandleBrowseFmt,$PageStartFmt,$PageEndFmt;
  $page = RetrieveAuthPage($pagename,"read"); 
  if (!$page) { Abort("Invalid page name"); }
  $Text = $page['text'];
  SetPageVars($pagename,$page,$pagename);
  if (@!$_GET['from']) {
    $PageRedirectFmt = '';
    if (preg_match("/$RedirectPattern/",$Text,$match)) {
      $rpage = FmtWikiLink('',$match[1],NULL,'PageName',$pagename);
      if (PageExists($rpage)) Redirect($rpage,"\$PageUrl?from=$pagename");
    }
  }
  else $PageRedirectFmt = FmtPageName($PageRedirectFmt,$_GET['from']);
  ProcessTextDirectives($pagename);
  SDV($HandleBrowseFmt,array(&$PageStartFmt,
    &$PageRedirectFmt,'function:PrintText',
    &$PageEndFmt));
  PrintFmt($pagename,$HandleBrowseFmt);
}

function HandleEdit($pagename) {
  global $restore,$preview,$HandleActions,$Text,
    $HandleEditFmt,$PageStartFmt,$PageEditFmt,$PagePreviewFmt,$PageEndFmt,
    $DiffClassMinor,$PatchFunction;
  if (@$_POST['post']) 
    { $handle = $HandleActions['post']; return $handle($pagename); }
  $page = RetrieveAuthPage($pagename,"edit");
  if (!$page) { Abort("?cannot edit $pagename"); }
  SetPageVars($pagename,$page,"Edit $pagename");
  if ($restore && $PatchFunction) { $text = $PatchFunction($page,$restore); }
  else if ($preview) { $text = stripmagic($_POST['text']); }
  else { $text = $page['text']; }
  $Text = $text;
  $DiffClassMinor = ''; 
  if (@$_POST['diffclass']=='minor') $DiffClassMinor="checked='checked'";
  SDV($HandleEditFmt,array(&$PageStartFmt,
    &$PageEditFmt,&$PagePreviewFmt,
    &$PageEndFmt));
  PrintFmt($pagename,$HandleEditFmt);
}

function HandlePost($pagename) {
  global $WikiDir,$DeleteKeyWord,$RecentChanges,$RCDelimPattern,$Now,
    $TimeFmt,$CurrentTime,$PageFileFmt,$DiffKeepDays,$Author,$PostFields,
    $DiffFunction,$ChangeSummary;
  $CurrentTime = strftime($TimeFmt,$Now);
  foreach($PostFields as $k) {
    if (isset($_POST[$k]))
      $new[$k]=str_replace("\r","",stripmagic($_POST[$k])); 
  }
  Lock(2);
  $page = RetrieveAuthPage($pagename,"edit");
  if (!$page) { Abort("?cannot post $pagename"); }
  $pagename = FmtPageName('$PageName',$pagename);
  if ($new['text']==$page['text']) 
    { Redirect($pagename); return; }
  $diffclass=preg_replace('/\\W/','',@$_POST['diffclass']);
  if ($page["time"]>0)  
    $new["diff:$Now:".$page['time'].":$diffclass"] = 
      $DiffFunction($new['text'],$page['text']); 
  $new['author'] = $Author;
  $new["author:$Now"] = $Author;
  $new["host:$Now"] = $_SERVER['REMOTE_ADDR'];
  if ($ChangeSummary) $new["csum:$Now"] = $ChangeSummary;
  foreach($new as $k=>$v) {
    if ($k=='pagename' || $k=='action') continue;
    $page[$k] = $v;
  }
  $keepgmt = $Now-$DiffKeepDays*86400;
  $keys = array_keys($page);
  foreach ($keys as $k) 
    if (preg_match("/^\\w+:(\\d+)/",$k,$match))
      if ($match[1] < $keepgmt) unset($page[$k]);
  $pagefile = FmtPageName($PageFileFmt,$pagename);
  if ($page['text']==$DeleteKeyWord) 
    { @rename("$WikiDir/$pagefile","$WikiDir/$pagefile,$Now"); }
  else WritePage($pagename,$page);
  foreach($RecentChanges as $rcfmt => $pgfmt) {
    $rcname=FmtPageName($rcfmt,$pagename); if (!$rcname) continue;
    $pgtext=FmtPageName($pgfmt,$pagename); if (!$pgtext) continue;
    if (@$seen[$rcname]++) continue;
    $rcpage = ReadPage($rcname,"");
    $rcelim = preg_quote(preg_replace("/$RCDelimPattern.*$/",' ',$pgtext),'/');
    $rcpage['text'] = preg_replace("/[^\n]*$rcelim.*\n/","",$rcpage['text']);
    if (!preg_match("/$RCDelimPattern/",$rcpage['text'])) 
      $rcpage['text'] .= "$pgtext\n";
    else 
      $rcpage['text'] = preg_replace("/([^\n]*$RCDelimPattern.*\n)/",
        "$pgtext\n$1",$rcpage['text'],1);
    WritePage($rcname,$rcpage);
  }
  Redirect($pagename); 
}

function HandleSource($pagename) {
  $page = RetrieveAuthPage($pagename,"read");
  if (!$page) Abort("?cannot source $pagename");
  Lock(0);
  header("Content-Type: text/plain");
  echo $page['text'];
}

function BasicAuth($pagename,$level,$authprompt=true) {
  global $AuthRealmFmt,$AuthDeniedFmt,$DefaultPasswords,
    $AllowPassword,$GroupAttributesFmt;
  $page = ReadPage($pagename);
  if (!$page) { return false; }
  @$passwd = $page["passwd$level"];
  if ($passwd=="") { 
    $grouppg = ReadPage(FmtPageName($GroupAttributesFmt,$pagename));
    @$passwd = $grouppg["passwd$level"];
  }
  if (crypt($AllowPassword,$passwd)==$passwd) return $page;
  if ($passwd=="") { $passwd=@$DefaultPasswords[$level]; }
  if ($passwd=="") return $page;
  foreach (array_merge((array)$DefaultPasswords['admin'],(array)$passwd) as $pw)
    if (@crypt($_SERVER['PHP_AUTH_PW'],$pw)==$pw) return $page;
  if (!$authprompt) return false;
  $realm=FmtPageName($AuthRealmFmt,$pagename);
  header("WWW-Authenticate: Basic realm=\"$realm\"");
  header("Status: 401 Unauthorized");
  header("HTTP-Status: 401 Unauthorized");
  PrintFmt($pagename,$AuthDeniedFmt);
  exit;
}

function RetrieveAuthPage($pagename,$level,$authprompt=true) {
  global $AuthFunction;
  if (!function_exists($AuthFunction)) 
    Abort("?Invalid AuthFunction specified: $AuthFunction","AuthFunction");
  return $AuthFunction($pagename,$level,$authprompt);
}

function PrintAttrForm($pagename) {
  global $PageAttributes;
  echo FmtPageName("<form action='\$PageUrl' method='post'>
    <input type='hidden' name='action' value='postattr' />
    <input type='hidden' name='pagename' value='$PageName' />
    <table>",$pagename);
  foreach($PageAttributes as $attr=>$p) {
    $value = (substr($attr,0,6)=='passwd') ? '' : $page[$k];
    $prompt = FmtPageName($p,$pagename);
    echo "<tr><td>$prompt</td>
      <td><input type='text' name='$attr' value='$value' /></td></tr>";
  }
  echo "</table><input type='submit' /></form>";
}

function HandleAttr($pagename) {
  global $HandleAttrFmt,$PageStartFmt,$PageAttrFmt,$PageEndFmt;
  $page = RetrieveAuthPage($pagename,"attr");
  if (!$page) { Abort("?unable to read $pagename"); }
  SetPageVars($pagename,$page,"Edit $pagename Attributes");
  SDV($HandleAttrFmt,array(&$PageStartFmt,
    &$PageAttrFmt,'function:PrintAttrForm',
    &$PageEndFmt));
  PrintFmt($pagename,$HandleAttrFmt);
}

function HandlePostAttr($pagename) {
  global $PageAttributes;
  $page = RetrieveAuthPage($pagename,"attr");
  if (!$page) { Abort("?cannot get $pagename"); }
  foreach($PageAttributes as $k=>$v) {
    $newpw = $_POST[$k];
    if ($newpw=="clear") unset($page[$k]);
    else if ($newpw>"") $page[$k]=crypt($newpw);
  }
  WritePage($pagename,$page);
  Redirect($pagename);
  exit;
}

?>
