<?php

// 
// this file gets included from a couple of different places and depending on the values of $this_cat
// and $key will run slightly different queries to prodocue the appropriate list of applications
// 

require_once("apps.inc");

$limit = 10;
if( empty($offset) ) {
	$offset = 0;
}

if( !empty($the_cat) )  {
	$title = " : " . $appCats[$the_cat]->name;
	$this_cat = $the_cat;
	if( !empty($the_subcat) ) {
		$title .= " : " . $appCats[$the_cat]->sub[$the_subcat]->name;
		$this_cat = $the_subcat;
	}
}

if( !empty($this_cat) )  {
	if( is_array($appCats[$this_cat]->sub) )  {
		$these_cats = $this_cat . "," . join(",", array_keys($appCats[$this_cat]->sub));
		$res = mysql_query("SELECT * FROM app WHERE status = 'A' AND cat_id IN ($these_cats) ORDER BY name LIMIT $offset,$limit");
	}else {
		$res = mysql_query("SELECT * FROM app WHERE status = 'A' AND cat_id = $this_cat ORDER BY name LIMIT $offset,$limit");
	}

	print("<h1>Applications $title</h1>");

}else if( $key == "new" ) {
	$res = mysql_query("SELECT * FROM app WHERE status = 'A' ORDER BY date_added DESC LIMIT $offset,$limit");

	print("<h1>Applications : New</h1>");

}else if( $key == "rating" ) {
	$res = mysql_query("SELECT * FROM app WHERE status = 'A' ORDER BY rating DESC LIMIT $offset,$limit");

	print("<h1>Applications : Highest Rating</h1>");

}else {
	$res = mysql_query("SELECT * FROM app WHERE status = 'A' ORDER BY date_added DESC LIMIT 4");

	print("
		<h1>Applications</h1>

		Here you will find PHP-GTK applications.  If you know of an application that
		isn't in this database you can add it via the link on the left.  If there is a category
		that you think should be added to this database please
		<a href='mailto:gtk-webmaster@php.net'>email the webmaster</a>.	
		
		<h3>Newest Applications</h3>
	");


}

$num_rows = mysql_num_rows($res);
if( $res && $num_rows > 0 ) {
	print("<table border=0 cellpadding=2 cellspacing=0 width=100%>");
	while( $row = mysql_fetch_object($res) )  {
		displayApp($row, $the_cat, $the_subcat, $offset);
	}
	print("</table>");

	if( $num_rows >= $limit ) {
		print("<br>");
		print("<p align=right>");
		print("<small>");

		if( !empty($this_cat) )  {
			print("<a href='index.php?the_cat=$the_cat&the_subcat=$the_subcat&offset=" . ($offset + $limit) . "'>see more applications...</a>&nbsp;&nbsp;");
		}else if( !empty($key) ) {
			print("<a href='index.php?key=$key&offset=" . ($offset + $limit) . "'>see more applications...</a>&nbsp;&nbsp;");
		}else {
			print("<a href='index.php?key=new'>see more new applications...</a>&nbsp;&nbsp;");
		}

		print("</small>");
		print("</p>");
		print("<br>");
		print("<br>");
	}
}else {
	if( $offset > 0 ) {
		print("There are no more applications in this category.");
	}else {
		print("There are not any applications in this category.");
		print("<br>");
		print("<br>");
		print("Maybe you'd like to <a href='add.php?cat_id=$this_cat'>add one</a>?");

	}
}

?>
