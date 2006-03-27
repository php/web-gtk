<?php
/* $Id$ */

commonHeader('Show Source');

$url = $_GET['url'];

if (strpos($url, "manual1/") !== FALSE) {
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

print('This feature is currently disabled.<br /><br /><br /><br /><br />');
/*
?>

Source of: <?php echo $url; ?><br />

<?php

hdelim(); 

$legal_dirs = array(
    "/manual1/$lang" => 1,
    "/include" => 1,
    "/stats" => 1);

$dir = dirname($url);
if ($dir && $legal_dirs[$dir]) {
    $page_name = realpath($url);
} else {
    $page_name = basename($url);
}

if (file_exists($page_name) && !is_dir($page_name)) {
    show_source($page_name);
} elseif (is_dir($page_name)) {
    echo "<p>No file specified.  Can't show source for a directory.</p>\n";
}

echo hdelim(); 

?>
<p>If you're interested in what's behind the <strong>commonHeader()</strong> 
    and <strong>commonFooter()</strong> functions, you can always take a look 
    at the source of the <?php print_link('/source.php?url=/include/layout.php', 'layout.php'); ?> 
    files. And, of course, if you want to see the source of this page, have a 
    look <?php print_link("/source.php?url=/source.php", "here"); ?>.</p>
<?
*/
commonFooter();

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
?>
