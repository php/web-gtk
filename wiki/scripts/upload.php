<?php if (!defined('PmWiki')) exit();
/*  Copyright 2003-2004 Patrick R. Michaud (pmichaud@pobox.com)
    This file is part of PmWiki; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.  See pmwiki.php for full details.

    This file adds upload capabilities to PmWiki.  Uploads can be
    enabled by setting
	$EnableUpload = 1
    in config.php.  In addition, an upload password must be set, and
    some installations may require configuration of the $UploadDir
    and $UploadUrlFmt variables.  See the PmWiki.UploadsAdmin wiki
    page for full details, as it's complicated to explain here.
*/

SDV($EnableUploadOverwrite,1);

SDV($UploadExts,array(
  'gif','jpg','jpeg','png','bmp','ico','wbmp',		# images
  'mp3','au','wav',					# audio
  'mpg','mpeg','wmf','mov','qt','avi',			# video
  'zip','gz','tgz','tar','rpm','hqx','sit',		# archives
  'doc','ppt','xls','exe','mdb',			# MSOffice
  'pdf','psd','ps','ai','eps',				# Adobe
  'htm','html','css','fla','swf',			# web stuff
  'txt','rtf','exe','tex','dvi',''));			# misc

$upname=@$_POST['upname'];
if (@$_GET['upname']) $upname=$_GET['upname'];
$upresult=@$_GET['upresult'];
$upext=@$_GET['upext'];

SDV($UploadMaxSize,50000);
SDV($UploadPrefixQuota,0);
SDV($UploadDirQuota,0);
SDV($UploadPerms,0666 & ~umask());
foreach($UploadExts as $ext) 
  if (!isset($UploadExtSize[$ext])) 
    $UploadExtSize[$ext]=$UploadMaxSize;
$upextmax = @$UploadExtSize[$upext];

SDV($UploadDir,'uploads');
SDV($UploadUrlFmt,preg_replace("#/[^/]*\$#","/$UploadDir",$ScriptUrl,1));
SDV($UploadPrefixFmt,'/$Group/');
SDV($UploadNamePattern,'[A-Za-z0-9][-\w.]*[A-Za-z0-9]');
SDV($UploadVerifyFunction,"UploadVerifyBasic");
SDV($PageUploadFmt,array("<h1 class='wikiaction'>$[Attachments for] \$PageName</h1>
  <h3>\$UploadResult</h3>
  <form enctype='multipart/form-data' action='\$ScriptUrl' method='post'>
  <input type='hidden' name='pagename' value='\$PageName' />
  <input type='hidden' name='action' value='postupload' />
  <input type='hidden' name='upname' value='\$UploadName' />
  <table border='0'>
    <tr><td align='right'>$[File to upload:]</td><td><input 
      name='uploadfile' type='file' /></td></tr>
    <tr><td align='right'>$[Name attachment as:]</td>
      <td><input type='text' name='upname' 
        value='\$UploadName' />
        <input type='submit' value=' $[Upload] ' /><br />
      </td></tr>
  </table>
  </form>",'wiki:$[PmWiki.UploadQuickReference]')); 
SDV($HandleUploadFmt,array(&$PageStartFmt, &$PageUploadFmt, &$PageEndFmt));
SDV($UploadFileFmt,"$UploadDir$UploadPrefixFmt");
SDV($RecentUploads, array(
  'Main.AllRecentUploads' => 
    "[[$UploadUrlFmt$UploadPrefixFmt\$UploadName \$UploadName]]",
  '$Group.RecentUploads' => '[[Attach:$UploadName $UploadName]]'));
XLSDV('en',array(
  'ULsuccess' => 'successfully uploaded',
  'ULbadname' => 'invalid attachment name',
  'ULbadtype' => '\'$upext\' is not an allowed file extension',
  'ULtoobig' => 'file is larger than maximum allowed by webserver',
  'ULtoobigext' => 'file is larger than allowed maximum of $upextmax
     bytes for \'$upext\' files',
  'ULpartial' => 'incomplete file received',
  'ULnofile' => 'no file uploaded',
  'ULexists' => 'file with that name already exists',
  'ULpquota' => 'group quota exceeded',
  'ULtquota' => 'upload quota exceeded'));
SDV($PageAttributes['passwdupload'],'$[Set new upload password]: ');
SDV($DefaultPasswords['upload'],'*');

SDV($LinkPatterns[120]["\\bAttach:($UploadNamePattern)"],'FmtAttachLink');
SDV($InterMapUrls['Attach'],
  FmtPageName("$UploadUrlFmt$UploadPrefixFmt$1",$pagename));
SDV($InlineReplacements['/\\[\\[\\$Attachlist\\s*(.*)\\]\\]/e'],
  "'<ul>'.FmtUploadList('$pagename','$1').'</ul>'");

$UploadName = $upname; $UploadResult='';
if ($upresult) 
  $UploadResult = "<i>$upname</i>: ".FmtPageName("$[UL$upresult]",$pagename);
if ($upresult=='success') $UploadName = "";

mkgiddir($UploadDir);
SDV($WikiLibDirs,array($WikiDir,"wikilib.d"));
SDV($HandleActions['upload'],'HandleUpload');
SDV($HandleActions['postupload'],'HandlePostUpload');

function FmtAttachLink($pat,$ref,$txt) {
  global $UploadName,$UploadFileFmt,$pagename,$UploadFormTarget,$FmtUrlLink;
  preg_match("/^([^:]*):(.*)$/",$ref,$match);
  $rtxt=$ref;  if (!is_null($txt)) $rtxt=$txt;
  $UploadName = $match[2];
  $filepath = FmtPageName($UploadFileFmt,$pagename).$UploadName;
  if (!file_exists($filepath)) {
    $target = ($UploadFormTarget) ? "target='$UploadFormTarget'" : '';
    return "$rtxt<a href='".FmtPageName('$PageUrl?action=upload',$pagename).
      "&amp;upname=".urlencode($UploadName)."' $target>?</a>";
  }
  return $FmtUrlLink($pat,$ref,$txt);
}

function HandleUpload($pagename) {
  global $UploadList,$HandleUploadFmt;
  $page = RetrieveAuthPage($pagename,'upload');
  if (!$page) { Abort("?cannot upload to $pagename"); }
  SetPageVars($pagename,$page,"$pagename Attachments");
  $UploadList = FmtUploadList($pagename);
  PrintFmt($pagename,$HandleUploadFmt);
}

function HandlePostUpload($pagename) {
  global $HTTP_POST_FILES,$UploadName,$UploadNamePattern,$UploadFileFmt,
    $UploadVerifyFunction,$UploadPerms,$RecentUploads,$TimeFmt,$Now;
  $page = RetrieveAuthPage($pagename,'upload');
  if (!$page) Abort("?cannot upload to $pagename");
  $uploadfile = $HTTP_POST_FILES['uploadfile'];
  if ($UploadName=='') { $UploadName=$uploadfile['name']; }
  if (!function_exists($UploadVerifyFunction)) 
    Abort("?no UploadVerifyFunction available");
  $filepath = FmtPageName($UploadFileFmt,$pagename).$UploadName;
  $result = $UploadVerifyFunction($pagename,$uploadfile,$filepath);
  if ($result=='') {
    $filedir = preg_replace('/[^\\/]*$/','',$filepath);
    mkgiddir($filedir);
    if (!move_uploaded_file($uploadfile['tmp_name'],$filepath))
      { Abort("?cannot move uploaded file to $filepath"); return; }
    chmod($filepath,$UploadPerms);
    foreach($RecentUploads as $rcfmt => $pgfmt) {
      $rcname=FmtPageName($rcfmt,$pagename); if (!$rcname) continue;
      $pgname=FmtPageName($pgfmt,$pagename); if (!$pgname) continue;
      if (@$seen[$rcname]++) continue;
      $rcpage = ReadPage($rcname,"");
      $rcpage['text'] = "* $pgname . . . . . . ".strftime($TimeFmt,$Now)."\n".
        preg_replace("%\\* ".preg_quote($pgname)." .*?\n%","",
          $rcpage['text']);
      WritePage($rcname,$rcpage);
    }
    $result = "upresult=success";
  }
  Redirect($pagename,
    '$PageUrl?action=upload&upname='.urlencode($UploadName)."&$result");
}  

function dirsize($dir) {
  $size=0;
  $dirp = @opendir($dir);
  if (!$dirp) return 0;
  while (($file=readdir($dirp)) !== false) {
    if ($file[0]=='.') continue;
    if (is_dir("$dir/$file")) $size+=dirsize("$dir/$file");
    else $size+=filesize("$dir/$file");
  }
  closedir($dirp);
  return $size;
}

function UploadVerifyBasic($pagename,$uploadfile,$filepath) {
  global $UploadName,$UploadNamePattern,$UploadExtSize,$EnableUploadOverwrite,
    $UploadPrefixQuota,$UploadDirQuota,$UploadDir;
  if (!$EnableUploadOverwrite && file_exists($filepath))
    return 'upresult=exists';
  preg_match('/\\.([^.]+)$/',$filepath,$match); $ext=@$match[1];
  $maxsize = $UploadExtSize[$ext];
  if ($maxsize<=0) return "upresult=badtype&upext=$ext";
  if ($uploadfile['size']>$maxsize) return "upresult=toobigext&upext=$ext";
  if (!is_uploaded_file($uploadfile['tmp_name'])) return 'upresult=nofile';
  switch ($uploadfile['error']) {
    case 1: return 'upresult=toobig';
    case 2: return 'upresult=toobig';
    case 3: return 'upresult=partial';
    case 4: return 'upresult=nofile';
  }
  $filedir = preg_replace('/\\/[^\\/]*$/','',$filepath);
  if ($UploadPrefixQuota &&
      (@(dirsize($filedir)-filesize($filepath)+$uploadfile['size'])
      > $UploadPrefixQuota)) return 'upresult=pquota';
  if ($UploadDirQuota &&
      @(dirsize($UploadDir)-filesize($filepath)+$uploadfile['size'])
      > $UploadDirQuota) return 'upresult=tquota';
  return '';
}

function FmtUploadList($pagename,$order='N=A') {
  global $UploadDir,$UploadPrefixFmt,$UploadUrlFmt,$TimeFmt;
  $uploaddir = FmtPageName("$UploadDir$UploadPrefixFmt",$pagename);
  $uploadurl = FmtPageName("$UploadUrlFmt$UploadPrefixFmt",$pagename);
  if ($order=='') $order='N=A';
  $dirp = @opendir($uploaddir);
  $out = '';
  if (!$dirp) return $out;
  $filelist = array();
  while (($file=readdir($dirp)) !== false) {
    if ($file[0]=='.') continue;
    switch (strtolower($order[0])) {
      case 'm': $filelist[$file]=filemtime("$uploaddir$file"); break;
      case 's': $filelist[$file]=filesize("$uploaddir$file"); break;
      default: $filelist[$file]=$file; break;
    }
  }
  closedir($dirp);
  if (strtolower($order[2])=='d') arsort($filelist); else asort($filelist);
  foreach($filelist as $file=>$x) {
    $stat = stat("$uploaddir/$file");
    $out .= "<li> <a href='$uploadurl$file'>$file</a> ... "
      .$stat['size']." bytes ... ".strftime($TimeFmt,$stat['mtime'])."\n</li>";
  }
  return $out;
}

?>
