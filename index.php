<?php

$SIDEBAR_DATA = <<< EOF
<h3>Warning!</h3>
<P>
This code is a highly experimental adaptation 
of the instructions beamed to us by the friendly aliens of Tau 
Ceti. The API can and will be changing, evolving, and unpredictably 
morphing into little furry Ewoks, fluorescent killer bunny rabbits, 
and the knights who say 'Nee'. Use the code at your own risk, 
as it may cause flooding, polydactism, frogs falling from the 
sky, and the return of the Inca empire. And it will definitely 
warp space-time continuum in your local area.
<P>
EOF;

commonHeader();

?>

<h1>PHP-GTK</h1>

<P>
Too often PHP is thought of as only an HTML-embedded 
Web scripting language. But it is also a very full-featured general 
purpose language that can be used for much more. One of the goals 
behind this project was to prove that PHP can be used to write client-side 
GUI applications.
</P>

<P>
There is a mailing list for PHP-GTK. To subsribe, 
send blank email to <?php print_email('php-gtk-subscribe@lists.php.net'); ?>.
The address of the list itself is <?php print_email('php-gtk@lists.php.net'); ?>. 
The list is archived at <?php print_link('http://marc.theaimsgroup.com/?l=php-gtk&r=1&w=2', 'MARC'); ?>. 
</P>

<P>
This extension is still in early beta phase to not 
expect everything to work right now. If you have problems then your 
first port of call should be the manual and the mailing list. Any
serious php-gtk related questions should be sent to 
<?php print_email('andrei@php.net'); ?> ... unless
they are related to the manual where they should be sent 
to <?php print_email('jmoore@php.net'); ?>. If you have 
a question or suggestion for the website you should contact 
<?php print_email('jmoore@php.net'); ?>.
</P>


<?php

commonFooter();

?>
