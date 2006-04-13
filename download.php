<?php

commonHeader('Downloads');

?>

<h1>Download</h1>

<p>
<b>Note:</b> PHP-GTK requires PHP 4.0.5 or greater (latest CVS version will work
too). Versions 1.0.1 and later require PHP 4.3.x to build.
</p>
<p>
PHP-GTK currently supports GTK+ v1.2.6 or greater, but not GTK+ v2.x. You can
obtain the latest stable release 
of GTK+ v1.2.x from <?php print_link('ftp://ftp.gtk.org/pub/gtk/v1.2/'); ?>.
</p>

<h2>Latest Stable Release</h2>

<ul>
<li><?php print_link('http://gtk.php.net/do_download.php?download_file=php-gtk-1.0.2.tar.gz', 'php-gtk-1.0.2 Source'); ?> - 15-Jul-2005</li>

<li><?php print_link('http://gtk.php.net/do_download.php?download_file=php-gtk-1.0.1.tar.gz', 'php-gtk-1.0.1 Source'); ?> - 09-Aug-2004</li>

<!-- Bump off list
<li><?php print_link('http://gtk.php.net/do_download.php?download_file=php-gtk-1.0.0.tar.gz', 'php-gtk-1.0.0 Source'); ?> - 23-Oct-2003</li>
-->

<li><?php print_link('http://gtk.php.net/do_download.php?download_file=php-gtk-1.0.2-win32.zip', 'php-gtk-1.0.2 Windows and PHP Binaries'); ?> - 15-Jul-2005</li>

<li><?php print_link('http://gtk.php.net/do_download.php?download_file=php-gtk-1.0.1a-win32.zip', 'php-gtk-1.0.1a Windows and PHP Binaries'); ?> - 25-Aug-2004</li>

<li><?php print_link('http://gtk.php.net/do_download.php?download_file=php-gtk-1.0.0-win32.zip',
    'php-gtk-1.0.0 Windows and PHP Binaries including ComboButton, Extra, libGlade, Scintilla, Spaned, SQPane'); ?> - 23-Oct-2003</li>

</ul>

<h2>CVS Version</h2>

<p>
Alternatively, you can get the latest and greatest 
version of PHP-GTK directly from the PHP CVS server.
</p>

<ul>

<li>
 Log in to the PHP anonymous CVS server (use <b>phpfi</b> as the password):
<pre>
cvs -d :pserver:cvsread@cvs.php.net:/repository login
</pre>
</li>

<li>
 Obtain the PHP-GTK tree:
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

</ul>

      
<?php

commonFooter();

?>
