<?php

commonHeader('Downloads');

?>

<h1>Download</h1>

<P>
<b>Note:</b> PHP-GTK requires PHP 4.0.5 or greater (latest CVS version will work
too). Versions 0.1.x currently require PHP 4.0.7 or CVS version to compile.
</P>
<P>
PHP-GTK currently supports GTK+ v1.2.6 or greater, 
but not GTK+ v2.0 (which is still under development and won't be 
widely used for a while). You can obtain the latest stable release 
of GTK+ v1.2.x from <?php print_link('ftp://ftp.gtk.org/pub/gtk/v1.2/'); ?>.
</P>

<h2>Latest Stable Release</h2>

<UL>
<LI><?php print_link('http://gtk.php.net/do_download.php?download_file=php-gtk-0.1.1.tar.gz',
	'php-gtk-0.1.1 Source'); ?> - 24-Sep-2001<br>

<LI><?php print_link('http://gtk.php.net/do_download.php?download_file=php-gtk-0.1.tar.gz', 
	'php-gtk-0.1 Source'); ?> - 1-Aug-2001<br>

<LI><?php print_link('http://gtk.php.net/do_download.php?download_file=php-gtk-0.1.1-win32.zip', 
	'php-gtk-0.1.1 Windows and PHP Binary'); ?> - 25-Sep-2001<br>

<LI><?php print_link('http://gtk.php.net/do_download.php?download_file=php-gtk-0.1a-win32.zip', 
	'php-gtk-0.1a Windows and PHP Binary'); ?> - 7-Aug-2001<br>

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
cvs -d :pserver:cvsread@cvs.php.net:/repository co php-gtk
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
