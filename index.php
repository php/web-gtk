<?php

/*
$SIDEBAR_DATA = <<< EOF
<h3>Warning!</h3>
<P>
This code is a highly experimental adaptation 
of the instructions beamed to us by the friendly aliens of Tau 
Ceti.  The API can -- and will -- be changing, evolving, and unpredictably 
morphing into little furry Ewoks, fluorescent killer bunny rabbits, 
and the knights who say 'Ni'.  Use the code at your own risk, 
as it may cause flooding, polydactism, frogs falling from the 
sky, and the return of the Inca empire.
</P>
<P>
It will definitely warp space-time continuum in your local area.
<P>
EOF;
*/

commonHeader();

?>

<h1>PHP-GTK</h1>

<P>
PHP-GTK is an extension for PHP programming language that implements language
bindings for GTK+ toolkit. It provides an object-oriented interface to GTK+
classes and functions and greatly simplifies writing client side cross-platform
GUI applications.
</P>

<h1>News</h1>

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

hdelim();

<p>
Andrei Zmievski gave a presentation and a workshop on PHP-GTK at the Fórum Internacional Software Livre 2002 in Porto Alegre, Brazil. The presentation is available online at <?print_link('http://conf.php.net/br-gtk')?>.
</p>

hdelim();

<p>
<a href="/download.php">PHP-GTK Version 0.5.1</a> has been released today, April
26, 2002. The main goal was to adapt to the new PHP build system while
preserving compatibility for the old one. Of course, some bug fixes and
improvements are included as well. See <a href="/changelog.php">Change Log</a>
for full list of changes.
</p>

hdelim();

<p>
With the help of Philip Hallstrom, we now have a Freshmeat-like index of
applications. It still needs to be populated, so if you have written a useful
piece of software using PHP-GTK, point your browser to
<? print_link('/apps/', 'Applications'); ?> area and add it to the list.
</p>


<h1>Resources</h1>

<P>
Check out our <? print_link('/resources.php', 'Resources page'); ?> for links to
PHP-GTK related sites, instructions on the PHP-GTK mailing lists, and other
PHP-GTK resources. Please try to use <strong>#php-gtk</strong> channel on EFNet
or irc.openprojects.net - the more people are there, the better for community.
</P>



<h1>Contact</h1>

<P>
If you have problems or questions then your first point of contact should be the
manual and the mailing list.
</P>
<P>
Any serious PHP-GTK related questions should be sent to 
<?php print_email('andrei at php dot net'); ?> ... unless
they are related to the manual, in which case they should be sent 
to <?php print_email('jmoore at php dot net'); ?>.  If you have 
a question or suggestion for the website, you should contact 
<?php print_email('gtk-webmaster at php dot net'); ?>.
</P>


<?php

commonFooter();

?>
