<?php

commonHeader('Downloads');

?>

<h1>Download</h1>

<P>
<b>Note:</b> PHP-GTK currently requires the latest 
PHP version from CVS and will work with 4.0.5 when it comes out.
</P>
<P>
PHP-GTK currently supports GTK+ v1.2.6 or greater, 
but not GTK+ v2.0 (which is still under development and won't be 
widely used for a while). You can obtain the latest stable release 
of GTK+ v1.2.x from <?php print_link('ftp://ftp.gtk.org/pub/gtk/v1.2/'); ?>.
</P>

<h2>Latest Stable Release</h2>

<UL>
<LI><?php print_link('http://gtk.php.net/do_download.php?download_file=php-gtk-0.0.4.tar.gz', 
	'php-gtk-0.0.4 Source'); ?> - 5-May-2001<br>

<LI><?php print_link('http://gtk.php.net/do_download.php?download_file=php-gtk-0.0.3-win32.zip', 
	'php-gtk-0.0.3 Windows and PHP Binary'); ?> - 20-Mar-2001<br>

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
phpize
./configure
make
make install
</PRE>

</UL>

      
<?php

commonFooter();

?>
