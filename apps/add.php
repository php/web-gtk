<?php

// 
// this is the "add an app" form that end users use.  
// 

require_once("apps.inc");

commonHeader('Add an Application', false);
appHeader();

print("<h1>Add a PHPGTK Application</h1>");

// 
// if the form was submitted add it to the databas
// 
if( $action == "add" ) {

	if( !empty($_FILES[screenshot][name]) && ereg("^image/", $_FILES[screenshot][type]) )  {
		$has_screenshot = 'Y';
	}else {
		$has_screenshot = 'N';
	}

	$res = mysql_query("
			INSERT INTO app
			(id, status, cat_id, date_added, name, has_screenshot, homepage_url, submitter, blurb)
			VALUES
			(0, 'P', $cat_id, NOW(), '$name', '$has_screenshot', '$homepage_url', '$submitter', '$blurb')
		");

	if( $res == true ) {

		$app_id = mysql_insert_id();

		if( $has_screenshot == 'Y' ) {
			$app_id = mysql_insert_id();

			handleAppImage($_FILES[screenshot][tmp_name], $app_id);

			$screen_shot_link = "Screenshot : http://$_SERVER[SERVER_NAME]/apps/screenshot.php/$app_id.jpg\n";
			
		}
		
		mail($mailto, "app '$name' submitted for approval.",
			"The following application was submitted for approval:\n\n" .
			"Name       : $name\n" .
			"URL        : $homepage_url\n" .
			"Category   : " . $appCats[$cat_id]->name . "\n" .
			"Submitter  : $submitter\n" .
			$screen_shot_link .
			"Description: $blurb\n" .
			"\n" .
			"Administrative Actions\n" .
			"----------------------\n" .
			"Approve: http://$_SERVER[SERVER_NAME]/apps/admin-apps.php?action=approve&app_id=$app_id\n" .
			"Edit: http://$_SERVER[SERVER_NAME]/apps/admin-apps.php?action=edit&app_id=$app_id\n" .
			"Reject: http://$_SERVER[SERVER_NAME]/apps/admin-apps.php?action=reject&app_id=$app_id\n" .
			"Delete: http://$_SERVER[SERVER_NAME]/apps/admin-apps.php?action=delete&app_id=$app_id\n" .
			"",
			"From: $mailto");

		print("Thank you for the submission.  Someone will review it shortly.");
	}else {
		print("There was a problem with your submission.  Please try it again.");
		print("<br>");
		print("Error: (" . mysql_errno() . ") " . mysql_error() );
	}
	
}else {
	$form_app = (object) 0;
	if( !empty($cat_id) ) { 
		$form_app->cat_id = $cat_id;
	}
	$form_url = "add.php";
	$form_action = "add";
	$form_submit = "Add";
	include_once("form.php");
}

appFooter();
commonFooter(false);

?>
