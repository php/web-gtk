<?php

// 
// This is the main administration page where approvals, rejections, deletions, etc. take place
// 

//require_once("cvs-auth.inc");
require_once("email-validation.inc");
require_once("apps.inc");


if( isset($MAGIC_COOKIE) ) {
	list($user, $pass) = explode(":", base64_decode($MAGIC_COOKIE));
}

//if( !verify_password($user,$pass) ) {
//	Header("Location: /admin-login.php");
//	exit;
//}

$MAGIC_COOKIE = 'temp';


commonHeader("Applications Administration");
appHeader($the_cat, $the_subcat);

print("
	<h1>Applications Administration</h1>
	If you just want to browse the applications, you're better off <A href='/apps/'>here</A>.
	<hr noshade size=1>
");


// 
// this block contains all the actions the script can take.  if we can't authenticate
// or find the app in question we bail out.
// 
if( !empty($action) && !empty($app_id) ) {

	if( !verify_password($user,$pass) ) {
		echo "<P><B>Authorization failed.</B></P>";
		appFooter();
		commonFooter();
		exit;
	}

	$res = mysql_query("SELECT * FROM app WHERE id = $app_id");
	if( $res ) {
		$app = mysql_fetch_object($res);
	}else {
		print("<p><b>Unable to find app #$app_id.</b></p>");
		appFooter();
		commonFooter();
		exit;
	}

	switch($action) {
	
	case 'approve':
		if( !empty($app->modify_id) ) {
			$res = mysql_query("UPDATE app SET status = 'A' WHERE id = $app_id");
			$res = mysql_query("DELETE FROM app WHERE id = $app->modify_id");
			@unlink(APP_SCREENSHOT_DIR . "/$app->modify_id-thumb.jpg");
			@unlink(APP_SCREENSHOT_DIR . "/$app->modify_id.jpg");
		}else {
			$res = mysql_query("UPDATE app SET status = 'A' WHERE id = $app_id");
		}
		if( $res ) {
			$msg = "Application #$app_id approved.";
		}else {
			$msg = "Unable to approve application #$app_id.";
		}
		print("<script language='JavaScript'> alert('$msg'); document.location.href = 'admin-apps.php';</script>");
		break;

	case 'delete':
		$res = mysql_query("DELETE FROM app WHERE id = $app_id");

		if( $res ) {
			@unlink(APP_SCREENSHOT_DIR . "/$app_id-thumb.jpg");
			@unlink(APP_SCREENSHOT_DIR . "/$app_id.jpg");

			mail($mailto, "app #$app->id deleted by $user",
				"The following application was deleted from the system:\n\n" .
				"Name       : $app->name\n" .
				"Category   : " . $appCats[$app->cat_id]->name . "\n" .
				"Submitter  : $app->submitter\n" .
				"Description: $app->blurb\n",
				"From: $user@php.net");

			$msg = "Application #$app_id deleted.";
		}else {
			$msg = "Unable to delete application #$app_id.";
		}

		print("<script language='JavaScript'> alert('$msg'); document.location.href = 'admin-apps.php';</script>");
		break;

	
	case 'reject':
		$reject_text  = "If you are receiving this email it is because your application\n";
		$reject_text .= "posted to the on-line PHP-GTK application database has been\n";
		$reject_text .= "rejected by one of the editors.\n\n";
		$reject_text .= "This is most likely due to the fact that your submission does\n";
		$reject_text .= "not appear to be a geniune PHP-GTK application.\n\n";

		$res = mysql_query("DELETE FROM app WHERE id = $app_id");

		if( $res ) {
			@unlink(APP_SCREENSHOT_DIR . "/$app_id-thumb.jpg");
			@unlink(APP_SCREENSHOT_DIR . "/$app_id.jpg");


			// email the submitter if the address looks reasonable
			// uses functions in include/email-validation.inc
			$submitter = clean_AntiSPAM($app->submitter);
			if (is_emailable_address($submitter)) {
				mail($submitter,"app '$app->name' rejected by app editor $user",
					$reject_text .
					"----- Copy of your submission below -----\n\n" .
					"Name       : $app->name\n" .
					"Category   : " . $appCats[$app->cat_id]->name . "\n" .
					"Description: $app->blurb\n",
					"From: $user@php.net");
			}

			// email to the list
			mail($mailto,"app '$app->name' rejected by app editor $user",
				"The following application was rejected from the system:\n\n" .
				"Name       : $app->name\n" .
				"Category   : " . $appCats[$app->cat_id]->name . "\n" .
				"Description: $app->blurb\n",
				"From: $user@php.net");

			$msg = "Application #$app_id rejected.";
		}else {
			$msg = "Unable to reject application #$app_id.";
		}

		print("<script language='JavaScript'> alert('$msg'); document.location.href = 'admin-apps.php';</script>");

 		break;

	case 'edit':
		$form_app = $app;
		$form_url = "admin-apps.php";
		$form_action = "modify";
		$form_submit = "Edit";

		include_once("form.php");

		appFooter();
		commonFooter();
		exit;

		break;

	case 'modify':
		$app_old = $app;

		if( !empty($_FILES[screenshot][name]) 
			&& ereg("^image/", $_FILES[screenshot][type]) 
			&& !ereg("gif", $_FILES[screenshot][type]) 
		)  {
			$has_new_screenshot = 'Y';
		}else {
			$has_screenshot = 'N';
		}

		if( $has_new_screenshot == "Y" || ($had_screenshot == 1 && $delete_screenshot != 1) ) { 
				$has_screenshot = 'Y';
		}

		$res = mysql_query("
				UPDATE app
				SET
					status = '$status',
					cat_id = $cat_id,
					name = '$name',
					has_screenshot = '$has_screenshot',
					homepage_url = '$homepage_url',
					submitter = '$submitter',
					blurb = '$blurb'
				WHERE id = $app_id
			");

		$res = mysql_query("SELECT * FROM app WHERE id = $app_id");
		$app = mysql_fetch_object($res);

		if( $res == true ) {

			if( $delete_screenshot == 1 ) {
				@unlink(APP_SCREENSHOT_DIR . "/$app_id.jpg");
				@unlink(APP_SCREENSHOT_DIR . "/$app_id-thumb.jpg");
			}

			if( $has_new_screenshot == 'Y' ) {
				handleAppImage($_FILES[screenshot][tmp_name], $app_id);
			}
			
			print("<p><b>Application was edited successfully.</b></p>");

			// email to the list
			mail($mailto,"app '$app->name' modified by app editor $user",
				"The following application was modified from this:\n\n" .
				"-------------------------------------------------\n" .
				"Name       : $app_old->name\n" .
				"Status     : $app_old->status\n" .
				"Category   : " . $appCats[$app_old->cat_id]->name . "\n" .
				"Description: $app_old->blurb\n".
				"\n".
				"to this:\n\n".
				"-------------------------------------------------\n" .
				"Name       : $app->name\n" .
				"Status     : $app->status\n" .
				"Category   : " . $appCats[$app->cat_id]->name . "\n" .
				"Description: $app->blurb\n",
				"From: $user@php.net");

		}else {
			print("<p><b><font color='#ff0000'>");
			print("There was a problem editing the application.");
			print("<br>");
			print("Error: (" . mysql_errno() . ") " . mysql_error() );
			print("</font></b></p>");
		}

		print("<table border=0 cellpadding=2 cellspacing=0 width=100%>");
			displayApp($app, $the_cat, $the_subcat, $offset);
		print("</table>");

		appFooter();
		commonFooter();
		exit;

		break;

	default:
		if( !empty($action) ) {
			print("<p><b><font color='#ff0000'>Error: Didn't understand action '$action'.</font></b></p>");
		}
	}
}



if( empty($the_cat) && empty($the_subcat) && empty($key) ) {
	include("pending.php");
}else if( $key == "modified" ) {
	include("modified.php");
}else {
	include("apps.php");
}

appFooter();
commonFooter();

?>
