<?php

// 
// this is the "add an app" form that end users use.  
// 

require_once("apps.inc");

// 
// Change this to whomever you want the administrator emails to go to.
// 
$mailto = 'gtk-webmaster@php.net';

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

		if( $has_screenshot == 'Y' ) {
			$app_id = mysql_insert_id();

			handleAppImage($_FILES[screenshot][tmp_name], $app_id);
			
		}
		
		mail($mailto, "app '$name' submitted for approval.",
			"The following application was submitted for approval:\n\n" .
			"Name       : $name\n" .
			"URL        : $homepage_url\n" .
			"Category   : " . $appCats[$cat_id]->name . "\n" .
			"Submitter  : $submitter\n" .
			"Description: $blurb\n",
			"From: $user@php.net");

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
