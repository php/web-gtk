<?php

commonHeader('Show Source');

$url = substr($_SERVER[REQUEST_URI], 16);

if(strstr($url, "manual/")) {
	$lang = substr($url, 8, 2);
	}

	switch($lang) {
		case "pt":
			$lang = "pt_BR";
		case in_array($lang, $man_languages):
			$lang = $lang;
			break;
		default:
			echo "Language not recognised.";
			commonFooter();
			exit;
	}
?>
Source of: <? echo $url; ?><BR>

<?

hdelim(); 

$legal_dirs = array(
	"/manual/$lang" => 1,
	"/include" => 1,
	/*"/apps" => 1, 
	NB This wasn't legal in the original - should it be? -sf */
	"/stats" => 1);

$dir = dirname($url);
if ($dir && $legal_dirs[$dir]) {
    $page_name = $_SERVER['DOCUMENT_ROOT'].$url;
} else {
    $page_name = basename($url);
}

if (file_exists($page_name) && !is_dir($page_name)) {
    show_source($page_name);
} else if (is_dir($page_name)) {
    echo "<P>No file specified.  Can't show source for a directory.</P>\n";
}

echo hdelim(); 

?>
<P>
If you're interested in what's behind the <B>commonHeader()</B> and <B>commonFooter()</B> functions, 
you can always take a look at the source of the 
<? print_link("/source.php?url=/include/layout.php", "layout.php"); ?> files.
And, of course, if you want to see the source of this page, have a look 
<? print_link("/source.php?url=/source.php", "here"); ?>.
</P>
<?

commonFooter();
?>