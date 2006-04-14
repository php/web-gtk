<?php
if(isset($_POST['pattern'])) {
    $pattern = $_POST['pattern'];
	}
elseif(isset($_GET['function'])) {
	$pattern = $_GET['function'];
	}
$show = $_POST['show'];

if(isset($pattern) && ($pattern) && isset($show) && ($show == "manual")) {
    $location = "/manual-lookup.php";
    $query = "q=".urlencode($pattern);
    Header("Location: ".$location."?".$query);
    exit;
}

if(isset($pattern) && ($pattern) && isset($show) && ($show == "manual1")) {
	/* ALTER FOR LOCAL $location = "manual1-lookup.php"; */
	$location = "/manual1-lookup.php";
	$query = "function=".urlencode($pattern);
	Header("Location: ".$location."?".$query);
	exit;
}

if(isset($pattern) && ($pattern) && isset($show) && ($show == "whole-site")) {
    $pattern .= ' site:gtk.php.net ';
    $query = urlencode($pattern);
    $location = 'http://search.yahoo.com/search?ei=UTF-8&p=' . $query;
	Header("Location: ".$location);
	exit;
}

if(isset($pattern) && ($pattern) && isset($show) && ($show == "wiki")) {
    $query = urlencode($pattern);
    $location = '/wiki/Main/SearchWiki?text=' . $query;
	Header("Location: ".$location);
	exit;
}

if (isset($pattern) && ($pattern)) {
	$location = "http://marc.theaimsgroup.com/";
	if (substr($show, -5) == "-list") {
		$list = substr($show, 0, -5);
		$query = "l=$list&w=2&r=1&q=b&s=".urlencode($pattern);
		Header("Location: ".$location."?".$query);
		exit;
	}
}

?>
