<?php
if(isset($_POST['pattern'])) {
    $pattern = $_POST['pattern'];
	}
elseif(isset($_GET['function'])) {
	$pattern = $_GET['function'];
	}
$show = $_POST['show'];

if(isset($pattern) && ($pattern) && isset($show) && ($show == "manual")) {
	/* ALTER FOR LOCAL $location = "manual-lookup.php"; */
	$location = "/manual-lookup.php";
	$query = "function=".urlencode($pattern);
	Header("Location: ".$location."?".$query);
	exit;
}

if(isset($pattern) && ($pattern) && isset($show) && ($show == "whole-site")) {
    $pattern .= ' site:gtk.php.net -site:wiki.gtk.php.net';
    $query = urlencode($pattern);
    $location = 'http://www.google.com/search?hl=en&lr=&ie=UTF-8&q=' . $query . '&btnG=Search';
	Header("Location: ".$location);
	exit;
}

if(isset($pattern) && ($pattern) && isset($show) && ($show == "wiki")) {
    $query = urlencode($pattern);
    $location = '/wiki/index.php/Main/SearchWiki?text=' . $query;
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
