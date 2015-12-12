<?php
// Include the prepend file.
require_once 'prepend.php';

/**
 * Output a page not found message.
 *
 * @access public
 * @return void
 */
function make404() {
	// Send the HTTP header.
	header('HTTP/1.0 404 Not Found');
	// Output a header for page not found.
	commonHeader('404 Not Found');
	// Output a message telling the user the page was not found.
	echo "<H1>Not Found</H1>\n";
	echo "<P>The page <B>" . htmlspecialchars($_SERVER['REQUEST_URI']) . "</B> could not be found.</P>\n";
	// Output the footer.
	commonFooter();
}

// Get the configuration file.
if (file_exists("../configuration.inc")) {
  include_once "../configuration.inc";
}

// Clean up the request URI.
$ri = htmlspecialchars($_SERVER['REQUEST_URI']);

// Check to see if an GIF, JPEG or PDF was requested.
if (preg_match('/\.(pdf|gif|jpg)$/', $_SERVER['REQUEST_URI'])) {
    // Spit out the 404 and exit.
    make404();
    exit;
}

// Set the default language to English.
$lang = "en";
if (!is_dir("{$_SERVER['DOCUMENT_ROOT']}/manual1/$lang")) {
	$lang = "en"; // fall back to English
}

# handle .php3 files that were renamed to .php
// We don't really need this but I am leaving it in for now. Until I have a 
// better understanding of what needs to happen.
if (preg_match("/(.*\.php)3$/", $ri, $array)) {
	if($_SERVER['SERVER_PORT']!=80) {
		$url = "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].$array[1];
	} else {
		$url = "http://".$_SERVER['SERVER_NAME'].$array[1];
	}
	$urle = htmlspecialchars($url);
	
	header("HTTP/1.0 302 Redirect");
	header("Location: $url");

	print "<html><title>Redirect to $urle</title><body>";
	print "<a href=\"".$url."\">Please click here</a></body></html>";
	exit;
}

# handle moving english manual down into its own directory
// This changes .../manual1/html/page.html to .../manual1/en/html/page.html
if (eregi("^(.*)/manual1/((html/)?[^/]+)$", $ri, $array)) {
	// Make sure the same port is used. Are any other ports open for this?
	if($_SERVER['SERVER_PORT']!=80) {
		$url = "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."$array[1]/manual1/$lang/".$array[2];
	} else {
		$url = "http://".$_SERVER['SERVER_NAME']."$array[1]/manual1/$lang/".$array[2];
	}
	
	// URL Encode the new URL.
	$urle = htmlspecialchars($url);
	
	// Send the redirect header.
	header("HTTP/1.0 302 Redirect");
	// Send the redirect location.
	header("Location: $url");

	// Let the user know what is going on incase the redirect doesn't work.
	print "<html><title>Redirect to $urle</title><body>";
	print "<a href=\"".$url."\">Please click here</a></body></html>";
	exit;
}

// I have no idea what is going on here. I think this may strip out the host
// name and protocol.
$uri = substr($REDIRECT_REDIRECT_ERROR_NOTES,
			  strpos($REDIRECT_REDIRECT_ERROR_NOTES,
					 $_SERVER['DOCUMENT_ROOT']
					 ) + strlen($_SERVER['DOCUMENT_ROOT']) + 1
			  );

# try to find the uri as a manual entry

require "manual1-lookup.inc";
// Check to see if the URI has a '/' in it. If it does then a page like 
// .../en/show_all was requested.
if(strchr($uri, '/')) {
	// Break the URI up into language and page.
	list($lang, $function) = explode('/', $uri, 2);
	$function = strtolower($function);
	$lang = strtolower($lang);
} else {
    $function = strtolower($uri);
}

// Check to see if there is a manual page for the language and function.
$try = find_manual_page($lang, $function);
if($try) {
	// Send a redirect header.
	header("HTTP/1.0 302 Redirect");
	// Send the redirect location.
	header("Location: $try");
	exit;
}


# If all else fails ... redirect to the search page with the pattern set to $_SERVER['REQUEST_URI']

#if ($_SERVER['REQUEST_URI']) {
#	header('HTTP/1.0 302 Redirect');
#	header('Location: /search.php?show=nosource&pattern='.urlencode($_SERVER['REQUEST_URI']) );
#	exit;
#}

make404();
exit;


?>
