<?php
commonHeader('Downloads');
?>

<h1>Download</h1>

<h2>PHP-GTK 2</h2>

<p>
<b>GTK+ version:</b>
<br />
PHP-GTK 2 currently supports GTK+ 2.24.10 or greater. You can obtain the latest
stable release of GTK+ 2.x from <?php print_link('http://ftp.gtk.org/pub/gtk/'); ?>.
</p>
<p>
<b>PHP version:</b>
<br />
PHP-GTK 2 Version Beta:<br />
This is a test build of php 5.4 and php 5.5 with gtk 2.<br />
His production use is at your own risk.<br />
We do not assume any damage that may occur.<br />
Please report bugs to php-gtk-dev@lists.php.net.<br />
</p>
<ul>
<li><?php print_link('http://gtk.php.net/distributions/php54-gtk2.exe', 'php-gtk-2.0.1 with php 5.4 with installer'); ?> - 15-Jan-2015</li>
<li><?php print_link('http://gtk.php.net/distributions/PHP54-GTK2.zip', 'php-gtk-2.0.1 with php 5.4 zipped'); ?> - 15-Jan-2015</li>
<li><?php print_link('http://gtk.php.net/distributions/php55-gtk2.exe', 'php-gtk-2.0.1 with php 5.5 with installer'); ?> - 15-Jan-2015</li>
<li><?php print_link('http://gtk.php.net/distributions/PHP55-GTK2.zip', 'php-gtk-2.0.1 with php 5.5 zipped'); ?> - 15-Jan-2015</li>
<li><?php print_link('https://github.com/php/php-gtk-src/archive/master.zip', 'php-gtk-2.0.1 source'); ?> - 15-Jan-2015</li>
</ul>
<br />

To run the php-gtk with php 5.4 you may need to install:<br />
Microsoft Visual C++ 2008 SP1 Redistributable Package (x86)<br />
<pre>http://www.microsoft.com/en-us/download/details.aspx?id=5582</pre><br />
To run the php-gtk with php 5.5 you may need to install:<br />
Visual C++ Redistributable for Visual Studio 2012 Update 4 <br />
<pre>http://www.microsoft.com/en-us/download/details.aspx?id=30679</pre><br />
<br /><p>
PHP-GTK 2 requires PHP 5.1.x or greater. The latest version of
the PHP_5_2 branch in CVS will work, too.
</p>

<ul>
<li><?php print_link('http://gtk.php.net/distributions/php-gtk-2.0.1.tar.gz', 'php-gtk-2.0.1 Source'); ?> - 15-May-2008</li>
<li><?php print_link('http://gtk.php.net/distributions/php-gtk-2.0.1-win32-nts.zip', 'php-gtk-2.0.1 Windows binary pack'); ?> - 16-May-2008</li>
<li><?php print_link('http://gtk.php.net/distributions/php-gtk-2.0.1-win32-extensions.zip', 'php-gtk-2.0.1 Windows binary extensions pack'); ?> - 16-May-2008</li>
</ul>

<ul>
<li><?php print_link('http://gtk.php.net/distributions/php-gtk-2.0.0.tar.gz', 'php-gtk-2.0.0 Source for Gtk+ 2.6 upwards'); ?> - 29-Feb-2008</li>
<li><?php print_link('http://gtk.php.net/distributions/php-gtk-2.0.0-win32-nts.zip', 'php-gtk-2.0.0 Windows binary pack'); ?> - 29-Feb-2008</li>
</ul>

<hr />

<h2>PHP-GTK 1</h2>

<p>
<b>GTK+ version:</b>
<br />
PHP-GTK 1 currently supports GTK+ 1.2.6 or greater. You can obtain the
latest stable release of GTK+ 1.2.x from
<?php print_link('http://ftp.gtk.org/pub/gtk/v1.2/'); ?>.
</p>
<p>
<b>PHP version:</b>
<br />
PHP-GTK 1 requires PHP 4.0.5 or greater, with versions from
1.0.1 up requiring PHP 4.3.x to build.
</p>

<ul>
<li><?php print_link('http://gtk.php.net/distributions/php-gtk-1.0.2.tar.gz', 'php-gtk-1.0.2 Source'); ?> - 15-Jul-2005</li>
<li><?php print_link('http://gtk.php.net/distributions/php-gtk-1.0.1.tar.gz', 'php-gtk-1.0.1 Source'); ?> - 09-Aug-2004</li>
<li><?php print_link('http://gtk.php.net/distributions/php-gtk-1.0.2-win32.zip', 'php-gtk-1.0.2 Windows and PHP Binaries'); ?> - 15-Jul-2005</li>
<li><?php print_link('http://gtk.php.net/distributions/php-gtk-1.0.1a-win32.zip', 'php-gtk-1.0.1a Windows and PHP Binaries'); ?> - 25-Aug-2004</li>
<li><?php print_link('http://gtk.php.net/distributions/php-gtk-1.0.0-win32.zip', 
	'php-gtk-1.0.0 Windows and PHP Binaries including ComboButton, Extra, libGlade, Scintilla, Spaned, SQPane'); ?> - 23-Oct-2003</li>
</ul>

<hr />

<h2>SVN Version</h2>

<p>
Alternatively, you can get the latest and greatest 
version of PHP-GTK directly from the PHP SVN server ou GitHub.
</p>

<ol>

<li>
PHP-GTK page on GitHub
<br />

You can download the sources for the client github or else clone in a repo.<br />
<pre>https://github.com/php/php-gtk-src</pre><br />
You can also download directly through this link:<br />
<pre>https://github.com/php/php-gtk-src/archive/master.zip</pre><br /><br />

Getting php-gtk on github by svn.
<br />
<br />For PHP-GTK 2:

https://github.com/php/php-gtk-src
<pre>
svn co https://github.com/php/php-gtk-src/trunk php-gtk
</pre>
For PHP-GTK 1:
<pre>
svn co https://github.com/php/php-gtk-src/branches/PHP_GTK_1 php-gtk
</pre>

</li>

<li>
cd into the source tree:
<pre>
cd php-gtk
</pre>
</li>

<li>
Configure and install:
<pre>
./buildconf
./configure
make
make install
</pre>
</li>

</ol>

<?php
commonFooter();
?>