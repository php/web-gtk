<?php

commonHeader('Frequently Asked Questions');

?>

<h1>Frequently Asked Questions</h1>


<ul>
<li><a href="#1">What is PHP-GTK?</a>
<li><a href="#2">Why is it not working with the browser/web server?</a>
<li><a href="#3">How do I install PHP-GTK on Win32?</a>
<li><a href="#4">How do I use the buttons in GtkFileSelection?</a>
<li><a href="#5">How do I know which GTK Classes are supported?</a>
<li><a href="#6">Can I use Themes under Win32?</a>
<li><a href="#7">Where do I go from here?</a>
</ul>

<DL>

<DT>
<a name="1"><b>What is PHP-GTK?</b></a>
</DT>
<DD><P>
PHP-GTK is a PHP extension that implements language bindings for GTK+. It
provides an object-oriented interface to GTK+ classes and functions and greatly
simplifies writing client side cross-platform GUI applications.
</P></DD>


<DT>
<a name="2"><b>Why is it not working with the browser/web server?</b></a>
</DT>
<DD><P>
PHP-GTK is not meant to be used in the Web environment. It is intended for
creation of standalone applications (run via command-line, user's desktop, etc.).
</P></DD>

<DT>
<a name="3"><b>How do I install PHP-GTK on Win32?</b></a>
</DT>
<DD><P>
Download the latest binaries from <? print_link('/downloads.php', 'gtk.php.net'); ?>.
The zip file contains all binaries needed to run PHP-GTK. Copy the files to the following locations:
</P></DD>
<DD><P>
<B>For Windows 98/NT/2000:</B>
</P></DD>
<DD><P>
In your PHP directory (e.g., c:\php4):
<UL>
  <LI>php.exe
  <LI>php4ts.dll
  <LI>php_gtk.dll
</UL>
In your Windows directory (e.g., c:\winnt or c:\windows):
<UL>
  <LI>php.ini
</UL>
In your System32 directory (e.g., c:\winnt\system32 or c:\windows\system32):
<UL>
  <LI>gtk-1.3.dll
  <LI>gdk-1.3.dll
  <LI>gmodule-1.3.dll
  <LI>glib-1.3.dll
  <LI>iconv-1.3.dll
  <LI>gnu-intl.dll
</UL>
</P></DD>
<DD><P>
<B>For Windows 95:</B>
</P></DD>
<DD><P>
php-gtk has <b>not</b> been tested on Windows 95 ... sorry.
</P></DD>


<DT>
<a name="4"><b>How do I use the buttons in GtkFileSelection?</b></a>
</DT>
<DD><P>
<PRE CLASS="code">
// Create the dialog window:
    $fs = &new GtkFileSelection("Save file");

// Get a handle to the Ok button:
    $ok_button = $fs->ok_button;

// Connect a function:
    $ok_button->connect("clicked", "enddialog");

// Connect the destroy action on the dialog window:
    $ok_button->connect_object("clicked", "destroy", $fs);
</PRE>
</P></DD>
<DD><P>
It is <B>not</B> currently possible to do it this way:
<PRE CLASS="code">
// Create the dialog window
    $fs = &new GtkFileSelection("Save file");

// Connect a function
    $fs->ok_button->connect("clicked", "enddialog");

// Connect the destroy action on the dialog window
    $fs->ok_button->connect_object("clicked", "destroy", $fs); 
</PRE>
</P></DD>

<DT>
<a name="5"><b>How do I know which GTK Classes are supported?</b></a>
</DT>
<DD><P>
The following code will show the defined classes. All the php-gtk 
classes will be listed along with one or two others.
<PRE CLASS="code">
$array = get_declared_classes()) {
while(list(,$classname) = each($array)) {
    echo $classname."\n";
}
</PRE>
See the <?php print_link('http://www.php.net/manual/en/ref.classobj.php', 'Class/Object functions'); ?>
in the PHP Manual for other useful functions.
</P></DD>

<DT>
<a name="6"><b>Can I use Themes under Win32?</b></a>
</DT>
<DD><P>
No, The Win32 GTK port does not currently support this.
</P></DD>

<DT>
<a name="7"><b>Where do I go from here?</b></a>
</DT>
<DD><P>
Check out the <?php print_link('/resources.php', 'Resources page'); ?>.
</P></DD>

</DL>

<?php

commonFooter();

?>
