<?php

commonHeader('Downloads');

?>

<h1>Download</h1>

<P>
<b>Note:</b> PHP-GTK requires PHP 4.0.5 or greater (latest CVS version will work
too). Versions 0.1.x currently require PHP 4.1.0 or CVS version to compile.
</P>
<P>
PHP-GTK currently supports GTK+ v1.2.6 or greater, 
but not GTK+ v2.0 (which is still under development and won't be 
widely used for a while). You can obtain the latest stable release 
of GTK+ v1.2.x from <?php print_link('ftp://ftp.gtk.org/pub/gtk/v1.2/'); ?>.
</P>

<h2>Latest Stable Release</h2>

<UL>
<LI><?php print_link('http://gtk.php.net/do_download.php?download_file=php-gtk-0.5.2.tar.gz', 'php-gtk-0.5.2 Source'); ?> - 01-Nov-2002<br>

<LI><?php print_link('http://gtk.php.net/do_download.php?download_file=php-gtk-0.5.1.tar.gz', 'php-gtk-0.5.1 Source'); ?> - 26-Apr-2002<br>

<LI><?php print_link('http://gtk.php.net/do_download.php?download_file=php-gtk-0.5.2a-win32.zip', 
	'php-gtk-0.5.2a Windows and PHP Binary including libGlade-0.17, SQPane and ComboButton'); ?> - 26-Nov-2002<br>

<LI><?php print_link('http://gtk.php.net/do_download.php?download_file=php-gtk-0.5.2-win32.zip', 
	'php-gtk-0.5.2 Windows and PHP Binary including libGlade, SQPane and ComboButton'); ?> - 03-Nov-2002<br>

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
