<?php

commonHeader('Downloads');

?>

<h1>Download</h1>

<P>
<b>Note:</b> PHP-GTK requires PHP 4.0.5 or greater (latest CVS version will work
too). Versions 1.0.1 and later require PHP 4.3.x to build.
</P>
<P>
PHP-GTK currently supports GTK+ v1.2.6 or greater, but not GTK+ v2.x. You can
obtain the latest stable release 
of GTK+ v1.2.x from <?php print_link('ftp://ftp.gtk.org/pub/gtk/v1.2/'); ?>.
</P>

<h2>Latest Stable Release</h2>

<UL>
<LI><?php print_link('http://gtk.php.net/do_download.php?download_file=php-gtk-1.0.1.tar.gz', 'php-gtk-1.0.1 Source'); ?> - 09-Aug-2004<br>

<LI><?php print_link('http://gtk.php.net/do_download.php?download_file=php-gtk-1.0.0.tar.gz', 'php-gtk-1.0.0 Source'); ?> - 23-Oct-2003<br>

<LI><?php print_link('http://gtk.php.net/do_download.php?download_file=php-gtk-1.0.1-win32.zip', 'php-gtk-1.0.1 Windows and PHP Binaries'); ?> - 09-Aug-2004<br>

<LI><?php print_link('http://gtk.php.net/do_download.php?download_file=php-gtk-1.0.0-win32.zip', 
	'php-gtk-1.0.0 Windows and PHP Binaries including ComboButton, Extra, libGlade, Scintilla, Spaned, SQPane'); ?> - 23-Oct-2003<br>


</UL>

<h2>CVS Version</h2>

<P>
Alternatively, you can get the latest and greatest 
version of PHP-GTK directly from the PHP CVS server.
</P>

<UL>

<LI>
Log in to the PHP anonymous CVS server (use <B>phpfi</B> as the password):
<PRE>
cvs -d :pserver:cvsread@cvs.php.net:/repository login
</PRE>

<LI>
Obtain the PHP-GTK tree:
<PRE>
cvs -d :pserver:cvsread@cvs.php.net:/repository co -r PHP_GTK_1 php-gtk
</PRE>

<LI>
Move into the source tree:
<PRE>
cd php-gtk
</PRE>

<LI>
Configure and install:
<PRE>
./buildconf
./configure
make
make install
</PRE>

</UL>

      
<?php

commonFooter();

?>
