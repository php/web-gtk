<?php

commonHeader('PHP-GTK Changelog');

?>

<h1>PHP-GTK ChangeLog</h1>

<a name="1.0.0"></a>
<h3>Version 1.0.0 "mountain view special"</h3>
<b>23-Oct-2003</b>
<ul>
<li>added support for GtkCanvas widget (Alan)</li>
<li>added support for GdkImLib toolkit - experimental (Alan)</li>
<li>added support for GtkExtra widgets, GtkPlot, GtkSheet and many others (Angel Maza, Alan)</li>
<li>added get_wrap_mode, set_wrap_mode to GtkScintilla (Benjamin Smith)</li>
<li>fixed segfault when providing GtkCtree::insert_node wrong parameters</li>
<li>added GtkScintilla, GtkComboButton, GtkSpaned, GtkScrollpane to Win32 distribution (Frank)</li>
<li>fixed warning on GtkNotebook::switch-page signal (Alan)</li>
</ul>

<a name="0.5.2"></a>
<h3>Version 0.5.2 "Bass does a body good"</h3>
<b>01-Nov-2002</b>
<ul>
<li>simplified GdkPixbuf constructor parameters. (Andrei)</li>
<li>fixed setting of tile/stipple/clip_mask/bg_pixmap properties of GdkGC.  (Andrei)</li>
<li>implemented GdkPixbuf::fill(). (Andrei)</li>
<li>changed failure to allocate color to output only a notice instead of a warning. (Andrei)</li>
<li>made depth parameter of GdkPixmap constructor optional. (Andrei)</li>
<li>added copy_area() method for drawables. (Andrei)</li>
<li>added group() and set_group() methods for GtkRadioButton/GtkRadioMenuItem.  (Andrei)</li>
<li>added GDK functions pointer_grab(), pointer_ungrab(), keyboard_grab(), keyboard_ungrab(). (Andrei)</li>
<li>added utf8 support to GtkRadioButton, GtkToggleButton, GtkCheckMenuItem, and GtkCheckButton. (Frank)</li>
<li>fixed a crash bug when using non-string variables to access overloaded object's properties. (Andrei)</li>
<li>fixed a crash bug in GtkCheckButton constructor. (Andrei)</li>
</ul>

<a name="0.5.1"></a>
<h3>Version 0.5.1 "hardboiled wonderland"</h3>
<b>26-Apr-2002</b>
<ul>
<li>changed gdkwindow::set_cursor() to allow reverting the cursor to default one. (Andrei)</li>
<li>fixed gtk::input_add() for pre-streams PHP versions. (Andrei)</li>
<li>adapted build system to work with the new PHP build system. (Andrei)</li>
<li>made gtk::input_add() work with PHP streams. (Andrei)</li>
<li>fixed gtkscintilla::marker_add return type. (Alan)</li>
<li>fixed property and method access on GdkBitmap. (Andrei)</li>
<li>fixed a crash bug in gtkclist::append() when size of input was greater than the number of columns. (Markus)</li>
</ul>

<a name="0.5.0"></a>
<h3>Version 0.5.0 "monday starts on saturday"</h3>
<b>24-Jan-2002</b>
<ul>
<li>added new widgets with samples: GtkComboButton, GtkSPaned, GtkScrollPane and GtkPieMenu. (Markus)</li>
<li>implemented GtkFontSelection::set_filter(), GtkFontSelectionDialog::set_filter(), Gtk::button_box_get_child_ipadding_default(), Gtk::button_box_get_child_size_default() and GtkWidget::get_pointer(). (Markus)</li>
<li>implemented gdkpixbuf extension (loading and displaying images). (Andrei)</li>
<li>added GtkCTree methods find_by_row_data, find_all_by_row_data. (Andrei)</li>
<li>added gtkhtml extension which provides support for GtkHTML, an HTML rendering widget. (Alan Knowles)</li>
<li>added GtkClist methods find_row_from_data(), get_pixmap(). (Andrei)</li>
<li>added GtkList::remove_items() method. (Andrei)</li>
<li>added ability to build extensions as shared libraries and load them selectively. (Andrei)</li>
<li>made libglade work on Win32 platforms. (Frank)</li>
<li>added support for GtkSQPane widget. (Markus)</li>
<li>added GtkCList::get_pixtext(). (Andrei, Rich Payne)</li>
</ul>

<?php echo hdelim(); ?>

<a name="0.1.1"></a>
<h3>Version 0.1.1 "no-holds-barred memento"</h3>
<b>24-Sep-2001</b>
<ul>
<li>made type checking of parameters passed to PHP-GTK functions more forgiving. (Andrei)</li>
<li>added GtkNotebook::query_tab_label_packing(), GtkBox::query_child_packing(). (Markus)</li>
<li>added event watcher, dialog, file selection, panes, and notebook examples to gtk.php. (Markus)</li>
<li>added Gtk::signal_(add|remove)_emission_hook(), Gtk::signal_name(), and Gtk::signal_lookup() functions. (Markus)</li>
<li>added GtkCList::get_selection_info(). (Andrei)</li>
<li>added GtkCList methods set_row_data(), get_row_data(). (Markus)</li>
<li>added support for GtkScintilla, a text-editing widget. (Andrei)</li>
<li>implemented GladeXML methods signal_connect_object() and signal_autoconnect_object(). (Andrei)</li>
<li>fixed GDK keysym constants warnings by prefixing some of them with underscores. (Frank)</li>
<li>changed PHP-visible extension name from 'gtk' to 'php-gtk'. (Andrei)</li>
</ul>

<?php echo hdelim(); ?>

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

<a name="0.0.4"></a>
<h3>Version 0.0.4 "indistinguishable from magic"</h3>
<b>5-May-2001</b>
<ul>
<li>improved speed/memory efficiency by having only one wrapper for boxed types, except for GdkEvent, GdkColor and GdkAtom. (Andrei)</li>
<li>implemented object overloading emulation layer to correct for Zend engine's problems, now it's possible to assign and read custom properties on Gtk+ objects. (Andrei)</li>
<li>added GtkAspectFrame class definition. (Andrei)</li>
<li>added GtkCTree traversal functions. (Andrei)</li>
<li>optimized internal resource handling, this should save on memory. (Andrei)</li>
<li>fixed a bug that would corrupt object type when setting cascaded property.  (Andrei)</li>
<li>added a few more properties to GtkCTree and GtkCList. (Andrei)</li>
<li>implemented GtkMenu::popup(). (Andrei)</li>
<li>fixed GtkCTree::insert_row() for good, added GtkCTree methods node_set_row_data() and node_get_row_data(). (Andrei)</li>
<li>added helper GtkCListRow class. (Andrei)</li>
<li>separated GdkWindow, GdkBitmap, GdkPixmap implementations to allow for more flexibility and clarity. (Andrei)</li>
<li>implemented GtkObject methods get_data(), set_data, connect_after(), connect_object_after(). (Andrei)</li>
<li>added several more widget examples to gtk.php. (Andrei)</li>
<li>added ability to get and set color for GtkColorSelection. (Andrei)</li>
</ul>

<?php echo hdelim(); ?>

<a name="0.0.3"></a>
<h3>Version 0.0.3 "slow glass"</h3>
<b>20-Mar-2001</b>
<ul>
<li>added libglade support. (Andrei)</li>
<li>fixed cascading property access in objects. (Andrei)</li>
<li>added GtkRadioMenuItem, GtkRadioButton constructors. (Andrei)</li>
<li>added Gdk::pixmap_create_from_xpm_d(). (Andrei)</li>
<li>added GtkCList::prepend(), GtkClist::insert(). (Andrei)</li>
<li>added GtkCList example to gtk.php. (Andrei)</li>
<li>made Gdk::input_add() work with file resources. (Andrei)</li>
<li>fixed GDK locale support. (Alex Bokovoy)</li>
<li>reworked the generator to make it more generalized. (Andrei)</li>
<li>re-engineered the build system a bit to accomodate the need to build additional modules. (Andrei)</li>
<li>added helper GtkBoxChild, GtkFixedChild classes. (Andrei)</li>
<li>added some properties for GtkWidget, GtkBin, GtkMisc, GtkArrow, GtkBox, GtkCalendar, GtkCTree, GtkList, and GtkCList classes. (Andrei)</li>
</ul>

<?php echo hdelim(); ?>

<a name="0.0.2"></a>
<h3>Version 0.0.2 "primordial nucleosynthesis"</h3>
<b>7-Mar-2001</b>
<ul>
<li>added 'child' property to GtkBin and its descendants. (Andrei)</li>
<li>all callbacks now take user supplied extra arguments and better error messages are shown if the callbacks are not valid. (Andrei)</li>
<li>added GtkCombo::set_popdown_strings(), GdkPixmap::create_from_xpm().  (Andrei)</li>
<li>implemented support for creating menus via GtkItemFactory. (Andrei)</li>
<li>fixed loading of the extension via php.ini. (Andrei)</li>
<li>fixed timeout and idle handler marshaller so that they are called more than once. (Andrei)</li>
<li>added connect_object() method that allows calling an object method as a signal callback. (Andrei)</li>
<li>fixed a silent crash that was happening due to object corruption. (Andrei)</li>
<li>implemented GtkTipsQuery class. (Andrei)</li>
</ul>

<?php echo hdelim(); ?>

<a name="0.0.1"></a>
<h3>Version 0.0.1 "Genesis"</h3>
<b>1-Mar-2001</b>
<ul>
<li>first release. (Andrei)</li>
</ul>

<?php

commonFooter();

/* s/^\s*-\s*\(.\+\)$/<li>\1<\/li>/g */

?>
