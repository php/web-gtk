<?php

commonHeader('Downloads');

?>

<h1>Download</h1>
<h2>Latest Release of PHP-GTK 2</h2>

<p>
<b>GTK+ version:</b>
<br />
PHP-GTK 2 currently supports GTK+ 2.6.9 or greater. You can obtain the latest
stable release of GTK+ 2.x from <?php print_link('ftp://ftp.gtk.org/pub/gtk/'); ?>.
</p>
<p>
<b>PHP version:</b>
<br />
PHP-GTK 2 requires PHP 5.1.x or greater. The latest version of
the PHP_5_2 branch in CVS will work, too.
</p>

<ul>
<li><?php print_link('http://gtk.php.net/do_download.php?download_file=php-gtk-2.0.0zeta.tar.gz', 'php-gtk-2.0.0 zeta Source'); ?> - 15-Jul-2006</li>
<li><?php print_link('http://gtk.php.net/do_download.php?download_file=php-gtk-2.0.0zeta-5_1-win32.zip', 'php-gtk-2.0.0 zeta Windows binary for PHP 5.1.*'); ?> - 15-Jul-2006</li>
<li><?php print_link('http://gtk.php.net/do_download.php?download_file=php-gtk-2.0.0zeta-5_2-win32.zip', 'php-gtk-2.0.0 zeta Windows binary for PHP 5.2.*'); ?> - 15-Jul-2006</li>
</ul>

<hr />

<h2>Latest Stable PHP-GTK Release</h2>

<p>
<b>GTK+ version:</b>
<br />
PHP-GTK currently supports GTK+ 1.2.6 or greater. You can obtain the
latest stable release of GTK+ 1.2.x from
<?php print_link('ftp://ftp.gtk.org/pub/gtk/v1.2/'); ?>.
</p>
<p>
<b>PHP version:</b>
<br />
PHP-GTK 1 requires PHP 4.0.5 or greater, with versions from
1.0.1 up requiring PHP 4.3.x to build.
</p>

<ul>
<li><?php print_link('http://gtk.php.net/do_download.php?download_file=php-gtk-1.0.2.tar.gz', 'php-gtk-1.0.2 Source'); ?> - 15-Jul-2005</li>
<li><?php print_link('http://gtk.php.net/do_download.php?download_file=php-gtk-1.0.1.tar.gz', 'php-gtk-1.0.1 Source'); ?> - 09-Aug-2004</li>
<li><?php print_link('http://gtk.php.net/do_download.php?download_file=php-gtk-1.0.2-win32.zip', 'php-gtk-1.0.2 Windows and PHP Binaries'); ?> - 15-Jul-2005</li>
<li><?php print_link('http://gtk.php.net/do_download.php?download_file=php-gtk-1.0.1a-win32.zip', 'php-gtk-1.0.1a Windows and PHP Binaries'); ?> - 25-Aug-2004</li>
<li><?php print_link('http://gtk.php.net/do_download.php?download_file=php-gtk-1.0.0-win32.zip', 
	'php-gtk-1.0.0 Windows and PHP Binaries including ComboButton, Extra, libGlade, Scintilla, Spaned, SQPane'); ?> - 23-Oct-2003</li>
</ul>

<hr />

<h2>CVS Version</h2>

<p>
Alternatively, you can get the latest and greatest 
version of PHP-GTK directly from the PHP CVS server.
</p>

<ol>

<li>
Log in to the PHP anonymous CVS server (use <b>phpfi</b> as the password):
<pre>
cvs -d :pserver:cvsread@cvs.php.net:/repository login
</pre>
</li>

<li>
Obtain the PHP-GTK tree.
<br />
<br />For PHP-GTK 2:
<pre>
cvs -d :pserver:cvsread@cvs.php.net:/repository co php-gtk
</pre>
For PHP-GTK 1:
<pre>
cvs -d :pserver:cvsread@cvs.php.net:/repository co -r PHP_GTK_1 php-gtk
</pre>
</li>

<li>
Move into the source tree:
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
