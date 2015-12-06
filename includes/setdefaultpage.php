<?php

function defaultheader($language,$titulo,$description,$keywords) {
echo "<!DOCTYPE html>
<html lang=\"$language\">
<head>
<meta charset=\"UTF-8\" />
<meta name=\"author\" content=\"PHP-GTK Team\" />
<meta name=\"description\" content=\"$description\" />
<meta name=\"keywords\" content=\"$keywords\" />
<title>$titulo</title>
<link rel=\"stylesheet\" href=\"css/w3.css\" />
<link rel=\"stylesheet\" href=\"css/w3-theme-blue.css\" /> 
<link rel=\"stylesheet\" href=\"https://fonts.googleapis.com/icon?family=Material+Icons\">
</head>";
}

function defaulttop() {
echo"<header class=\"w3-row\">
<div class=\"w3-container w3-default-blue \">
<header class=\"w3-container w3-default-blue w3-half w3-animate-left\">
<img  src=\"images/logo_phpgtk.png\" height=\"69\" width=\"167\" alt=\"Logo PHP-GTK\" />
<h6 >Building Desktop Applications in PHP with PHP-GTK</h6>
</header>
<article class=\"w3-container w3-default-blue w3-half  w3-animate-right\"><p>Any serious PHP-GTK related questions should be sent to php-gtk-dev@lists.php.net,
 unless they are related to the manual, in which case they should be sent to php-gtk-doc@lists.php.net.</br> If you have a question or suggestion for the website,
  you should contact php-gtk-webmaster@lists.php.net. </p>
</article>
</div>
</div>
<div class=\"w3-topnav w3-medium w3-black \">
  <a href=\"index.php\">Home</a>
  <a href=\"#\">Download</a>
  <a href=\"#\">Documentation</a>
  <a href=\"#\">Applications</a>
  <a href=\"#\">FAQ</a>
  <a href=\"#\">Changelog</a>
  <a href=\"#\">Resources</a>
</div>";
}

function defaultfooter() {
echo "<footer class=\"w3-container w3-default-blue w3-small w3-animate-opacity \">
<div class=\"w3-left\">Copyright © 2001-2015 PHP-GTK Team. All rights reserved.</div>
 <div class=\"w3-right\">Last updated:  Sunday December 06 06:40:12 2015 UTC</div>
</footer>
</html>";
}

?>