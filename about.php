<?php
/*
 * $Id$ 
 */

commonHeader('About PHP-GTK 2');

?>

<h1>PHP-GTK 2</h1>

<p>
PHP-GTK is an extension for the PHP programming language that implements 
language bindings for GTK+. It provides an object-oriented interface to GTK+ 
classes and functions and greatly simplifies writing client-side cross-platform
GUI applications.
</p>

<p>
PHP-GTK 2 is the second major release of PHP-GTK. PHP-GTK 2 combines the power
of PHP 5 with the flexibility of Gtk+ 2 to allow developers to create extremely
rich desktop applications with relative ease. PHP-GTK 2 not only 
simplifies the process of building applications with PHP, but also 
provides greater flexibility and more features than its predecessor.
</p>

<a name="features"></a>
<h2>Features</h2>

<ul>
<li><b>Powerful Object Oriented Programming</b><br />
Because PHP-GTK 2 is built ontop of PHP 5, it makes heavy use of the improved
object model. PHP-GTK 2 applications can implement Object Oriented practices 
such as inheritance, interfaces, overloading and exceptions.
</li>

<li><b>Improved Garbage Collection</b><br />
PHP-GTK 1 suffered from memory allocation issue because it was built ontop of
PHP 4, which was not designed with long running applications in mind. 
Improvements in PHP 5 have minimized memory leaks allowing for long running
applications without the fear of excessive memory consumption.
</li>

<li><b>Unicode Support</b><br />
Text in PHP-GTK 2 is always UTF-8 encoded making for applications which can 
easily be internationalized. PHP-GTK 2 will seamlessly handle conversion of
input and output strings based on a global code-page setting freeing the 
developer from worrying about most encoding problems.
</li>

<li><b>Model-View Architecture</b><br />
Gtk+ 2 implements a Model-View architecture to separate data from the display.
This allows for multiple representations of the same data in different ways and
greater control over the data itself. The separation of data from display makes
working with complex data like trees and multi-line text much easier than 
before.
</li>

<li><b>Improved Graphics Support</b><br />
Improvements in image support in Gtk+ 2 make displaying and manipulating images
and animations much easier with PHP-GTK 2. Aside from an extensive collection
of stock images, loading and manipulating custom images is relatively simple
when compared to working with images in PHP-GTK 1.
</li>

</ul>

<a name="changed"></a>
<h2>Changes</h2>

<p>
While every attempt has been made to preserve backward compatibility whereever
possible, some backward compatibility breaks were necessary.
</p>

<ul>

<li><b>Exceptions</b><br />
PHP-GTK 2 takes advantage of PHP 5's support for exceptions. Several widgets
may throw exceptions, normally during construction or when trying to convert
text to UTF-8.
</li>

<li><b>No More Global Constants</b><br />
In PHP-GTK 1, all constants were declared in the global namespace. In PHP-GTK
2, constants are declared in the top-level classes: Gtk, Gdk, Atk, and Pango.
This means the PHP-GTK 1 constant 
<pre style="display: inline;">GTK_WIN_POS_CENTER</pre> is accessed as
<pre style="display: inline;">Gtk::WIN_POS_CENTER</pre> in PHP-GTK 2.
</li>

<li><b>Creating Signal Handlers</b><br />
The <pre style="display: inline;">connect_object()</pre> and 
<pre style="display: inline;">connect_object_after()</pre> methods
have been deprecated in favor of 
<pre style="display: inline;">connect_simple()</pre> and 
<pre style="display: inline;">connect_simple_after()</pre>.
</li>

<li><b>Deprecated Widgets</b><br />
Many widgets have been deprecated in Gtk+ 2, and therefore are also deprecated
in PHP-GTK 2. Most deprecated widgets have been replaced with more powerful
widgets that are easier to use. While most deprecated widgets will still
function as they did with PHP-GTK 1, developers are strongly encouraged to 
update their applications to use the new and improved versions.
</li>

</ul>

<a name="more"></a>
<h2>More</h2>
<p>
These changes and more are covered in greater detail in the <a href="http://gtk.php.net/manual/en/tutorials.changes.php">Changes since PHP-GTK 1</a> tutorial. Users looking for help with the new release are 
encouraged to read the PHP-GTK 2 manual or contact the PHP-GTK General mailing list.
</p>

<?php

commonFooter();

?>
