<html>

<head>
<title>PHP-GTK</title>
</head>

<body bgcolor="#ffffff">

<table border=0 width=100%>
	<tr>
		<td>
			<font face="sans-serif" size=+1>
			<b>PHP-GTK: PHP language bindings for GTK+</b>
			</font>
		</td>
		<td align=right>
			<img src="images/php-gtk-logo.png" width=128 height=67 border=0>
		</td>
	</tr>
</table>

<p>
Too often PHP is thought of as only an HTML-embedded Web scripting language. But
it is also a very full-featured general purpose language that can be used for
much more. One of the goals behind this project was to prove that PHP can be
used to write client-side GUI applications. 
</p>

<p>
There is a mailing list for PHP-GTK. To subsribe, send blank email to
<a href="mailto: php-gtk-subscribe@lists.php.net">php-gtk-subscribe@lists.php.net</a>.
The address of the list itself is <a href="mailto:php-gtk@lists.php.net">php-gtk@lists.php.net</a>.
The list is archived at <a href="http://marc.theaimsgroup.com/?l=php-gtk&r=1&w=2">MARC</a>.
</p>

<p>
<b>Note:</b> PHP-GTK currently requires the latest PHP version from CVS and will
work with 4.0.5 when it comes out.
</p>

<p>
PHP-GTK currently supports GTK+ v1.2.6 or greater, but not GTK+ v2.0
(which is still under development and won't be widely used for a while). You can
obtain the latest stable release of GTK+ v1.2.x from
<a href="ftp://ftp.gtk.org/pub/gtk/v1.2/">ftp://ftp.gtk.org/pub/gtk/v1.2/</a>.
</p>

<blockquote type="cite">
<b>Warning!</b><i> This code is a highly experimental adaptation of the
instructions beamed to us by the friendly aliens of Tau Ceti. The API can and
</i>will<i> be changing, evolving, and unpredictably morphing into little furry
Ewoks, fluorescent killer bunny rabbits, and the knights who say 'Nee'. Use the
code at your own risk, as it may cause flooding, polydactism, frogs falling from
the sky, and the return of the Inca empire. And it will definitely warp
space-time continuum in your local area.</i>
</blockquote>

<p>
Latest stable release:
<blockquote>
	<a href="do_download.php?download_file=php-gtk-0.0.2.tar.gz">php-gtk-0.0.2 (Source)</a> (7-Mar-2001)<br>
	<a href="do_download.php?download_file=php-gtk-0.0.2-win32.zip">php-gtk-0.0.2 (Windows and php binary)</a> (7-Mar-2001)
</blockquote>

<p>
Alternatively, you can get the latest and greatest version of PHP-GTK directly
from the PHP CVS server.
</p>

<blockquote>
<code><b>
cvs -d :pserver:cvsread@cvs.php.net:/repository login<br>
(Logging in to cvsread@cvs.php.net)<br>
CVS password: phpfi<br><br>

cvs -d :pserver:cvsread@cvs.php.net:/repository co php-gtk<br><br>

cd php-gtk<br>
phpize<br>
./configure<br>
make<br>
make install<br>
</b></code>
</blockquote>

<p>
Look inside <b>test/</b> subdirectory for usage examples. Documentation is being
worked on at the moment, so if you want to help out, join the list and let us
know what you are interested in.
</p>


<p>
If you have any questions, please read the <a href="faq.php">FAQ</a> and then
contact me at <a href="mailto: andrei@php.net">andrei@php.net</a> or ask on the
mailing list.
</p>

<hr>
<font size=-1><i>Last updated: <?php echo strftime('%d-%B-%Y', getlastmod()); ?></font>

</body>

</html>
