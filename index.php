<?php
/* $Id$ */


$SIDEBAR_DATA = <<< EOF
<h2>PHP-GTK</h2>
<P>
PHP-GTK is an extension for PHP programming language that implements language
bindings for GTK+ toolkit. It provides an object-oriented interface to GTK+
classes and functions and greatly simplifies writing client side cross-platform
GUI applications.
</P>

<h2>Resources</h2>
<P>
EOF;

$SIDEBAR_DATA .= 'Check out our ' . print_link('/resources.php', 'Resources page');

$SIDEBAR_DATA .= <<< EOF
for links to PHP-GTK related sites, instructions on the PHP-GTK mailing lists, 
and other PHP-GTK resources. Also, please try to use the 
<strong>#php-gtk</strong> channel on Freenode IRC - the more people there, the 
better for the community.
</P>

<h2>Contact</h2>
<P>
If you have problems or questions, your first point of contact should be the
manual and the <strong>php-gtk-general</strong> mailing list.
</P>

<P>
Any serious PHP-GTK related questions should be sent to 
EOF;

$SIDEBAR_DATA .= print_email('andrei at php dot net');
$SIDEBAR_DATA .= ', unless they are related to the manual, in which case they';
$SIDEBAR_DATA .= ' should be sent to ' . print_email('jmoore at php dot net');
$SIDEBAR_DATA .= ' If you have a question or suggestion for the website, you';
$SIDEBAR_DATA .= ' should contact ';
$SIDEBAR_DATA .= print_email('php-gtk-webmaster at lists dot php dot net');
$SIDEBAR_DATA .= '.</P>';

commonHeader();

?>
<h1>News</h1>

<p>
Brazilian PHP-GTK community has a new portal <?php print_link('http://www.php-gtk.org.br/', 'site'); ?>.
</p>

<?hdelim()?>

<p>
<a href="/download.php">PHP-GTK Version 1.0.0</a> is finally out after almost a
year of being in stasis. This is probably the last major version that will work
with PHP 4 and Gtk+ 1.x. There might be more bugfixes, but no new features or
upgrades will be implemented. PHP-GTK 2 is under development and will focus on
PHP 5 and Gtk+ 2.x.
</p>

<?hdelim()?>

<p>
<a href="/download.php">PHP-GTK Version 0.5.2</a> is out. After a long break, we
have fixed some bugs and improved gdk-pixbuf functionality. See
<a href="/changelog.php">Change Log</a> for the full list of changes.
</p>

<?hdelim()?>

<p>
<?print_link('http://wiki.gtk.php.net/')?>
</p>

<p>
The general idea is that the PHP-GTK community (including members of this list)
can use the Wiki to help provide better documentation for PHP-GTK. Be it
HOWTOs, tips, FAQs, case studies or anything else that may be useful, if you
want to write it the Wiki is there to accept it. Best of all because adding
to the Wiki is as simple as clicking the "edit this document" button there
is hardly any barrier between thinking of something and recording it.
</p>

<p>
There is practically no content up there right now, but the Wiki really needs to
be a community effort. If you have anything PHP-GTK related that you think will
be useful, add it in. Good content can then be rolled in to official PHP-GTK
documentation later on. 
</p>

<?hdelim()?>

<p>
Andrei Zmievski gave a presentation and a workshop on PHP-GTK at the Fórum Internacional Software Livre 2002 in Porto Alegre, Brazil. The presentation is available online at <?print_link('http://conf.php.net/br-gtk')?>.
</p>

<?hdelim()?>

<p>
<a href="/download.php">PHP-GTK Version 0.5.1</a> has been released today, April
26, 2002. The main goal was to adapt to the new PHP build system while
preserving compatibility for the old one. Of course, some bug fixes and
improvements are included as well. See <a href="/changelog.php">Change Log</a>
for full list of changes.
</p>

<?hdelim()?>

<p>
With the help of Philip Hallstrom, we now have a Freshmeat-like index of
applications. It still needs to be populated, so if you have written a useful
piece of software using PHP-GTK, point your browser to
<? print_link('/apps/', 'Applications'); ?> area and add it to the list.
</p>

<?hdelim()?>

<?php

commonFooter();

?>
