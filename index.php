<?php
/*
 * $Id$ 
 */

// Start output buffering in order to grab the data from the documentation
// CVS updates file (that is echoed when included) and save to a variable
// instead of echoing it right away.
ob_start();
include_once '/manual/en/updates.php';
$RIGHT_SIDEBAR_DATA = ob_get_clean();


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

<h3>Syndication</h3>
<p>Our news is available as an <a href="/news.rss">RSS feed</a>.</p>
EOF;

commonHeader();

?>
<h1>PHP-GTK 2 is go for GTK+ 2.4</h1>

<p><span class="newsdate">[29-Jul-2004]</span> In a thread on 
    <strong>php-gtk-dev</strong> entitled "<a href="http://marc.theaimsgroup.com/?t=109090764000001&r=1&w=2">Gtk+
    2.2 or 2.4?</a>", developers discussed whether to base PHP-GTK 2 on GTK+ 
    2.2 or 2.4. The decision was quickly made, with no opposition or argument, 
    to <a href="http://marc.theaimsgroup.com/?l=php-gtk-dev&m=109104992017688&w=2">proceed 
    with using GTK+ 2.4</a>.</p>

<p>For more information on GTK+ 2.4, read <a href="http://mail.gnome.org/archives/gtk-app-devel-list/2004-March/msg00178.html">this 
    post</a> and <a href="http://mail.gnome.org/archives/gtk-list/2004-March/msg00111.html">this 
    post</a>.</p>

<?php hdelim(); ?>

<h1>PHP-GTK RSS feed added</h1>

<p><span class="newsdate">[28-Jul-2004]</span> The addition of an 
    <a href="/news.rss">RSS feed</a> allows the PHP-GTK Web site to 
    disseminate its news content throughout many different channels. Other 
    sites may now use the feed to aggregate news content from this site.</p>

<h1>Manual search bug fixed</h1>

<p><span class="newsdate">[28-Jul-2004]</span> A bug has been fixed in the 
    search functionality of the PHP-GTK Web site that caused problems when 
    searching on the manual. Now, searches on <code>connect</code>, 
    <code>window</code>, <code>child</code>, <code>beep</code>, etc. return 
    actual results instead of "cannot be found" messages.</p>

<p>Other upgrades to the manual search functionality are likely to follow.</p>

<?php hdelim(); ?>

<h1>New PHP-GTK wiki</h1>

<p><span class="newsdate">[27-Jul-2004]</span> We have set up a new 
    <a href="/wiki/Main/HomePage">wiki</a> that is faster and more easily
    manageable than our previous wiki. In addition, the new wiki is now 
    internally a part of the PHP-GTK Web site. Special thanks go to 
    <a href="http://manuel.kiessling.net/">Manuel Kiessling</a> who contributed 
    server resources to host the PHP-GTK Wiki up until the present.</p>

<p>In other news, <a href="http://www.php-mag.net">International PHP 
    Magazine's</a> <a href="http://www.php-mag.net/itr/psecom,id,207,nodeid,207.html">PHP 
    Barnstormer</a> made special mention of the increased activity here at PHP-GTK in
    <a href="http://www.php-mag.net/itr/kolumnen/psecom,id,8,nodeid,207.html">this 
    week's issue</a>.</p>

<?php hdelim(); ?>
    
<h1>Documentation updates</h1>

<p><span class="newsdate">[22-Jul-2004]</span> Thanks to Christian Weiske, 
    <a href="http://gtk.php.net/manual/en/gtk.gtkctree.php">GtkCTree</a> and 
    <a href="http://gtk.php.net/manual/en/gtk.gtkclist.php">GtkCList</a> have 
    both received some much-needed documentation. Andrei Zmievski has also 
    implemented a <a href="http://marc.theaimsgroup.com/?l=php-gtk-doc&m=109045054632510&w=2">nightly 
    build system</a> so the documentation can be updated regularly on the site 
    as content is added/updated by our documentation team. Also, notice that a 
    "whole site" search selection has been added to the search drop-down box. 
    This feature uses Google to search the PHP-GTK Web site.</p>

<h1>Slashdot mention</h1>

<p><span class="newsdate">[22-Jul-2004]</span> The increase in PHP-GTK 
    community activity and interest in PHP-GTK 2 has afforded this site a 
    <a href="http://developers.slashdot.org/developers/04/07/21/2328224.shtml">mention
    on Slashdot</a>. Thanks to <a href="http://blog.peoplesdns.com/blog/1">Joel 
    De Gan</a> for posting to Slashdot.</p>

<?php hdelim(); ?>

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

<!--

<?php hdelim(); ?>

<h1>PHP-GTK Brasil</h1>

<p>Brazilian PHP-GTK community has a new portal 
    <?php print_link('http://www.php-gtk.org.br/', 'site'); ?>.</p>

-->

<?php hdelim(); ?>

<h1>PHP-GTK 1.0.0 released</h1>

<p><span class="newsdate">[23-Oct-2003]</span> 
    <a href="/download.php">PHP-GTK Version 1.0.0</a> is finally out after 
    almost a year of being in stasis. This is probably the last major version 
    that will work with PHP 4 and GTK+ 1.x. There might be more bugfixes, but 
    no new features or upgrades will be implemented. PHP-GTK 2 is under 
    development and will focus on PHP 5 and GTK+ 2.x.</p>

<?php hdelim(); ?>

<!--

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

-->

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
