<html>

<head>
<title>PHP-GTK FAQ</title>
</head>

<body bgcolor="#ffffff">

<font face="sans-serif" size=+1>
<b>PHP-GTK FAQ</b>
</font>

<ul>
<li><a href="#1">What is PHP-GTK?</a>
<li><a href="#2">Why is it not working with the browser/web server?</a>
<li><a href="#3">How do I install PHP-GTK on Win32?</a>
</ul>

<a name="1"><b>What is PHP-GTK?</b></a>
PHP-GTK is a PHP extension that implements language bindings for GTK+. It
provides an object-oriented interface to GTK+ classes and functions and greatly
simplifies writing client side cross-platform GUI applications.
<br> <br>

<a name="2"><b>Why is it not working with the browser/web server?</b></a>
PHP-GTK is not meant to be used in the Web environment. It is intended for
creation of standalone applications (run via command-line, user's desktop, etc.).
<br><br>

<a name="3"><b>How do I install PHP-GTK on Win32?</b></a><br>
Download the latest <a href="http://gtk.php.net/do_download.php?download_file=php-gtk-0.0.1-win32.zip">binaries</a> from gtk.php.net<br>
The zip file contains all binaries needed to run PHP-GTK. Copy the files to the following locations:<br>
<br>
On Windows 98/NT/2000 you will need these files<br>
<br>
[php-directory] (c:\php4)<br>
<dd>php.exe<br>
<dd>php4ts.dll<br>
<dd>php_gtk.dll<br>
<br>
[Windows directory] (c:\winnt or c:windows)<br>
<dd>php.ini<br>
<br>
[System32 directory] (c:\winnt\system32 or c:\windows\system32)<br>
<dd>gtk-1.3.dll<br>
<dd>gdk-1.3.dll<br>
<dd>gmodule-1.3.dll<br>
<dd>glib-1.3.dll<br>
<dd>iconv-1.3.dll<br>
<dd>gnu-intl.dll<br>
<br>
php-gtk has NOT been tested on Windows 95/98<br>


</body>

</html>
