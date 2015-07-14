<?php

commonHeader('Resources');

?>

<h1>Resources</h1>

<p>
There are various resources for PHP-GTK.  Below are 
listed the ones that we are aware of.  If you know of others 
please <?php print_email('php-gtk-webmaster@lists.php.net', 'email the webmaster'); ?>.
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
   <td><?php print_email('php-gtk-general@lists.php.net'); ?></td>
   <td><?php print_email('php-gtk-general-subscribe@lists.php.net'); ?></td>
   <td><?php print_link('http://marc.info/?l=php-gtk-general', 'MARC'); ?></td>
  </tr>
  <tr valign="top">
   <td><strong>php-gtk-dev</strong></td>
   <td>For the discussion about the development of PHP-GTK itself.</td>
   <td><?php print_email('php-gtk-dev@lists.php.net'); ?></td>
   <td><?php print_email('php-gtk-dev-subscribe@lists.php.net'); ?></td>
   <td><?php print_link('http://marc.info/?l=php-gtk-dev', 'MARC'); ?></td>
  </tr>
  <tr valign="top">
   <td><strong>php-gtk-doc</strong></td>
   <td>For discussion about the writing and translation of the PHP-GTK documentation.</td>
   <td><?php print_email('php-gtk-doc@lists.php.net'); ?></td>
   <td><?php print_email('php-gtk-doc-subscribe@lists.php.net'); ?></td>
   <td><?php print_link('http://marc.info/?l=php-gtk-doc', 'MARC'); ?></td>
  </tr>
  <tr valign="top">
   <td><strong>php-gtk-cvs</strong></td>
   <td>Has all CVS commits to PHP-GTK and related projects posted to it automatically.</td>
   <td><?php print_email('php-gtk-cvs@lists.php.net'); ?></td>
   <td><?php print_email('php-gtk-cvs-subscribe@lists.php.net'); ?></td>
   <td><?php print_link('http://marc.info/?l=php-gtk-cvs', 'MARC'); ?></td>
  </tr>
  <tr valign="top">
   <td><strong>php-gtk-cvs</strong></td>
   <td>For the discussion on the development of PHP-GTK website.</td>
   <td><?php print_email('php-gtk-webmaster@lists.php.net'); ?></td>
   <td><?php print_email('php-gtk-webmaster-subscribe@lists.php.net'); ?></td>
   <td><?php print_link('http://news.php.net/php.gtk.webmaster', 'NEWS'); ?></td>
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

<li><?php print_link('http://pear.php.net/search.php?q=gtk2&amp;in=packages', 'PEAR PHP-GTK 2 Packages'); ?><br />
PHP-GTK 2 packages available from PEAR.</li>
</ul>

<h3>Documentation/Help</h3>

<ul>

<li><?php print_link('http://developer.gnome.org/doc/API/2.0/gtk/index.html', 'GTK+ Reference Manual'); ?><br />
The GTK+ manual with a list of all widgets and their corresponding functions/attributes.</li>

<li><?php print_link('http://mail.gnome.org/archives/gtk-list/', 'GTK+ mailing list archives'); ?><br />
This list might be useful if you have a certain GTK+ question or problem that
PHP-GTK list has no information about.</li>

<li><?php print_link('http://www.kksou.com/php-gtk2/index.php', 'kksou.com'); ?><br />
PHP-GTK Cookbook.</li>
</ul>

<h3>Regional Portals</h3>

<ul>
<li><?php print_link('http://www.php-gtk.com.br/', 'Brazilian PHP-GTK Community Portal'); ?></li>

<li><?php print_link('http://www.php-gtk.eu/', 'Worldwide PHP-GTK 2 community site'); ?></li>

</ul>

<a name="onlinearticles"></a>
<h2>On-line Publications</h2>

<ul>

<li>&quot;<?php print_link('http://www.devx.com/opensource/Article/21235/0',
                   'Develop Desktop GUI Apps with PHP-GTK, the Standalone PHP'); ?>&quot;
    by Gregory L. Magnusson</li>


<li>&quot;<?php print_link('http://www.webmasterbase.com/article/697',
                   'Build Cross-Platform Windowed Apps with PHP'); ?>&quot;
    by Mitchell Harper</li>


</ul>

<a name="books"></a>
<h2>Books</h2>

<ul>
<li>&quot;<?php print_link('http://www.amazon.com/gp/product/1590596137/', 'Pro PHP-GTK'); ?>&quot;
    by Scott Mattocks<br />
    <em>Apress</em>, 04.2006</li>

<li>&quot;<?php print_link('http://www.kksou.com/php-gtk2/PHP-GTK2-Demystified/', 'PHP-GTK2 Demystified'); ?>&quot;
    by kksou<br />
    ebook, 02.2007</li>
</ul>

<a name="printarticles"></a>
<h2>Print Publications</h2>

<a name="presentations"></a>
<h2>Presentations</h2>

<ul>
<li><?php print_link('http://talks.php.net/show/vancouver-gtk', 'Vancouver 2004'); ?> &quot;PHP-GTK: Something Old, Something New&quot; by Andrei Zmievski</li>
</ul>

<a name="development"></a>
<h2>Development</h2>

<?php

commonFooter();

?>