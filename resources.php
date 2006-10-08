<?php

commonHeader('Resources');

?>

<h1>Resources</h1>

<p>
There are various resources for PHP-GTK.  Below are 
listed the ones that we are aware of.  If you know of others 
please <?php print_email('php-gtk-webmaster_at_lists_dot_php_dot_net', 'email the webmaster'); ?>.
</p>

<a name="lists"></a>
<h2>Mailing Lists</h2>

<p>
There are various mailing lists for PHP-GTK. Each list is dedicated to a 
different part of the PHP-GTK project. To subscribe to a list, send an email
to the address listed in the SUBSCRIBE column.</p>

<table style="border: 1px solid black; text-align: left;" rules="all">
 <thead>
  <tr>
   <th>LIST</th>
   <th>DESCRIPTION</th>
   <th>ADDRESS</th>
   <th>SUBSCRIBE</th>
   <th>ARCHIVE</th>
  </tr>
 </thead>
 <tbody>
  <tr valign="top">
   <td><strong>php-gtk-general</strong></td>
   <td>For general discussion about using PHP-GTK.</td>
   <td><?php print_email('php-gtk-general_at_lists_dot_php_dot_net'); ?></td>
   <td><?php print_email('php-gtk-general-subscribe_at_lists_dot_php_dot_net'); ?></td>
   <td><?php print_link('http://marc.theaimsgroup.com/?l=php-gtk-general', 'MARC'); ?></td>
  </tr>
  <tr valign="top">
   <td><strong>php-gtk-dev</strong></td>
   <td>For the discussion about the development of PHP-GTK itself.</td>
   <td><?php print_email('php-gtk-dev_at_lists_dot_php_dot_net'); ?></td>
   <td><?php print_email('php-gtk-dev-subscribe_at_lists_dot_php_dot_net'); ?></td>
   <td><?php print_link('http://marc.theaimsgroup.com/?l=php-gtk-dev', 'MARC'); ?></td>
  </tr>
  <tr valign="top">
   <td><strong>php-gtk-doc</strong></td>
   <td>For discussion about the writing and translation of the PHP-GTK documentation.</td>
   <td><?php print_email('php-gtk-doc_at_lists_dot_php_dot_net'); ?></td>
   <td><?php print_email('php-gtk-doc-subscribe_at_lists_dot_php_dot_net'); ?></td>
   <td><?php print_link('http://marc.theaimsgroup.com/?l=php-gtk-doc', 'MARC'); ?></td>
  </tr>
  <tr valign="top">
   <td><strong>php-gtk-cvs</strong></td>
   <td>Has all CVS commits to PHP-GTK and related projects posted to it automatically.</td>
   <td><?php print_email('php-gtk-cvs_at_lists_dot_php_dot_net'); ?></td>
   <td><?php print_email('php-gtk-cvs-subscribe_at_lists_dot_php_dot_net'); ?></td>
   <td><?php print_link('http://marc.theaimsgroup.com/?l=php-gtk-cvs', 'MARC'); ?></td>
  </tr>
  <tr valign="top">
   <td><strong>php-gtk-webmaster</strong></td>
   <td>For discussion about updating and maintaining the PHP-GTK website.</td>
   <td><?php print_email('php-gtk-webmaster_at_lists_dot_php_dot_net'); ?></td>
   <td><?php print_email('php-gtk-webmaster-subscribe_at_lists_dot_php_dot_net'); ?></td>
   <td><?php print_link('http://marc.theaimsgroup.com/?l=php-gtk-webmaster', 'MARC'); ?></td>
  </tr>
 </tbody>
</table>


<a name="irc"></a>
<h2>IRC</h2>

<p>
The <b>#php-gtk</b> IRC channel on Freenode has a few regulars who can most
likely answer the questions you have.
</p>

<a name="sites"></a>
<h2>Sites</h2>

<h3>Applications/Code</h3>

<ul>
<li><?php print_link('http://www.cweiske.de/phpgtk.htm', 'PHP-GTK Application Downloads at cweiske.de') ?><br />
This site provides several PHP-GTK freeware applications for download, as well as some reusable code for PHP-GTK programmers</li>

<li><?php print_link('http://www.gnope.org', 'Gnope.org'); ?><br />
PHP-GTK Windows installer and support forum. Gnope.org also provides application downloads via their PEAR channel.</li>

<li><?php print_link('http://pear.php.net/search.php?q=gtk2&amp;in=packages', 'PEAR PHP-GTK 2 Packages'); ?><br />
PHP-GTK 2 packages available from PEAR.</li>
</ul>

<h3>Documentation/Help</h3>

<ul>
<!--
<li><?php print_link('http://gtk.php.net/wiki/', 'PHP-GTK Wiki') ?><br />
This site allows the PHP-GTK community to help contribute documentation to the
PHP-GTK project.</li>
-->

<li><?php print_link('http://developer.gnome.org/doc/API/2.0/gtk/index.html', 'GTK+ Reference Manual'); ?><br />
The GTK+ manual with a list of all widgets and their corresponding functions/attributes.</li>

<li><?php print_link('http://mail.gnome.org/archives/gtk-list/', 'GTK+ mailing list archives'); ?><br />
This list might be useful if you have a certain GTK+ question or problem that
PHP-GTK list has no information about.</li>

<li><?php print_link('http://www.writingup.com/blog/phpgtk2', 'Ron Tarrant\'s PHP-GTK 2 Blog'); ?><br />
Ron Tarrant's blog contains many articles and tutorials for PHP-GTK 2 developers.</li>

<li><?php print_link('http://crisscott.com/category/php-gtk/', 'Crisscott.com'); ?><br />
PHP-GTK weekly news summaries.</li>

<li><?php print_link('http://www.kksou.com/php-gtk2/index.php', 'kksou.com'); ?><br />
PHP-GTK Cookbook.</li>
</ul>

<h3>Regional Portals</h3>

<ul>
<li><?php print_link('http://www.php-gtk.com.br/', 'Brazilian PHP-GTK Community Portal'); ?></li>

<li><?php print_link('http://www.php-gtk2.de', 'German PHP-GTK 2 Portal'); ?></li>
</ul>

<a name="onlinearticles"></a>
<h2>On-line Publications</h2>

<ul>

<li>&quot;<?php print_link('http://www.devx.com/opensource/Article/21235/0',
                   'Develop Desktop GUI Apps with PHP-GTK, the Standalone PHP'); ?>&quot;
    by Gregory L. Magnusson</li>

<li>&quot;<?php print_link('http://www.goldweb.com.au/~davidj/articles/html/1.html',
                   'Introductory PHP-GTK'); ?>&quot; 
    by David Jorm</li>

<li>&quot;<?php print_link('http://www.webmasterbase.com/article/697',
                   'Build Cross-Platform Windowed Apps with PHP'); ?>&quot;
    by Mitchell Harper</li>

<li>&quot;<?php print_link('http://products.magnet-i.com/phpgale/php-gtk_endliess_possibilities.pdf',
                   'PHP-GTK: Endless Possibilities') ?>&quot;
    by Nirav Mehta, Vaishali Master, and Piyush Shah</li>

<li>&quot;<?php print_link('http://hades.phparch.com/ceres/public/article/index.php/art::php_gtk::what_is_php_gtk', 'What is PHP-GTK'); ?>&quot; by Scott Mattocks</li>

<li>&quot;<?php print_link('http://hades.phparch.com/ceres/public/article/index.php/art::php_gtk::hello_php_gtk', 'Hello PHP-GTK 2'); ?>&quot; by Scott Mattocks</li>

</ul>

<a name="printarticles"></a>
<h2>Print Publications</h2>


<ul>
<li>&quot;<?php print_link('http://phpmagazin.de/itr/online_artikel/psecom,id,831,nodeid,62.html', 'Aktuelle Entwicklungen beim PHP-GTK'); ?>&quot;
     by Christian Weiske<br />
    <em>PHP Magazin</em>, 07.2006</li>

<li>&quot;<?php print_link('http://www.amazon.com/gp/product/1590596137/', 'Pro PHP-GTK'); ?>&quot;
    by Scott Mattocks<br />
    <em>Apress</em>, 04.2006</li>

<li>&quot;<?php print_link('http://www.phpmagazin.de/itr/ausgaben/psecom,id,287,nodeid,60.html', 'Rapid Application Development Mit PHP-GTK'); ?>&quot;
     by Christian Weiske<br />
    <em>PHP Magazin</em>, 10.2005</li>

<li>&quot;<?php print_link('http://www.phparch.com/issue.php?mid=52', 'Turning a Class Into an Application With PHP-GTK'); ?>&quot;
     by Scott Mattocks<br />
    <em>PHP|Architect</em>, 03.2005</li>

<li>&quot;<?php print_link('http://www.phparch.com/issue.php?mid=42', 'PHP-GTK and the Glade GUI Builder: Building Client Applications with Style'); ?>&quot;
    by Tony Leake<br />
    <em>PHP|Architect</em>, 10.2004</li>

<li>&quot;<?php print_link('http://www.php-mag.net/magphpde/magphpde_article/psecom,id,426,nodeid,21.html', 'Use your mouse'); ?>&quot;
    by Steph Fox<br />
    <em>International PHP Magazine</em>, 06.2004</li>

<li>&quot;<?php print_link('http://www.phpmag.net/itr/ausgaben/psecom,id,212,nodeid,112.html', 'Making a GUI Mess of PHP: Building \'Stand-alone\' GUI Applications with PHP-GTK');?>&quot; 
    by Ben Ramsey<br />
    <em>International PHP Magazine</em>, 05.2004</li>

<li>&quot;<?php print_link('http://www.phparch.com/issue.php?mid=24', 'Offline News Management with PHP-GTK'); ?>&quot;
    by Morgan Tocker<br />
    <em>PHP|Architect</em>, 02.2004</li>

</ul>

<a name="presentations"></a>
<h2>Presentations</h2>

<ul>
<li><?php print_link('http://www.gravitonic.com/do_download.php?download_file=talks/php-quebec-2006/php-gtk-2.pdf', 'PHP Quebec 2006'); ?> &quot;PHP-GTK 2&quot; by Andrei Zmievski</li>

<li><?php print_link('http://www.gravitonic.com/do_download.php?download_file=talks/phptropics2005/php-gtk2_phptropics2005.pdf', 'php|tropics 2005'); ?> &quot;Say Hello to PHP-GTK 2&quot; by Andrei Zmievski</li>

<li><?php print_link('http://talks.php.net/show/vancouver-gtk', 'Vancouver 2004'); ?> &quot;PHP-GTK: Something Old, Something New&quot; by Andrei Zmievski</li>
</ul>

<a name="development"></a>
<h2>Development</h2>

<ul>
 <li><?php print_link('http://php-gtk2.de/manual/coverage.htm', 'PHP-Gtk2 documentation coverage analysis') ?></li>
 <li><?php print_link('http://php-gtk2.de/manual/classcoverage.htm', 'PHP-Gtk2 implementation coverage analysis') ?></li>
</ul>

<?php

commonFooter();

?>
