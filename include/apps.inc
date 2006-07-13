<?php

// 
// change this to whatever the correct connection parameters are
// 
mysql_connect("localhost","nobody","");
mysql_select_db("gtk");
// 
// Change this to whomever you want the administrator emails to go to.
// 
$mailto = 'andrei@gravitonic.com';
//$mailto = 'php-gtk-webmaster@lists.php.net';
//$mailto = 'philip+gtk-webmaster@eilio.com';


// 
// this directory must exist and must be writable by the user the webserver runs as
// 
define("APP_SCREENSHOT_DIR", "screenshots");

// 
// this is the structure that defines the categories.  Just be sure that all of the id numbers are unique
// and you can do whatever you want.  note that you can only have two levels.. you can't nest forever.
// 
$appCats[100]->name = "Code Snippets";
$appCats[200]->name = "Database";
$appCats[300]->name = "Games/Entertainment";
$appCats[400]->name = "Internet";
	$appCats[400]->sub[410]->name = "Email";
	$appCats[400]->sub[420]->name = "WWW";

$appCats[500]->name = "Multimedia";
	$appCats[500]->sub[510]->name = "MP3";

$appCats[600]->name = "Other";

$appCats[700]->name = "Security";
$appCats[800]->name = "Software Development";
$appCats[900]->name = "Utilities";


// 
// This function buils a select menu containing the categories.  It's used in a
// couple of different forms
// 
function makeAppSelectMenuOptions($selected_id = "") {
	global $appCats;

	foreach( $appCats as $cat_id => $catObj ) {
		if( $cat_id == $selected_id ) {
			$str .= "<option value='$cat_id' selected>$catObj->name";
		}else {
			$str .= "<option value='$cat_id'>$catObj->name";
		}
		
		if( is_array($catObj->sub) )  {
			foreach( $catObj->sub as $subcat_id => $subcatObj ) {
				if( $subcat_id == $selected_id ) {
					$str .= "<option value='$subcat_id' selected> &nbsp; &nbsp; &nbsp; - $subcatObj->name";
				}else {
					$str .= "<option value='$subcat_id'> &nbsp; &nbsp; &nbsp; - $subcatObj->name";
				}
			}
		}
	}

	return($str);
}




// 
// This is a local "header" function that well, spits out the header code
// 
function appHeader($the_cat = false, $the_subcat = false) {
	global $appCats, $MAGIC_COOKIE;

	if( $_SERVER['SCRIPT_NAME'] == "/apps/admin-apps.php" ) {
		$script = "/apps/admin-apps.php";
	}else {
		$script = "/apps/";
	}

	if( !empty($the_cat) )  {
		$this_cat = $the_cat;
		if( !empty($the_subcat) ) {
			$this_cat = $the_subcat;
		}
	}

?>
<table cellpadding="0" cellspacing="0" border="0">
 <tr valign="top">
  <td bgcolor="#f0f0f0">
   <table width="170" cellpadding="4" cellspacing="0">
    <tr valign="top">
     <td class="sidebar">
	 	<table border="0" cellpadding="4" cellspacing="0" width="160">
			<tr valign="top">
				<td><a href="./"><img src="/gifs/caret-t.gif" border="0" width="11" height="7" alt="Applications"/>Applications</a><br/></td>
			</tr>
			<tr valign="top">
			<td style="white-space: nowrap"><small>
				<?php if( isset($MAGIC_COOKIE) ) { ?>
					&nbsp; &nbsp; &nbsp; <a href="admin-apps.php?key=modified"><img src="/gifs/box-0.gif" border="0" width="11" height="7" alt="">Modified Applications</a><br/>
					&nbsp; &nbsp; &nbsp; <a href="admin-apps.php"><img src="/gifs/box-0.gif" border="0" width="11" height="7" alt="">Pending Applications</a><br/>
					<br/>
				<?php } ?>
				&nbsp; &nbsp; &nbsp; <a href="add.php?cat_id=<?php print($this_cat) ?>"><img src="/gifs/box-0.gif" border="0" width="11" height="7" alt=""/>Add Application</a><br/>
				&nbsp; &nbsp; &nbsp; <a href="edit.php"><img src="/gifs/box-0.gif" border="0" width="11" height="7" alt=""/>Edit Your Application</a><br/>
				<br/>
				&nbsp; &nbsp; &nbsp; <a href="<?php print($script) ?>?key=new"><img src="/gifs/box-0.gif" border="0" width="11" height="7" alt=""/>Newest Applications</a><br/>
				&nbsp; &nbsp; &nbsp; <a href="<?php print($script) ?>?key=rating"><img src="/gifs/box-0.gif" border="0" width="11" height="7" alt=""/>Highest Rated Applications</a><br/>
			</small></td>
			</tr>
			<tr bgcolor="#cccccc"><td></td></tr>

<?php

// 
// loop through the categories and display the left hand navigation
// 
foreach( $appCats as $cat_id => $catObj ) {
	print("<tr valign=\"top\">");

	if( $_GET['the_cat'] == $cat_id ) {
		$img = "/gifs/box-1.gif";
	}else {
		$img = "/gifs/box-0.gif";
	}
	print("<td style='white-space: nowrap'><a href=\"$script?the_cat=$cat_id\"><img src=\"$img\" border=\"0\" width=\"11\" height=\"7\" alt=\"$catObj->name\" />$catObj->name</a><br/></td>");
	print("</tr>");
	
	if( $_GET['the_cat'] == $cat_id && is_array($catObj->sub) )  {
		print("<tr valign=\"top\">");
		print("<td style='white-space: nowrap'><small>");
		foreach( $catObj->sub as $subcat_id => $subcatObj ) {
			if( $_GET['the_subcat'] == $subcat_id ) {
				$img = "/gifs/box-1.gif";
			}else {
				$img = "/gifs/box-0.gif";
			}
			print("&nbsp; &nbsp; &nbsp; <a href=\"$script?the_cat=$cat_id&the_subcat=$subcat_id\"><img src=\"$img\" border=\"0\" width=\"11\" height=\"7\" alt=\"$subcatObj->name\" />$subcatObj->name</a><br/>");
		}
		print("</small></td>");
		print("</tr>");
	}
	
}

?>

		</table>
	</td>
    </tr>
   </table>
  </td>
  <td bgcolor="#cccccc" style="background-image: url(/gifs/checkerboard.gif)"><img src="/gifs/spacer.gif" width="1" height="1" border="0" alt="" /><br/></td>
  <td>
   <table width="600" cellpadding="10" cellspacing="0">
    <tr>
     <td valign="top">
<?php
}




// 
// This is the corresponding "footer" function
// 
function appFooter() {
?>
      	<br/>
     </td>
    </tr>
   </table>
  </td>
 </tr>
</table>
<?php
}




// 
// This function displays exactly one application and depending on $user_edit_mode and $MAGIC_COOKIE
// will display slightly different things such as administration options, etc.
// 
function displayApp($app, $the_cat, $the_subcat, $offset, $user_edit_mode = false) {
	global $appCats, $MAGIC_COOKIE;
	
	if( $app->rating <= 0 ) {
		$rating = "n/a";
	}else {
		$rating = sprintf("%.1f", $app->rating);
	}

	if( $app->has_screenshot == 'Y' ) {
		$screenshot = "<a href='screenshot.php/$app->id.jpg' target='apppop'><img src='screenshot.php/$app->id-thumb.jpg' alt='' align='right' border='0'/></a>";
	}else {
		$screenshot = "";
	}

	
	print("
		<tr valign=top bgcolor='#e0e0e0'>
			<td><b>$app->name</b></td>
			<td align='right' style='white-space: nowrap'>
	");
	if( isset($MAGIC_COOKIE) ) {
		if( $app->status == 'P' || $app->status == "M" ) {
			print("<a href='admin-apps.php?action=approve&app_id=$app->id' title='Approve'><img src='/gifs/notes-add.gif' width=13 height=13 border=0 alt='Approve'/></a> ");
		}
		print("<a href='admin-apps.php?action=edit&app_id=$app->id' title='Edit'><img src='/gifs/notes-edit.gif' width=13 height=13 border=0 alt='Edit'/></a> ");
		if( $app->status == 'P' || $app->status == "M" ) {
			print("<a href='admin-apps.php?action=reject&app_id=$app->id' title='Reject' onclick=\"return confirm('Are you sure you want to reject this app?')\"><img src='/gifs/notes-reject.gif' width='13' height='13' border='0' alt='Reject'/></a> ");
		}
		print("<a href='admin-apps.php?action=delete&app_id=$app->id' title='Delete' onclick=\"return confirm('Are you sure you want to delete this app?')\"><img src='/gifs/notes-delete.gif' width='13' height=13 border='0' alt='Delete'/></a> ");
	}else if( $user_edit_mode == true ) {
		print("<a href='edit.php?action=edit&app_id=$app->id'>edit this application</a>");
	}else {
		print("
			<small>
				rating: <b>$rating</b> |
				rate: 
				<a href='rate.php?app_id=$app->id&amp;rate=1&amp;the_cat={$_GET['the_cat']}&amp;the_subcat={$_GET['the_subcat']}&amp;offset=$offset'>1</a> 
				<font color='#999999'>|</font> 
				<a href='rate.php?app_id=$app->id&amp;rate=2&amp;the_cat={$_GET['the_cat']}&amp;the_subcat={$_GET['the_subcat']}&amp;offset=$offset'>2</a> 
				<font color='#999999'>|</font> 
				<a href='rate.php?app_id=$app->id&amp;rate=3&amp;the_cat={$_GET['the_cat']}&amp;the_subcat={$_GET['the_subcat']}&amp;offset=$offset'>3</a> 
				<font color='#999999'>|</font> 
				<a href='rate.php?app_id=$app->id&amp;rate=4&amp;the_cat={$_GET['the_cat']}&amp;the_subcat={$_GET['the_subcat']}&amp;offset=$offset'>4</a> 
				<font color='#999999'>|</font> 
				<a href='rate.php?app_id=$app->id&amp;rate=5&amp;the_cat={$_GET['the_cat']}&amp;the_subcat={$_GET['the_subcat']}&amp;offset=$offset'>5</a>
			</small>
		");
	}
	print("
			</td>
		</tr>
		<tr valign=top bgcolor='#e0e0e0'>
			<td><small><a href='$app->homepage_url' target='apppop'>$app->homepage_url</a></small></td>
			<td align=right><small>$app->date_added</small></td>
		</tr>
	");
	if( isset($MAGIC_COOKIE) ) {
		print("
			<tr valign=top bgcolor='#e0e0e0'>
				<td><small><a href='mailto:$app->submitter'>$app->submitter</a></small></td>
				<td align=right><small>" . $appCats[$app->cat_id]->name . "</small></td>
			</tr>
		");
	}
	print("
		<tr valign=top>
		<td colspan=2>
			$screenshot
			$app->blurb
		</td>
		</tr>
		<tr><td colspan=2><br/></td></tr>
	");
}



// 
// This function handles everything necessary to create the thumbnail of the screenshot,
// resize the screenshot if necessary, and save the files to APP_SCREENSHOT_DIR
// 
function handleAppImage($filename, $app_id) {
	$imgInfo = getimagesize($filename);

	switch($imgInfo[2]) {
		case 1:
			$src = ImageCreateFromGif($filename);
			break;
		case 2:
			$src = ImageCreateFromJpeg($filename);
			break;
		case 3:
			$src = ImageCreateFromPng($filename);
			break;
	}

	$srcWidth = ImageSX($src);
	$srcHeight = ImageSY($src);

	$dstWidth = $srcWidth;
	$dstHeight = $srcHeight;

	if( $srcWidth > 800 )  {
		$dstWidth = 800;
		$dstHeight = floor($srcHeight * $dstWidth/$srcWidth + .5);
	}

	$dst = ImageCreateTrueColor($dstWidth, $dstHeight);
	ImageCopyResampled($dst, $src, 0, 0, 0, 0, $dstWidth, $dstHeight, $srcWidth, $srcHeight);
	ImageJPEG($dst, APP_SCREENSHOT_DIR."/$app_id.jpg", 75);

	$thumbWidth = 120;
	$thumbHeight = floor($dstHeight * $thumbWidth/$dstWidth + .5);

	$thumb = ImageCreateTrueColor($thumbWidth, $thumbHeight);
	ImageCopyResampled($thumb, $dst, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $dstWidth, $dstHeight);
	ImageJPEG($thumb, APP_SCREENSHOT_DIR."/$app_id-thumb.jpg", 75);
}

?>
