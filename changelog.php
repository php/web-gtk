<?php

commonHeader('PHP-GTK Changelog');

?>

<h1>PHP-GTK ChangeLog</h1>

<a name="0.1"></a>
<h3>Version 0.1 "the void which binds"</h3>
<b>1-Aug-2001</b>
<ul>
<li>added GDK keysyms constants. (Andrei)</li>
<li>fixed bug with GtkStyle::copy() that was not returning the result properly. (Andrei)</li>
<li>implemented support for struct based classes (GdkRectangle, GtkAllocation, GtkRequisition, etc). (Andrei)</li>
<li>finished drag-n-drop support. (Andrei)</li>
<li>ported Scribble example from C. (Andrei)</li>
<li>modified GdkWindow::get_pointer() to be simpler, without XInput support.  (Andrei)</li>
<li>changed 'area' event property to be a GdkRectangle. (Andrei)</li>
<li>changed 'is_hint' event property to be boolean. (Andrei)</li>
<li>added ability to query the state and allocation of a widget. (Andrei)</li>
<li>added direct construction of pixmaps. (Andrei)</li>
<li>added GdkWindow::set_icon() method. (Andrei)</li>
<li>implemented GtkList methods insert_items() and prepend_items(). (Andrei)</li>
<li>implemented new PHP-like build system that supports adding extensions to PHP-GTK. (Andrei)</li>
<li>implemented GtkCTree methods node_get_pixtext(), node_get_pixmap(), and get_node_info().  (Andrei)</li>
<li>implemented GtkObject::emit(), thus allowing programmatical emission of signals. (Andrei)</li>
<li>added support for accessing GtkObject arguments via get_arg() and set_arg() methods. (Andrei)</li>
</ul>

<?php echo hdelim(); ?>

<?php

commonFooter();

?>
