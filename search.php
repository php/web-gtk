<?

if(isset($pattern) && ($pattern) && isset($show) && ($show == "manual"))
{
	$location = "/manual-lookup.php";
	$query = "lang=en&function=".urlencode($pattern);
	Header("Location: ".$location."?".$query);
	exit;
}

if (isset($pattern) && ($pattern)) {
	SetCookie("prevsearch",$pattern,0,"",".php.net");
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
