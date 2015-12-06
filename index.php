<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require_once("includes/setdefaultpage.php");
defaultheader("en","PHP-GTK","PHP-GTK is an extension for the PHP programming language that implements language bindings for GTK+.","PHP-GTK,PHP,GTK");
?>
<body>
<?php defaulttop(); ?>
<header class="w3-container w3-teal w3-animate-opacity"\>
  <h1>Welcome, learn about the php-gtk.</h1>
</header>
<div class="w3-center w3-animate-opacity">    
  <div class="w3-row"></br>
      <section class="w3-col m3 w3-container"> 
      <div class="w3-card-24" style="width:95%">
       <img src="images/gtkaboutdialog.png" height="260" width="350" alt="php-gtk example" /></br>
       
       </div></br>
       <div class="w3-card-24" style="width:95%">
       <img src="images/helloadvanced.png" height="331" width="325" alt="php-gtk example" />
       </div></br>
    </section>
    <article class="w3-col m7 w3-container">
    <h1>What is PHP-GTK?</h1>
<p class="w3-justify">PHP-GTK is an extension for the PHP programming language that implements language bindings for GTK+. It provides 
an object-oriented interface to GTK+ classes and functions and greatly simplifies writing client-side cross-platform GUI applications.</p>
	 <h1>History</h1>
	 <p class="w3-justify">The PHP-GTK was established in March 2001 by Andrei Zmievski a usbequistanês who lives and works in the United States.
	  As well as many projects in free software, it also started with an initial motivation a little peculiar, "I did because I wanted to see if it was possible"
	   in the words of the author who inspired so much in another existing project, the PyGTK (link between languages ​​between Python and GTK).
	    Andrei Zmievski visited Brazil in 2002, during the III International Free Software Forum, which made some presentations.</p>

<p class="w3-justify">The PHP-GTK is a "language binding", ie it is a link between two existing languages, PHP language and GTK library.
 So PHP-GTK is the PHP itself, with more features. The PHP-GTK is the first extension of the PHP language that lets you write client-side applications
  with GUI (Graphical User Interface). It was written in part to prove that PHP is a language and full of great purposes. 
  The PHP marriage to the GTK tool creates an independent platform that runs on both Linux and Windows environments.</p>

<p class="w3-justify">Using PHP-GTK, you create an application that has connectivity to the server (database, access to files, etc.), like all other
 programs written in PHP, but that because of running on the client machine, also has full access to resources of this (run applications, write local 
 files and access devices). For this purpose, PHP-GTK needs to be installed on each client machine that will run a PHP-GTK application.
 <b> source: http://www.php-gtk.com.br/home</b> </p>
</article>
    <aside class="w3-col m2 w3-light-grey w3-animate-opacity">
      <p><a href="#">Link</a></p>
      <p><a href="#">Link</a></p>
      <p><a href="#">Link</a></p>
    </aside>
  </div>
</div>
<footer class="w3-container w3-small w3-teal w3-animate-opacity"\>
  <p>If you have problems or questions, your first point of contact should be the <a href="http://gtk.php.net/docs.php">manual</a> and the
   <a href="http://gtk.php.net/resources.php">php-gtk-general mailing list.</a></p>
</footer>

</body>
<?php
defaultfooter();
?>