<?php

// 
// This is the form end users use to submit modifications to their apps to the database.
// A modified app is actually a new record with a pointer to the old one.  Once an administrator
// approves the new one the status is changed to active and the old one is removed from the system.
// This has the added benefit of bringing it to the top of the "newest applications" list.
// 

require_once("apps.inc");

commonHeader('Edit your Application', false);
appHeader();

print("<h1>Edit Your PHPGTK Application</h1>");

// 
// if the form was submitted add it to the databas
// 
if( $action == "modify" ) {
	$res = mysql_query("SELECT * FROM app WHERE id = $app_id");
	if( $res ) {
		$app = mysql_fetch_object($res);
		if( $app->submitter == $submitter ) {

			if( !empty($_FILES[screenshot][name]) && ereg("^image/", $_FILES[screenshot][type]) )  {
				$has_screenshot = 'Y';
			}else {
				$has_screenshot = 'N';
			}

			$res = mysql_query("
					INSERT INTO app
					(id, modify_id, status, cat_id, date_added, name, has_screenshot, homepage_url, submitter, blurb)
					VALUES
					(0, $app->id, 'M', $cat_id, NOW(), '$name', '$has_screenshot', '$homepage_url', '$submitter', '$blurb')
				");

			if( $res == true ) {

				if( $has_screenshot == 'Y' ) {
					$app_id = mysql_insert_id();

					handleAppImage($_FILES[screenshot][tmp_name], $app_id);
					
				}
				

				print("Thank you for the update.  Someone will review it shortly.");
			}else {
				print("There was a problem with your update.  Please try it again.");
				print("<br>");
				print("Error: (" . mysql_errno() . ") " . mysql_error() );
			}
	
		}else {
			print("<p><b>Sorry, the email address you entered does not match the address on file for this application.</b></p>");
		}
	}else {
		print("<p><b>Unable to find app #$app_id for editing.</b></p>");
	}

	
	
}else if( $action == "edit" ) {
	$res = mysql_query("SELECT * FROM app WHERE id = $app_id");
	if( $res ) {
		$form_app = mysql_fetch_object($res);
		$form_app->submitter = "";
		$form_url = "edit.php";
		$form_action = "modify";
		$form_submit = "Edit";

		print("Please enter your email again for security purposes.");
		include_once("form.php");

		appFooter();
		commonFooter();
		exit;
	}else {
		print("<p><b>Unable to find app #$app_id for editing.</b></p>");
	}
}else if( $action == "list" ) {
	$email = ereg_replace("'", "", $email);
	$res = mysql_query("SELECT * FROM app WHERE status = 'A' AND submitter = '$email' ORDER BY name");
	$num_rows = mysql_num_rows($res);
	if( $res && $num_rows > 0 ) {
		print("<table border=0 cellpadding=2 cellspacing=0 width=100%>");
		while( $row = mysql_fetch_object($res) )  {
			displayApp($row, $the_cat, $the_subcat, 0, true);
		}
		print("</table>");
	}else {
		print("Unable to find any applications that you submitted.");
	}
}else {
	print("
		<form action='edit.php' method=post>
			<input type=hidden name='action' value='list'>

			Please enter your email address.
			<br>
			<br>
			<input type=text name='email'>
			<input type=submit value='Continue'>
			<br>
			<br>
			Your email address will be used to locate applications that you have submitted.
		</form>
	");
}

appFooter();
commonFooter(false);

?>
