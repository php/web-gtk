<?php
	// 
	// This page gets included from a couple of different forms.  
	// It uses the following variables to lay things out correctly.

	// $form_app - an object containing the form properties (usually a result of mysql_fetch_object)
	// $form_url - what url to submit to.
	// $form_action - what the hidden field "action" should have its value set to.
	// $form_submit - what the submit button should say
	// 
?>
<script language='JavaScript'>
<!--

function checkForm(f) {

	if( f.submitter.value.length == 0 )  {
		alert("You must provide your name.");
		f.submitter.focus();
		f.submitter.select();
		return(false);
	}

	if( f.name.value.length == 0 )  {
		alert("You must provide an application name.");
		f.name.focus();
		f.name.select();
		return(false);
	}

	if( f.homepage_url.value.length == 0 )  {
		alert("You must provide a homepage url.");
		f.homepage_url.focus();
		f.homepage_url.select();
		return(false);
	}

	if( f.blurb.value.length == 0 )  {
		alert("You must provide a description.");
		f.blurb.focus();
		f.blurb.select();
		return(false);
	}

	return(true);
}

//-->
</script>

<form action='<?php print($form_url) ?>' method=post enctype='multipart/form-data' onsubmit='return checkForm(this)'>
<input type=hidden name='action' value='<?php print($form_action) ?>'>
<?php 
	if( $form_action == "modify" ) {
		print("<input type=hidden name='app_id' value='$form_app->id'>");
	}
?>

<table border=0 cellpadding=5 cellspacing=0 bgcolor='#e0e0e0'>
<?php 
if( $MAGIC_COOKIE ) {
	print("<tr valign=top>");
		print("<td align=right nowrap>Status:</td>");
		print("<td>");
			$statusAry = array("A" => "Active", "P" => "Pending", "M" => "Modified");	
			print("<select name='status'>");
			foreach( $statusAry as $k => $v ) {
				if( $form_app->status == $k ) {
					print("<option value='$k' selected>$v");
				}else {
					print("<option value='$k'>$v");
				}
			}
			print("</select>");
		print("</td>");
	print("</tr>");
}
?>
<tr valign=top>
	<td align=right nowrap><?php if( $MAGIC_COOKIE ) { print("Submitter"); }else { print("Your"); } ?> Email:</td>
	<td><input type=text name='submitter' value='<?php print($form_app->submitter) ?>' size=50></td>
</tr>
<tr valign=top>
	<td align=right nowrap>Application Name:</td>
	<td><input type=text name='name' value='<?php print($form_app->name) ?>' size=50></td>
</tr>
<tr valign=top>
	<td align=right nowrap>Homepage URL:</td>
	<td><input type=text name='homepage_url' value='<?php print($form_app->homepage_url) ?>' size=50></td>
</tr>
<tr valign=top>
	<td align=right nowrap>Category:</td>
	<td><select name='cat_id'><?php print makeAppSelectMenuOptions($form_app->cat_id); ?></select></td>
</tr>
<tr valign=top>
	<td align=right nowrap>Description:</td>
	<td><textarea name='blurb' rows=7 cols=40><?php print($form_app->blurb) ?></textarea></td>
</tr>
<?php if( $form_action == "modify" && $form_app->has_screenshot == "Y" ) { ?>
	<tr valign=top>
		<td align=right nowrap>Current<br>Screen Shot:</td>
		<td>
			<a href='screenshot.php/<?php print($form_app->id) ?>.jpg' target='apppop'><img src='screenshot.php/<?php print($form_app->id) ?>-thumb.jpg' alt='' border=0></a>
			<br>
			<input type=checkbox name='delete_screenshot' value='1'> Check to delete current screen shot.
			<input type=hidden name='had_screenshot' value='1'>
		</td>
	</tr>
	<tr valign=top>
		<td align=right nowrap>New Screen Shot:</td>
		<td><input type=file name='screenshot'><br><small>(JPEG or PNG only, please)</small></td>
	</tr>
<?php }else { ?>
	<tr valign=top>
		<td align=right nowrap>Screen Shot:</td>
		<td><input type=file name='screenshot'><br><small>(JPEG or PNG only, please)</small></td>
	</tr>
<?php } ?>
<tr valign=top>
	<td align=right nowrap colspan=2>
		<input type=reset value='Reset'>
		<input type=submit value='<?php print($form_submit) ?>'>
	</td>
</tr>
</table>
</form>
