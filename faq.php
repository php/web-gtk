<?php

commonHeader('Frequently Asked Questions');

?>

<h1>Frequently Asked Questions</h1>


<ul>
 <li><a href="#1">What is PHP-GTK?</a></li>
 <li><a href="#2">Why is it not working with the browser/web server?</a></li>
 <li><a href="#3">How do I install PHP-GTK on Win32?</a></li>
 <li><a href="#4">How do I use the buttons in GtkFileSelection?</a></li>
 <li><a href="#5">How do I know which GTK Classes are supported?</a></li>
 <li><a href="#6">Can I use Themes under Win32?</a></li>
 <li><a href="#7">Where do I go from here?</a></li>
</ul>

<dl>

<dt>
 <a name="1"><b>What is PHP-GTK?</b></a>
</dt>
<dd><p>
PHP-GTK is a PHP extension that implements language bindings for GTK+. It
provides an object-oriented interface to GTK+ classes and functions and greatly
simplifies writing client side cross-platform GUI applications.
</p></dd>


<dt>
 <a name="2"><b>Why is it not working with the browser/web server?</b></a>
</dt>
<dd><p>
PHP-GTK is not meant to be used in the Web environment. It is intended for
creation of standalone applications (run via command-line, user's desktop, etc.).
</p></dd>

<dt>
 <a name="3"><b>How do I install PHP-GTK on Win32?</b></a>
</dt>
<dd><p>
Download the latest binaries from <a href="http://gtk.php.net/download.php">gtk.php.net</a>.
The zip file contains all binaries needed to run core PHP-GTK, as well as extra features such as Glade/XML and Scintilla. 
Extract the files to a temporary directory and then copy them into the following locations:
</p>

<p>
 <b>For Windows 98/NT/2000/XP:</b>
</p>

<p>In your PHP directory (e.g., c:\php4):</p>
<ul>
  <li>php.exe</li>
  <li>php_win.exe</li>
  <li>php-cgi.exe</li>
  <li>php.ini</li>
  <li>php.ini-gtk</li>
  <li>all .dll files</li>
</ul>
<p>In a test directory (e.g., c:\php4\test):</p>
<ul>
  <li>all .php files</li>
  <li>testgtkrc</li>
  <li>testgtkrc2</li>
  <li>window.xpm</li>
</ul>
<p>
NOTE: You can install the php.ini into your Windows 
directory (i.e., c:\winnt or c:\windows) as indicated by the zip file, but it is often not a good option,
depending on the installation.
It is also no longer required; the php.exe (CLI version as of PHP 4.3.0) will search the working directory, e.g., c:\php4,
as well as the Windows directory. Or you can specify your php.ini location in your command line statement with '-c' option, 
as given in the php_win example below. 
</p>

<p>
 <b>For Windows 95:</b>
</p>

<p>
 PHP-GTK has <b>not</b> been tested on Windows 95 ... sorry.
</p>

<p>
 <b>Testing the installation:</b>
</p>
<p>
 When the PHP-GTK files are installed, you can verify your setup using a DOS command line.
 A typical example would be:
</p>

<ul>
 <li>c:\php4\php c:\php4\test\hello.php</li>
 <li>To avoid the DOS box, you can use the php_win executable, provided in the install file:
  <ul>
   <li>c:\php4\php_win c:\php4\test\hello.php</li>
   <li>or</li>
   <li>start c:\php4\php_win c:\php4\test\hello.php</li>
   <li>or</li>
   <li>c:\php4\php_win -c \php4\php.ini -f c:\php4\test\hello.php</li>
  </ul>

 (If you have installed your php.ini file in your windows directory, the -c option can
 be dropped.  For more information on command line options, see
 <a href="http://www.php.net/manual/en/features.commandline.php">'Using PHP from the command line'</a>
 on the main PHP site.)
 </li>
</ul>

<p>
 <b>Troubleshooting:</b>
</p>

<p>If you can't produce the hello window, try the following:</p>
<ul>
  <li>Verify the hello.php location, i.e., [drive:]\php4\test</li>
  <li>Open hello.php in Notepad, and make sure there is no obvious corruption to the code.</li>
  <li>Modify your php.ini file, to log any errors, as detailed below.</li>
  <li>Review the postings at the <a href="http://marc.theaimsgroup.com/?l=php-gtk-general">PHP-GTK discussion list archive</a> for possible solutions.</li>
  <li>If you still have a problem, subscribe to the <a href="mailto:php-gtk-general-subscribe@lists.php.net">PHP-GTK general discussion list</a> and post your question there.</li>
</ul>

<p>
 <b>Tips/Tricks:</b>
</p>
<ul>
  <li>To debug your scripts, modify the php.ini file as follows:
   <ul>
     <li>Find the line for 'log_errors'.  Set it to 'On'.</li>
     <li>Find the line for 'error_log'.  Remove the beginning semicolon (uncomment) and replace 'filename' with an actual file location.
         <br/>Example: error_log=c:\php4\error_log.txt.</li>
     <li>If the error file does not exist, php will create it on the next run.  Open the file and review.</li>
   </ul>
  </li>
  <li>If you are planning to launch on an association, decide which extension you want to use for your scripts.
  Be aware that other applications register .php, so something like .php-gtk might be a better option.</li>
  <li>Check out the Code Snippets and Code Hints on the <a href="http://gtk.php.net/wiki/">PHP-GTK Wiki page</a>.</li>
  <li>You can set your scripts to use Win32 themes, courtesy of Christian Weiske.  Check out the info page at:
        <br/><a href="http://www.cweiske.de/phpgtk_themes.htm ">http://www.cweiske.de/phpgtk_themes.htm </a></li>
  <li>Install the <a href="http://www.cweiske.de/phpgtk_apps.htm#phpgtklauncher">php-gtk launcher</a>. It
  handles many of the Windows directory issues and provides a series of PHP-GTK icons.  Also from Christian.</li>
  <li>Consider using Glade/XML for setting up your screens and reducing maintenance time.<br/>
   Start with the info page at: <a href="http://gtk.php.net/manual1/en/glade.gladexml.php">http://gtk.php.net/manual1/en/glade.gladexml.php</a>.
  </li>
</ul>

</dd>


<dt>
 <a name="4"><b>How do I use the buttons in GtkFileSelection?</b></a>
</dt>
<dd>
<pre class="code">
// Create the dialog window:
    $fs = &amp;new GtkFileSelection("Save file");

// Get a handle to the Ok button:
    $ok_button = $fs->ok_button;

// Connect a function:
    $ok_button->connect("clicked", "enddialog");

// Connect the destroy action on the dialog window:
    $ok_button->connect_object("clicked", "destroy", $fs);
</pre>

<p>
 It is <b>not</b> currently possible to do it this way:
</p>
<pre class="code">
// Create the dialog window
    $fs = &amp;new GtkFileSelection("Save file");

// Connect a function
    $fs->ok_button->connect("clicked", "enddialog");

// Connect the destroy action on the dialog window
    $fs->ok_button->connect_object("clicked", "destroy", $fs); 
</pre>
</dd>


<dt>
 <a name="5"><b>How do I know which GTK Classes are supported?</b></a>
</dt>
<dd>
<p>
 The following code will show the defined classes. All the PHP-GTK 
 classes will be listed along with one or two others.
</p>
<pre class="code">
$array = get_declared_classes();
while(list(,$classname) = each($array)) {
    echo $classname."\n";
}
</pre>
<p>
See the <?php print_link('http://www.php.net/manual/en/ref.classobj.php', 'Class/Object functions'); ?>
in the PHP Manual for other useful functions.
</p></dd>


<dt>
 <a name="6"><b>Can I use Themes under Win32?</b></a>
</dt>
<dd>
 <p>
  No, The Win32 GTK port does not currently support this.
 </p>
</dd>


<dt>
 <a name="7"><b>Where do I go from here?</b></a>
</dt>
<dd>
 <p>
  Check out the <?php print_link('/resources.php', 'Resources page'); ?>.
 </p>
</dd>

</dl>

<?php

commonFooter();

?>
