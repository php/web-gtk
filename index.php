<?php

$SIDEBAR_DATA = <<< EOF
<h3>Warning!</h3>
<P>
This code is a highly experimental adaptation 
of the instructions beamed to us by the friendly aliens of Tau 
Ceti.  The API can -- and will -- be changing, evolving, and unpredictably 
morphing into little furry Ewoks, fluorescent killer bunny rabbits, 
and the knights who say 'Ni'.  Use the code at your own risk, 
as it may cause flooding, polydactism, frogs falling from the 
sky, and the return of the Inca empire.
</P>
<P>
It will definitely warp space-time continuum in your local area.
<P>
EOF;

commonHeader();

?>

<h1>PHP-GTK</h1>

<P>
Too often PHP is thought of as only an HTML-embedded 
web scripting language.  However, it is also a very full-featured general 
purpose language that can be used for much more.  One of the goals 
behind this project was to prove that PHP can be used to write client-side 
GUI applications.
</P>


<h1>Resources</h1>

<P>
Check out our <? print_link('/resources.php', 'Resources page'); ?> for 
links to PHP-GTK related sites, instructions on the PHP-GTK mailing lists,
and other PHP-GTK resources.
</P>



<h1>Caveat</h1>

<P>
This extension is still in early beta phase, so not all the features may work
right now.  If you have problems then your 
first port of call should be the manual and the mailing list.
</P>
<P>
Any serious php-gtk related questions should be sent to 
<?php print_email('andrei@php.net'); ?> ... unless
they are related to the manual, in which case they should be sent 
to <?php print_email('jmoore@php.net'); ?>.  If you have 
a question or suggestion for the website, you should contact 
<?php print_email('webmaster@php.net'); ?>.
</P>


<?php

commonFooter();

?>
