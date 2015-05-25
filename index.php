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
    <a href="mailto:andrei@php.dot.net">andrei@php.dot.net</a>, unless 
    they are related to the manual, in which case they should be sent to 
    <a href="mailto:sfox@php.net">sfox@php.net</a>. If you have 
    a question or suggestion for the website, you should contact 
    <a href="mailto:php-gtk-webmaster@lists.php.net">
    php-gtk-webmaster@lists.php.net</a>.</p>

<h3>Syndication</h3>
<p>Our news is available as an <a href="/news.rss">RSS feed</a>. Also, a 
    <a href="/docs-rss.php">documentation feed</a> that lists recently updated 
    manual pages is available in RSS format.</p>
EOF;

commonHeader();

?>

<h1>PHP-GTK is not dead.</h1>
<span class="newsDate">[25-may-2015]</span>
<b><font color=blue>Just had a short break to return stronger.</font></b><br />
We are gradually correcting the gtk.php.net site links.<br />
We have beta builds with PHP 5.4 and PHP 5.5.<br />
The developers that can help in php-gtk source code have the best support structure in gtihub:<br />
https://github.com/php/php-gtk-src<br />
Join us.<br />

<h1>A Year Later...</h1>
<p><span class="newsDate">[5-Aug-2010]</span>
Dropping by to let the PHP-GTK community know that development <em>is</em>
still happening! The project is being split up into different projects, 
<a href="http://pecl.php.net/cairo">PECL/Cairo</a>, GLib, GObject, etc.</p>
<p>While development is slow, there are still a few crazy people hacking away
into the early hours.</p>
<p>Sit tight!</p>

<p>P.S. If you find that you're crazy enough to want to help the PHP-GTK
project get back into rhythm, the guys are very welcoming. Find us on the 
#php-gtk channel on Freenode.</p>

<?php hdelim(); ?>

<h1>We're still here!</h1>
<p><span class="newsDate">[28-May-2009]</span>
Rumours of PHP-GTK's death have been greatly exaggerated! The project is
very much still alive, but we're waiting for PHP 5.3 to come out, and also some
work needs to be done on the Cairo extension before a new release can be made.
This should be completed soon. This release will come with support for GTK+ 2.14
and 2.16, Cairo, and PHP 5.3.</p>
<p>The next release will also include official installers for Windows and Mac OSX, 
and an installer script (thank you bob) for Linux.</p>
<p>If you are interested in helping out with the project, there are many ways
to get involved. Contributions of code and tests are always welcome. You can
get in touch on our <a href="http://news.php.net/php.gtk.dev">development
mailing list</a>.  We're also looking at improving the PHP-GTK documentation
and website, which has its own <a
href="http://news.php.net/php.gtk.doc">mailing list</a> too. Alternatively,
join us in #php-gtk on the Freenode IRC network.</p>

<?php hdelim(); ?>

<h1>PHP-GTK 2.0.1 released</h1>
<p><span class="newsDate">[16-May-2008]</span>
PHP-GTK 2.0.1 has been released, head over to the <a href="download.php">download</a> page and get your copy.
This release, named <em><a href="changelog.php">you knew this was coming</a></em>, adds full support for
GtkBuilder and tooltips; in addition to a slew of bug fixes and overrides.</p>
<p>Coming up next: <a href="http://openaki.wordpress.com/">Akshat Gupta</a>, our student for the Summer of Code 
program this year will be working on <a href="http://cairographics.org/">cairo</a> support for PHP-GTK. We're
still looking for more people to help us out with development and documentation - please
<a href="resources.php">get in touch</a> with us if you're interested.</p>
  
<?php hdelim(); ?>

<h1>Summer of Code 2008</h1>
<p><span class="newsDate">[21-March-2008]</span>
The 2008 edition of the <a href="http://code.google.com/soc/2008/">Google Summer of Code</a> is here! The PHP project will be
<a href="http://code.google.com/soc/2008/php/about.html">participating</a> and you can propose PHP-GTK related projects.
If you're an <a href="http://code.google.com/opensource/gsoc/2008/faqs.html#0.1_eligibility">eligible</a> student, take a look
at some of our <a href="http://wiki.php.net/gsoc/2008#php-gtk">project ideas</a> to get started. Mentors will be available
on the development mailing list and on IRC for feedback on your application. All the best!</p>

<?php hdelim(); ?>

<h1>PHP-GTK 2 is Here!</h1>
<p><span class="newsDate">[29-February-2008]</span>
After a long development and QA cycle, we are proud to release <a href="http://gtk.php.net/download.php">version 2.0</a> of
PHP-GTK. This release, named <em><a href="changelog.php">leap day special</a></em>, marks PHP-GTK 2 as stable and comes with support for
<a href="http://gtk.org/">GTK+</a>
versions 2.6 through 2.12. Although support for more recent versions than 2.8
is not 100% complete, we hope to cover as much of the API as possible in
upcoming releases.</p>

<p>This release comes with support for custom GTypes and signals, more API
coverage, and the usual slew of bug fixes. Take a look at the Changelog for
detailed information on changes since the beta.</p>

<p>If you're looking to learn PHP-GTK, the <a href="http://gtk.php.net/docs.php">documentation</a> is a great place to
start. There's also an excellent <a href="http://www.amazon.com/gp/product/1590596137/">book from Apress by Scott Mattocks</a> on the
topic. We hope you will enjoy developing applications with PHP-GTK 2. Please
don't hesitate to file bug reports at the <a href="http://bugs.php.net/">bug tracker</a>, or give us feedback on
the <a href="http://gtk.php.net/resources.php#lists">php-gtk-general</a> mailing list. Have fun! 
</p>

<?php hdelim(); ?>

<h1>PHP-GTK 2 Beta!</h1>
<p><span class="newsDate">[17-June-2007]</span>
The PHP-GTK team is proud to announce the release of a beta version of
<a href="about.php">PHP-GTK 2</a>. This release, aptly named
<em><a href="changelog.php">extension extravaganza</a></em>, brings with
it tons of new features that you can look forward to:</p>
<ul>
<li>Overall API coverage is now at 90%, with over 95% coverage for just
the Gtk+ API.</li>
<li>The GtkTreeView widget has been significantly enhanced with custom
model and drag-and-drop support</li>
<li>Basic clipboard functionality is now supported.</li>
<li>Exciting new cross-platform widgets now available through the GtkSpell,
GtkExtra, GtkHTML3, libsexy and Scintilla extensions</li>
<li>Gtk+ versions 2.8 and 2.10 are now supported, which brings along a host
of new features such as enhanced printing support; revamped GtkIconView,
GtkNotebook; GtkPlug/Socket support for Win32; and a variety of new widgets
like GtkStatusIcon and GtkAssistant.</li>
<li>The usual set of bug fixes and unit test additions.</li>
</ul>
<p>Head over to the <a href="download.php">download</a> section and grab
a tarball. PHP-GTK 2 is now one step closer to a final release. Thanks to
entire PHP-GTK team for making this release possible!</p>

<?php hdelim(); ?>

<h1>PHP-GTK Teams for the PHPThrowdown</h1>
<p><span class="newsDate">[12-January-2007]</span>
The <a href="http://www.phpthrowdown.com">PHPThrowdown</a> is a competition to see
which team or individual can build the best application in 24 hours. Its a test of
skill and stamina. Most people expect to see a whole bunch of web applications, but we
here in the PHP-GTK community know that the best applications are written with PHP-GTK.
To help prove this point to the rest of the world, a few teams are being organized to
enter PHP-GTK applications into the contest. If you are interested in joining (or
leading) a team, be sure to sign up on the <a 
href="http://www.opsat.net/ptd/interestapp.php">PHP-GTK PHPThrowdown Team organization
form</a>.
</p>

<?php hdelim(); ?>

<h1>December News</h1>
<p><span class="newsDate">[13-December-2006]</span>
Interest in PHP-GTK is growing, and this is evident by the increasing number of
hits at the <a href="http://www.php-gtk.eu">community site</a>. The site
provides useful tips and code samples for PHP-GTK, be sure to stop by. Also, 
Christian <a href="http://php-gtk2.de/maps.html">created a map</a> which tells you where PHP-GTK 2 developers and users are located. Join us on #php-gtk on
Freenode and add yourself!
</p>
<p>
<a href="http://www.kateos.org/">KateOS</a>, a multitasking operating system;
includes a <a href="http://wikidoc.kateos.org/index.php/KatePKG-en">package manager written entirely in PHP-GTK 2</a>! This is the first time any distribution
has adopted PHP-GTK 2 at such a level; we hope this trend continues!
</p>
<p>
The Chinese translation of the PHP-GTK 2 manual has now begun. If you are
interested in contributing to the documentation or development of PHP-GTK 2 
then <a href="http://gtk.php.net/resources.php">get in touch</a> with us, and 
help in making a faster release!
</p>
<p>
<a href="http://www.callicore.net/">Callicore</a> is a framework for PHP-GTK 2 and provides a set of re-usable classes designed to make application development
quicker and painless. Though no releases have been made yet, the code from the 
repository is pretty usable.
</p>

<?php hdelim(); ?>

<h1>Taking Conferences by Storm</h1>
<p><span class="newsDate">[22-September-2006]</span>
It's conference season in the PHP world and no PHP conference would be complete without a PHP-GTK 2 presentation (you hear that DCPHP!). Earlier this month Andrei, demonstrated how easy it is to create powerful desktop applications with PHP-GTK 2 at <a href="http://hades.phparch.com/ceres/public/page/index.php/works::schedule::synopses::php_gtk2">PHP|Works</a> in Toronot. Next, in October, Scott will be speaking at the <a href="http://www.zendcon.com/">Zend/PHP Conference</a>. Finally, in early November, Steph will talk about the new features of PHP-GTK 2 at the <a href="http://phpconference.com/konferenzen/psecom,id,482,track,7,nodeid,,_language,uk.html">International PHP Conference</a> and demonstrate how to make lightweight cross-platform applications.
</p>

<h1>Online Help</h1>
<p><span class="newsDate">[22-September-2006]</span>
While the development team works hard to finish the API (90% coverage is not far off), a new set of online tutorials has sprung up recently <a href="http://www.kksou.com/php-gtk2/index.php">kksou.com</a>. The tutorials are short and to the point. They cover those nagging issues that don't necessarily prevent you from completing your application, but add a great deal to the finished product.
</p>

<?php hdelim(); ?>

<h1>Documentation Filling Out</h1>
<p><span class="newsDate">[10-August-2006]</span>
This week, the <a href="http://gtk.php.net/docs.php">PHP-Gtk2 documentation</a> broke the 44.44% barrier: nearly half of the classes and their methods, properties and signals are documented. PHP-GTK 2 consists of 202 classes with nearly 2,900 methods, and many signals and properties. As the documentation matures, PHP-GTK 2 becomes easier to work with as the answers to many common problems become easier to find. 
</p>
<p>
We ask you to help us fill in the white spaces and create examples for others to learn from. Writing documentation not only helps the project, but also helps you learn through experimenting with new methods, and gain a better understanding of the inner workings of the project. Interested? The <a href="http://gtk.php.net/resources.php">doccing tutorial</a> explains the first steps, and the <a href="http://gtk.php.net/resources.php">php-gtk-doc mailing list</a> is the central place for all manual issues. All help creating examples and writing or translating documentation, is appreciated.
</p>

<?php hdelim(); ?>

<h1>PHP-GTK 2 Alpha Re-release</h1>
<p><span class="newsDate">[17-July-2006]</span>
Apparently, PEAR infrastructure tools (due to a deficiency in PHP's <tt>version_compare()</tt>
function) cannot handle a version modifier called "zeta". We had to rename it to
good old "alpha", re-package and re-release. <a href="download.php">Download it</a> if you plan to use PEAR's
or <a href="http://gnope.org/">gnope.org</a>'s packages.</p>

<?php hdelim(); ?>

<h1>PHP-GTK 2 Zeta Release</h1>

<p><span class="newsDate">[15-July-2006]</span>
After a long development cycle, PHP-GTK team is proud to announce the first
official preview release of
<a href="about.php">PHP-GTK 2</a>. Since everyone has been
patiently waiting for this
<a href="download.php">release</a> for quite a while, we have
decided to skip a few letters of the Greek alphabet and go straight to <a href="http://en.wikipedia.org/wiki/Zeta_%28letter%29">zeta</a>,
which does not get nearly enough respect in the software world compared to its
brethren. So, without further ado, please welcome <a
href="changelog.php">PHP-GTK 2.0.0 Zeta</a>!
</p>

<?php hdelim(); ?>

<h1>PHP-GTK 2 Resources</h1>

<p><span class="newsDate">[18-May-2006]</span>
The number of PHP-GTK 2 resources has been climbing steadily as development
continues. As it stands now there are <a
href="http://pear.php.net/search.php?q=gtk2&amp;in=packages&amp;x=0&amp;y=0">eight PHP-GTK
2 packages</a> available from <a href="http://pear.php.net">PEAR</a>. 
The availability of the <a href="http://gtk.php.net/docs.php">PHP-GTK 2 
documentation</a> provides an online resources for developers needing help with
the PHP-GTK 2 API. Included in the online documentation is a <a
href="http://gtk.php.net/manual/en/tutorials.helloglade.php">new tutorial on 
using Glade with PHP-GTK 2</a>. In addition <a 
href="http://gnope.org/">several</a> <a 
href="http://www.writingup.com/blog/phpgtk2">websites</a> <a 
href="http://www.crisscott.com/">devoted</a> to PHP-GTK 2 have cropped up 
providing a wide range of resources. Finally, the first PHP-GTK 2 book, <a 
href="http://www.amazon.com/gp/product/1590596137/">Pro PHP-GTK</a>, has been 
published. All of these resources should provide a strong launching point for 
any developer wanting to get a head start working with the soon-to-be-released 
alpha version of PHP-GTK 2.
</p>

<?php hdelim(); ?>

<h1>Moving toward a release of PHP-GTK 2</h1>

<p><span class="newsDate">[28-Feb-2006]</span>
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

<?php hdelim(); ?>

<h1>PHP-GTK 2 Progress</h1>

<p><span class="newsDate">[23-Jan-2006]</span>
Development of PHP-GTK 2 is steadily picking up pace. The last month has seen
plenty of activity not only in commits to CVS but in other parts of the PHP-GTK
2 community also:
</p>
<ul>
 <li>The PHP-GTK 2 documentation is filling out. More classes have been
     documented and given examples (especially the GtkTree* classes).</li>
 <li>Source code highlighting has been added to the
     <a href="http://php-gtk2.de/manual/en/html/">PHP-GTK 2 manual</a>.</li>
 <li>Most of the get_size* methods have been implemented.</li>
 <li><a href="http://xml.cweiske.de/classcoverage.htm">85% of all
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

<?php hdelim(); ?>

<h1>Gnope Installer Released</h1>

<p><span class="newsDate">[11-Dec-2005]</span>
Version 1.0 of the <a href="http://www.gnope.org">Gnope Installer</a> has
been released. The Gnope installer helps to set up a full featured PHP-GTK2
installation on a Windows system with just a few clicks. It is designed to
make installation of PHP-GTK2 and PHP-GTK2 applications quick and easy. For
more information or to download Gnope visit 
<a href="http://www.gnope.org">http://www.gnope.org</a>.
</p>

<?php hdelim(); ?>

<h1>October News</h1>

<p><span class="newsDate">[21-Oct-2005]</span>
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

<p><span class="newsDate">[25-Jul-2005]</span>
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

<p><span class="newsDate">[25-Jul-2005]</span>
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

<p><span class="newsDate">[15-Jul-2005]</span>
 <a href="/download.php">PHP-GTK 1.0.2</a> is a minor release that fixes
 a bug in the build process that prevented PHP-GTK from being installed
 with the newly released PHP 4.4.x branch.
</p>

<?php hdelim(); ?>

<h1>Getting Ready for PHP-GTK 2</h1>

<p><span class="newsDate">[18-May-2005]</span>
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

<!--
<?php hdelim(); ?>

<h1>A Message from Andrei</h1>

<p><span class="newsDate">[22-Apr-2005]</span> I finished porting the first
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
