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
<li><a href="#4">How do I use the buttons in GtkFileSelection?</a>
<li><a href="#5">How do I know which GTK Classes are supported?<a>
<li><a href="#6">Can I use Themes under Win32?<a>
<li><a href="#7">Where do I go from here?</a>
</ul>

<a name="1"><b>What is PHP-GTK?</b></a><br>
PHP-GTK is a PHP extension that implements language bindings for GTK+. It
provides an object-oriented interface to GTK+ classes and functions and greatly
simplifies writing client side cross-platform GUI applications.
<br> <br>

<a name="2"><b>Why is it not working with the browser/web server?</b></a><br>
PHP-GTK is not meant to be used in the Web environment. It is intended for
creation of standalone applications (run via command-line, user's desktop, etc.).
<br><br>

<a name="3"><b>How do I install PHP-GTK on Win32?</b></a><br>
Download the latest <a href="http://gtk.php.net/do_download.php?download_file=php-gtk-0.0.2-win32.zip">binaries</a> from gtk.php.net<br>
The zip file contains all binaries needed to run PHP-GTK. Copy the files to the following locations:<br>
<br>
On Windows 98/NT/2000 you will need these files<br>
<br>
[php-directory] (c:\php4)<br>
<dd>php.exe<br>
<dd>php4ts.dll<br>
<dd>php_gtk.dll<br>
<br>
[Windows directory] (c:\winnt or c:\windows)<br>
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
<br><br>

<a name="4"><b>How do I use the buttons in GtkFileSelection?</b></a><br>
<blockquote>
<code>
$fs = &new GtkFileSelection("Save file");					// Create the dialog window<br>
$ok_button = $fs->ok_button;								// Get a handle to the Ok button<br>
$ok_button->connect("clicked", "enddialog");				// Connect a function<br>
$ok_button->connect_object("clicked", "destroy", $fs);		// Connect the destroy action on the dialog window<br>
</code><br>
It is not currently possible to do it this way.<br><br>
<code>
$fs = &new GtkFileSelection("Save file");					// Create the dialog window<br>
$fs->ok_button->connect("clicked", "enddialog");			// Connect a function<br>
$fs->ok_button->connect_object("clicked", "destroy", $fs);	// Connect the destroy action on the dialog window<br>
</code>
</blockquote>

<br><br>
<a name="5"><b>How do I know which GTK Classes are supported?</b></a><br>
The following code will show the defined classes. All the php-gtk classes 
will be listed along with one or two others.
<blockquote>
<code>
$array = get_declared_classes();<br>
while(list(,$classname) = each($array)) {<br>
		echo $classname."\n";<br>
}<br>
</code>
</blockquote>
See the 
<a href="http://www.php.net/manual/en/ref.classobj.php">Class/Object</a>
functions in the PHP Manual for other useful functions.
<br><br>

<a name="6"><b>Can I use Themes under Win32?</b></a><br>
No, The Win32 GTK port does not currently support this.
<br> <br>

<a name="7"><b>Where do I go from here?</b></a><br>
There are a number of sources popping up around the net for PHP-GTK. Here is a small list of the ones we know of:

<ul>
  <li><a href="http://gtk.php-coder.net">http://gtk.php-coder.net</a> - Current news, example applications, and some tutorials on how to use PHP-GTK.
  <li><a href="http://www.phpgtk.com">http://www.phpgtk.com</a> - A windows installer and news about PHP-GTK
  <li><a href="http://developer.gnome.org/doc/API/gtk/gtkobjects.html">GTK+ Reference Manual</a> - The GTK+ manual with a list of all widgets and their corresponding functions/attributes
  <li><a href="http://www.phpuk.org/gtk/">PHP-GTK Manual</a> - The beginnings of the PHP-GTK official manual. Keep checking back for updates!
  <li>#php-gtk IRC channel on EFNet has a few regulars who can most likely answer the questions you have.
</ul>

More will be added to the list as they become available. Also, this page will soon be getting a makeover. 
<br><br>


</body>

</html>
