<?php
session_start(); 
error_reporting(E_ALL);
ini_set("display_errors", 1);
require_once("includes/setdefaultpage.php");
userlanguage();
require("language/".$_SESSION['language']."/index.php");
$header=explode(":",DEFAULTHEADER);
defaultheader($header[0],$header[1],$header[2],$header[3]);
?>
<body>
<?php defaulttop(); ?>
<header class="w3-container w3-teal w3-animate-opacity"\>
  <h1><?php echo WELCOME;?></h1>
</header>
<div class="w3-center w3-animate-opacity">    
  <div class="w3-row"></br>
    <article class="w3-col m10 w3-container">
    <h1><?php echo TITLE1;?></h1>
<p class="w3-justify"><?php echo TEXT1;?></p>

       <div class="w3-center">
       <img src="images/gtkaboutdialog.png" height="260" width="350" alt="php-gtk example" />
       <img src="images/helloadvanced.png" height="331" width="325" alt="php-gtk example" />
       </div>
       
       


	 <h1><?php echo TITLE2;?></h1>
	 <p class="w3-justify"><?php echo TEXT2;?></p>
	    
<p class="w3-justify"><?php echo TEXT3;?>


<p class="w3-justify"><?php echo TEXT4;?></p>
</article>
    <aside>
    <nav class="w3-col m2 w3-light-grey w3-animate-opacity">
<?php defaultmenuright();?>
    </aside>
    </nav>
  </div>
</div>
<footer class="w3-container w3-small w3-teal w3-animate-opacity"\>
  <p><?php echo FOOTER;?></p>
</footer>

</body>
<?php
defaultfooter();
?>