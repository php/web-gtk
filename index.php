<?php
/*
 * $Id$ 
 */

// Start output buffering in order to grab the data from the documentation
// CVS updates file (that is echoed when included) and save to a variable
// instead of echoing it right away.
ob_start();
?>
<div id="docsupdates">
<h3>Docs Updates</h3>
<p>
<?php
include_once 'manual/en/updates.php';
?>
</p>
</div>
<?php
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
<p>Our news is available as an <a href="/news.rss">RSS feed</a>. Also, a 
    <a href="/docs-rss.php">documentation feed</a> that lists recently updated 
    manual pages is available in RSS format.</p>
EOF;

commonHeader();

?>

<h1>Moving toward a release of PHP-GTK 2</h1>

<p><span class="newsdate">[28-Feb-2006]</span>
This month PHP-GTK 2 has continued its march toward an initial release. Andrei 
has been working through bug fixes and 
<a href="http://cvs.php.net/viewcvs.cgi/php-gtk/ChangeLog?view=markup">implementing new features</a>. 
Recently he added the ability to use GtkListStores and GtkTreeStores as if 
they were 
<a href="http://marc.theaimsgroup.com/?l=php-gtk-general&amp;m=114029530823343&amp;w=2">iterators or arrays</a>. 
This makes it much easier to work with data models for GtkTreeView and 
GtkComboBox. The documentation team has been working hard to fill out the docs.
Several new pages have been added and the PHP-GTK 2 docs will soon make their 
first appearance on the PHP-GTK website.
</p>
<p>
Even though PHP-GTK 2 is not quite stable yet, several applications have been 
developed using the CVS version. There are now four PHP-GTK 2 packages 
available on PEAR including the newly added 
<a href="http://pear.php.net/package/Gtk2_ScrollingLabel">Gtk2_ScrollingLabel</a> 
and <a href="http://pear.php.net/package/Gtk2_PHPConfig">Gtk2_PHPConfig</a>. 
Christian Weiske has released the first game developed with PHP-GTK 2: 
<a href="http://www.gnope.org/pearfront/index.php?package=Game_Minesweeper">Minesweeper</a>.
</p>

<h1>PHP-GTK 2 Progress</h1>

<p><span class="newsdate">[23-Jan-2006]</span>
Development of PHP-GTK 2 is steadily picking up pace. The last month has seen
plenty of activity not only in commits to CVS but in other parts of the PHP-GTK
2 community also:
<ul>
 <li>The PHP-GTK 2 documentation is filling out. More classes have been
     documented and given examples (especially the GtkTree* classes).</li>
 <li>Source code highlighting has been added to the
     <a href="http://php-gtk2.de/manual/en/html/">PHP-GTK 2 manual</a>.</li>
 <li>Most of the get_size* methods have been implemented.</li>
 <li><a href="http://xml.cweiske.de/php-gtk2%20coverage.xhtml">85% of all
     methods and properties have been implemented</a>. The other 15% need to be
     written by hand, and more are being added every week. (Some automatically
     generated methods may not be implemented correctly and will have to be
     re-written by hand. Therefore, the actual coverage figures may be slightly
     lower than those above)</li>
 <li>The <a href="http://www.gnope.org">Gnope installer</a> has been downloaded
     over 8000 times since its release last month.</li>
 <li><a href="http://pear.php.net/pepr/pepr-proposal-show.php?id=346">Gtk2_PHPConfig</a>,
     an application that makes it easy to modify php.ini files, has been
     proposed on <a href="http://pear.php.net">PEAR</a> by Anant Narayanan.</li>
</ul>
</p>

<?php hdelim(); ?>

<h1>Gnope Installer Released</h1>

<p><span class="newsdate">[11-Dec-2005]</span>
Version 1.0 of the <a href="http://www.gnope.org">Gnope Installer</a> has
been released. The Gnope installer helps to set up a full featured PHP-GTK2
installation on a Windows system with just a few clicks. It is designed to
make installation of PHP-GTK2 and PHP-GTK2 applications quick and easy. For
more information or to download Gnope visit 
<a href="http://www.gnope.org">http://www.gnope.org</a>.
<?php hdelim(); ?>

<h1>October News</h1>

<p><span class="newsdate">[21-Oct-2005]</span>
<a href="http://cweiske.de">Christian Weiske</a> has written an
<a href="http://www.phpmagazin.de/itr/ausgaben/psecom,id,287,nodeid,60.html">article</a>
for PHP Magazin titled "Rapid Application Development Mit PHP-GTK" which
discusses creating applications using PHP-GTK and Glade.
</p>
<p>An unofficial version of PHP-GTK 2 for Windows can be found at
<a href="http://ftp.emini.dk/pub/php/win32/gtk2/">http://ftp.emini.dk/pub/php/win32/gtk2/</a>.
If you are interested in helping test PHP-GTK 2 on Windows, please send your comments to the <a href="http://gtk.php.net/resources.php">dev mailing list</a>.
</p>

<?php hdelim(); ?>


<h1>PHP-GTK 2 at the International PHP Conference</h1>

<p><span class="newsdate">[25-Jul-2005]</span>
 <a href="http://www.jeremyjohnstone.com/blog">Jeremy Johnstone</a> will be
 presenting a talk titled
 <a href="http://www.phpconference.com/konferenzen/psecom,id,343,nodeid,,_language,uk.html">"GUI
 Development in PHP-GTK2"</a> at the International PHP Conference in November.
 Anyone going to the conference should be sure to check out his talk. The
 discussion includes "in depth coverage of developing a GUI application in
 PHP-GTK2 including tools you can use to allow you to rapidly develop new
 applications."
</p>

<?php hdelim(); ?>

<h1>Win9x Support in PHP 5.1</h1>

<p><span class="newsdate">[25-Jul-2005]</span>
 There is talk on the
 <a href="http://marc.theaimsgroup.com/?l=php-dev&amp;m=112142925911670&amp;w=2">PHP
 Internals mailing list</a> about removing support for Win9x (95/98/2000/ME)
 from PHP 5.1. For most PHP developers this isn't much of a big deal but for 
 PHP-GTK 2 developers it may have a much more significant impact. If you have
 reasons to keep Win9x support in PHP 5, make sure to
 <a href="http://netevil.org/node.php?uuid=42d7a64c-ffb7-0029-3508-2d7a64c62bef">voice
 your opinion</a>!
</p>

<?php hdelim(); ?>

<h1>PHP-GTK 1.0.2 Released</h1>

<p><span class="newsdate">[15-Jul-2005]</span>
 <a href="/download.php">PHP-GTK 1.0.2</a> is a minor release that fixes
 a bug in the build process that prevented PHP-GTK from being installed
 with the newly released PHP 4.4.x branch.
</p>

<?php hdelim(); ?>

<h1>Getting Ready for PHP-GTK 2</h1>

<p><span class="newsdate">[18-May-2005]</span>
 PHP-GTK 2 is getting closer and closer to a first release every day. At the
 <a href="http://www.phpconference.com/">International PHP Conference</a>, Andrei
 gave a <a href="http://www.gravitonic.com/talks/">talk</a> about the current 
 status of PHP-GTK 2 and the direction it is heading. Since then, excellent 
 progress has been made with trees and editable cells. Parameter reflection has 
 also been added thanks to Christian. The lastest efforts have led to the first
 set of practical applications written with PHP-GTK 2. Christian's 
 <a href="http://cweiske.de/phpgtk2_devinspector.htm">reflection browser</a> makes 
 it easy to take a look at the inner workings of PHP-GTK 2 classes and can be
 used as simple documentation. 
</p>

<?php hdelim(); ?>

<h1>A Message from Andrei</h1>

<p><span class="newsdate">[22-Apr-2005]</span> I finished porting the first
    demo from PyGTK, the stock item browser. It's in 
    <a href="http://cvs.php.net/co.php/php-gtk/demos/stock-browser.php">demos/stock-browser.php</a>
    and in the process I've implemented a fair amount of new
    GtkTreeView/GtkListStore functions. PHP-GTK 2 is coming along!
   </p>
   <p>Maybe a very early alpha release is due...
   </p>
   <p>-Andrei
   </p>
   <p>Any tester or developers interested in helping (Especially to port old
    override files so that CList and CTree work) please contact the 
    <a href="http://gtk.php.net/resources.php">PHP-GTK Dev mailing list</a>.
   </p>
   <p>In other news, Christian Weiske is making steady progress on the 
    documentation system. Docs skeletons can now be automatically generated
    for all of the classes that have been implemented so far. Read his 
    <a href="http://marc.theaimsgroup.com/?l=php-gtk-doc&amp;m=111316563116664&amp;w=2">post</a>
    to the documentation mailing list for more details.
   </p>

<?php hdelim(); ?>

<h1>PHP-GTK 2 Making Progress</h1>

<p><span class="newsdate">[21-Mar-2005]</span> PHP-GTK 2 is making great strides
   toward a working release. Andrei's relentless work has lead to a current CVS
   version that can run non-trivial scripts. See this 
   <a href="http://marc.theaimsgroup.com/?l=php-gtk-general&amp;m=111006182204075&amp;w=2">posting</a>
   to the general mailing list for an example. Take a look at the
   <a href="http://cvs.php.net/co.php/php-gtk/ChangeLog">change log</a> for the
   latest updates.</p>

<?php hdelim(); ?>

<h1>February News</h1>

<p><span class="newsdate">[22-Feb-2005]</span> It's getting close to
   conference season and with that comes a few talks about PHP-GTK. At
   the <a href="http://phpconference.com">International PHP Conference</a>, 
   <a href="http://gtk.php.net/wiki/Profiles/Ramsey?from=People.BenRamsey">Ben
   Ramsey</a> will be holding a talk titled "PHP in a Whole New World: Desktop
   Applications Built in PHP-GTK." At the same conference 
   <a href="http://gtk.php.net/wiki/Profiles/Andrei?from=People.AndreiZmievski">Andrei
   Zmievski</a> will be giving a much anticipated talk called, "Say Hello
   To PHP-GTK 2." The latest issue of the 
   <a href="http://php-mag.net">International PHP Magazine</a> has an 
   article by David Heath called "Free You CMS" which talks about "building
   an offline desktop client tool that is a synthesis of several exciting
   technologies: PHP-GTK, SQLite, and XML-RPC."</p>

<p>PECL developers, Alan Knowles and Val Khokhlov have release a new
   version of <a href="http://pecl.php.net/package/bcompiler">bcompiler</a>.
   bcompiler lets you "create a exe file of a PHP-GTK application."</p>

<?php hdelim(); ?>

<h1>Expanding Horizons</h1>

<p><span class="newsdate">[18-Jan-2005]</span> PHP-GTK development is
   growing in several directions. A recent <a 
   href="http://cvs.php.net/co.php/php-gtk/ChangeLog?r=1.259">barrage
   of commits</a> by Andrei shows that PHP-GTK 2 is moving ever closer
   towards a working release. At the same time, Ivan Rodriguez has been
   helping to add some GtkExtra classes to the <a 
   href="http://gtk.php.net/download.php">CVS versions</a> of both PHP-GTK
   1 and PHP-GTK 2.</p>

<p>Other PHP communities are contributing to PHP-GTK development in their 
   own way. PEAR has released another class, <a 
   href="http://pear.php.net/packages.php?catpid=34&amp;catname=Gtk+Components">Gtk_Styled</a>, 
   to help PHP-GTK developers write cleaner, more stable code. The folks 
   over at Zend have recognized everyone who has contributed to PHP-GTK 
   development, documentation or the web site by adding them to the "<a 
   href="http://www.zend.com/pear/whoiswho.php">Zend Who's Who of PHP</a>".<p>

<p>In other news, the GDK section of the manual has been completely 
   translated into <a href="http://gtk.php.net/manual1/ru/">Russian</a>.</p>

<?php hdelim(); ?>


<h1>PHP-GTK in business</h1>

<p><span class="newsdate">[20-Dec-2004]</span> There has been a lot of 
    discussion lately about the role PHP-GTK can and is playing in the 
    business world. Several people have <a
    href="http://marc.theaimsgroup.com/?l=php-gtk-general&amp;m=109903609804913&amp;w=2">commented</a>
    on the <a href="http://gtk.php.net/resources.php">php-gtk-general
    mailing list</a> about how they have developed secure, cross-platform
    applications for use in business with PHP-GTK. Using tools such as
    Roadsend's <a
    href="http://www.roadsend.com/home/index.php?pageID=compiler">PHP
    Compiler</a>, developers are able to create and distribute PHP-GTK
    applications that don't require the user to have a working installation
    first.</p>

<p>On the international level, PHP-GTK documentation is being translated
    into <a href="http://gtk.php.net/manual1/ru/">Russian</a> thanks to the
    work of Andrew Krasnyansky. Also, the organizers of the International
    PHP Conference have put out a <a
    href="http://www.phpconference.com/konferenzen/divers/psecom,id,191,nodeid,240.html">call
    for papers</a>. One of the requested topics is PHP-GTK.</p>

<?php hdelim(); ?>


<h1>Small steps into a better world</h1>

<p><span class="newsdate">[12-Nov-2004]</span> While work continues on 
    <a href="http://gtk.php.net/wiki/PhpGtk/Php-Gtk2">PHP-GTK 2</a>, there
    has been some big news with PHP-GTK 1. The continuing documentation 
    efforts have produced 
    <a href="http://gtk.php.net/manual1/en/tutorials.php">two new tutorials</a>
    and lots of new doc pages. To go along with all of the new documentation, 
    Christian Weiske has released 
    <a href="http://www.cweiske.de/phpgtk_coders.htm#manualbrowser">manualBrowser</a>, 
    a PHP-GTK application to make it easier to read and search the docs offline. 
    The folks over at PEAR have even jumped on the PHP-GTK bandwagon. There are 
    two new 
    <a href="http://pear.php.net/packages.php?catpid=34&amp;catname=Gtk+Components">gtk classes</a> 
    and a new PHP-GTK interface for PHPUnit.</p>

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
