<?php
/*
 * $Id$ 
 */

$SIDEBAR_DATA = <<< EOF
<h3>What is PHP-GTK?</h3>
<p>PHP-GTK is an extension for the <acronym 
    title="recursive acronym for PHP: Hypertext Preprocessor">PHP</acronym> 
    programming language that implements language bindings for 
    <acronym title="The GIMP Toolkit">GTK+</acronym>. It provides an 
    object-oriented interface to GTK+ classes and functions and greatly 
    simplifies writing client-side cross-platform GUI applications.</p>

<h3>Resources</h3>
<p>Check out our <a href="/resources.php">Resources page</a> for links to 
    PHP-GTK related sites, instructions on the PHP-GTK mailing lists, 
    and other PHP-GTK resources. Also, please try to use the 
    <strong>#php-gtk</strong> channel on Freenode IRC - the more people 
    there, the better for the community.</p>

<h3>Contact</h3>
<p>If you have problems or questions, your first point of contact should be 
    the manual and the <strong>php-gtk-general</strong> mailing list.</p>

<p>Any serious PHP-GTK related questions should be sent to 
    <a href="mailto:andrei at php dot net">andrei at php dot net</a>, unless 
    they are related to the manual, in which case they should be sent to 
    <a href="mailto:sfox at php dot net">sfox at php dot net</a>. If you have 
    a question or suggestion for the website, you should contact 
    <a href="mailto:php-gtk-webmaster at lists dot php dot net">
    php-gtk-webmaster at lists dot php dot net</a>.</p>
EOF;

commonHeader();

?>
<h1>PHP 5 release sparks renewed interest in PHP-GTK</h1>

<p><span class="newsdate">[20-Jul-2004]</span> Since the release of PHP 5.0.0 
    last week, the PHP-GTK mailing lists have seen a sharp spike in activity 
    due mostly to interest in PHP-GTK 2.0, the release of which is still in 
    the future.  This activity has brought about a massive call for updates 
    to the current PHP-GTK documentation and Web site, with the effort geared 
    toward promoting the extension and making the site and documentation more 
    thorough and user friendly.</p>

<p>This progress is now underway.  Already, much-needed updates are being made 
    to the documentation, and the Web site is undergoing new development to 
    provide better resources to visitors.  For more information regarding the 
    recent developments in the PHP-GTK community and the status of PHP-GTK, 
    please read Andrei Zmievski's "<a href="http://marc.theaimsgroup.com/?l=php-gtk-general&m=109029957326705&w=2">Letter 
    to the Community</a>" post and join the <strong>php-gtk-general</strong> 
    mailing list to follow along with the activity.</p>

<p>The forthcoming PHP-GTK version 2.0 will bind GTK+ 2 to PHP 5.  Until then, 
    PHP-GTK 1.0.0 works only with PHP 4.</p>

<?php hdelim(); ?>

<h1>PHP-GTK Brasil</h1>

<p>Brazilian PHP-GTK community has a new portal 
    <?php print_link('http://www.php-gtk.org.br/', 'site'); ?>.</p>

<?php hdelim(); ?>

<h1>PHP-GTK 1.0.0 Released!</h1>

<p><span class="newsdate">[23-Oct-2003]</span> 
    <a href="/download.php">PHP-GTK Version 1.0.0</a> is finally out after 
    almost a year of being in stasis. This is probably the last major version 
    that will work with PHP 4 and GTK+ 1.x. There might be more bugfixes, but 
    no new features or upgrades will be implemented. PHP-GTK 2 is under 
    development and will focus on PHP 5 and GTK+ 2.x.</p>

<?php hdelim(); ?>

<h1>PHP-GTK 0.5.2 Released!</h1>

<p><span class="newsdate">[01-Nov-2002]</span> 
    <a href="/download.php">PHP-GTK Version 0.5.2</a> is out. After a long 
    break, we have fixed some bugs and improved gdk-pixbuf functionality. 
    See <a href="/changelog.php">Change Log</a> for the full list of changes.
    </p>

<?php hdelim(); ?>

<h1>PHP-GTK Wiki</h1>

<p><?php print_link('http://wiki.gtk.php.net/'); ?> The general idea is that 
    the PHP-GTK community (including members of this list) can use the Wiki to 
    help provide better documentation for PHP-GTK. Be it HOWTOs, tips, FAQs, 
    case studies, or anything else that may be useful, if you want to write it, 
    the Wiki is there to accept it. Best of all, because adding to the Wiki is 
    as simple as clicking the "edit this document" button, there is hardly any 
    barrier between thinking of something and recording it.</p>

<p>There is practically no content up there right now, but the Wiki really 
    needs to be a community effort. If you have anything PHP-GTK related that 
    you think will be useful, add it in. Good content can then be rolled into 
    official PHP-GTK documentation later on.</p>

<?php hdelim(); ?>

<h1>Presentation on PHP-GTK</h1>

<p>Andrei Zmievski gave a presentation and a workshop on PHP-GTK at the Fórum 
    Internacional Software Livre 2002 in Porto Alegre, Brazil. The presentation 
    is available online at <?php print_link('http://conf.php.net/br-gtk'); ?>.
    </p>

<?php hdelim(); ?>

<h1>PHP-GTK 0.5.1 Released!</h1>

<p><span class="newsdate">[26-Apr-2002]</span> 
    <a href="/download.php">PHP-GTK Version 0.5.1</a> has been released today, 
    April 26, 2002. The main goal was to adapt to the new PHP build system 
    while preserving compatibility for the old one. Of course, some bug fixes 
    and improvements are included as well. See 
    <a href="/changelog.php">Change Log</a> for full list of changes.</p>

<?php hdelim(); ?>

<h1>Application Index Available</h1>

<p>With the help of Philip Hallstrom, we now have a Freshmeat-like index of
    applications. It still needs to be populated, so if you have written a 
    useful piece of software using PHP-GTK, point your browser to the 
    <?php print_link('/apps/', 'Applications'); ?> area and add it to the 
    list.</p>

<?php hdelim(); ?>

<?php

commonFooter();

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim: expandtab sw=4 ts=4 fdm=marker
 */
?>
