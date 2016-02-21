<?php
session_start(); 
error_reporting(E_ALL);
ini_set("display_errors", 1);
require_once("includes/setdefaultpage.php");
userlanguage();
require("language/".$_SESSION['language']."/download.php");
$header=explode(":",DEFAULTHEADER);
defaultheader($header[0],$header[1],$header[2],$header[3]);
?>
<body>
<?php defaulttop(); ?>
<header class="w3-container w3-teal w3-animate-opacity">
  <h1><?php echo WELCOME;?></h1>
</header>
<div class="w3-center w3-animate-opacity">    
  <div class="w3-row"><br/>
    <article class="w3-col m10 w3-container">
    <h1><?php echo TITLE1;?></h1>

<p class="w3-justify"><?php echo TEXT1;?></p>
<table class="w3-table w3-bordered w3-striped w3-border w3-hoverable w3-striped w3-center">
<thead class="w3-light-blue w3-center">
  <tr >
  <th class="w3-center"><?php echo TH1;?></th>
  <th class="w3-center"><?php echo TH2;?></th>
  <th class="w3-center"><?php echo TH3;?></th>
  <th class="w3-center"><?php echo TH4;?></th>
  <th class="w3-center"><?php echo TH5;?></th>
  <th class="w3-center"><?php echo TH6;?></th>
  <th class="w3-center"><?php echo TH7;?></th>
 
</tr>
</thead>
<tr class="w3-center">
  <td class="w3-center">PHP-GTK-2.0.1</td>
  <td class="w3-center">PHP 5.5</td>
  <td class="w3-center">GTK+ 2.24.10</td>
  <td class="w3-center"><a href="distributions/PHP55-GTK2.zip" download><i class="material-icons">&#xE884;</i></a></td>
  <td class="w3-center">-</td>
  <td class="w3-center"><?php echo BETA;?></td>
  <td class="w3-center">2015-01-15</td>
  
</tr>
<tr>
  <td class="w3-center">PHP-GTK-2.0.1</td>
  <td class="w3-center">PHP 5.4</td>
  <td class="w3-center">GTK+ 2.24.10</td>
  <td class="w3-center"><a href="distributions/PHP54-GTK2.zip" download><i class="material-icons">&#xE884;</i></a></td>
  <td class="w3-center">-</td>
  <td class="w3-center"><?php echo BETA;?></td>
  <td class="w3-center">2015-01-15</td>
  
</tr>
<tr>
  <td class="w3-center">PHP-GTK-2.0.1</td>
  <td class="w3-center">PHP 5.1.x - 5.5</td>
  <td class="w3-center">GTK+ 2.x</td>
  <td class="w3-center">-</td>
  <td class="w3-center"><a href="https://github.com/php/php-gtk-src/archive/master.zip" download><i class="material-icons">&#xE884;</i></a></td>
  <td class="w3-center"><?php echo STABLE;?></td>
  <td class="w3-center">2015-01-15</td>
  
</tr>
<tr>
  <td class="w3-center">PHP-GTK-2.0.1 binary pack</td>
  <td class="w3-center">PHP 5.2.6</td>
  <td class="w3-center">GTK+ 2.12.9</td>
  <td class="w3-center"><a href="distributions/php-gtk-2.0.1-win32-nts.zip" download><i class="material-icons">&#xE884;</i></a></td>
  <td class="w3-center">-</td>
  <td class="w3-center"><?php echo STABLE;?></td>
  <td class="w3-center">2008-05-16</td>
  
</tr>
<tr>
<td class="w3-center">PHP-GTK-2.0.1 binary extensions pack</td>
  <td class="w3-center">PHP 5.2.6</td>
  <td class="w3-center">GTK+ 2.12.9</td>
  <td class="w3-center"><a href="distributions/php-gtk-2.0.1-win32-extensions.zip" download><i class="material-icons">&#xE884;</i></a></td>
  <td class="w3-center">-</td>
  <td class="w3-center"><?php echo STABLE;?></td>
  <td class="w3-center">2008-05-16</td>
  
</tr>
<tr>
  <td class="w3-center">PHP-GTK-2.0.1</td>
  <td class="w3-center">PHP 5.2.6</td>
  <td class="w3-center">GTK+ 2.12.9</td>
  <td class="w3-center">-</td>
  <td class="w3-center"><a href="distributions/php-gtk-2.0.1.tar.gz" download><i class="material-icons">&#xE884;</i></a></td>
  <td class="w3-center"><?php echo STABLE;?></td>
  <td class="w3-center">2008-05-16</td>
  
</tr>
<tr>
<td class="w3-center">PHP-GTK-2.0.0 binary pack</td>
  <td class="w3-center">PHP 5.2.5</td>
  <td class="w3-center">GTK+ 2.12.8</td>
  <td class="w3-center"><a href="distributions/php-gtk-2.0.0-win32-nts.zip" download><i class="material-icons">&#xE884;</i></a></td>
  <td class="w3-center">-</td>
  <td class="w3-center"><?php echo STABLE;?></td>
  <td class="w3-center">2008-02-29</td>
  
</tr>
<tr>
  <td class="w3-center">PHP-GTK-2.0.0</td>
  <td class="w3-center">PHP 5.2.5</td>
  <td class="w3-center">GTK+ 2.12.8</td>
  <td class="w3-center">-</td>
  <td class="w3-center"><a href="distributions/php-gtk-2.0.0.tar.gz" download><i class="material-icons">&#xE884;</i></a></td>
  <td class="w3-center"><?php echo STABLE;?></td>
  <td class="w3-center">2008-02-29</td>
  
</tr>
</table>
<br/>    
<h1><?php echo TITLE2;?></h1>    
<p class="w3-justify"><?php echo TEXT2;?></p>
<table class="w3-table w3-bordered w3-striped w3-border w3-hoverable w3-striped w3-center">
<thead class="w3-light-blue w3-center">
  <tr >
  <th class="w3-center"><?php echo TH1;?></th>
  <th class="w3-center"><?php echo TH2;?></th>
  <th class="w3-center"><?php echo TH3;?></th>
  <th class="w3-center"><?php echo TH4;?></th>
  <th class="w3-center"><?php echo TH5;?></th>
  <th class="w3-center"><?php echo TH6;?></th>
  <th class="w3-center"><?php echo TH7;?></th>
  
</tr>
</thead>
<tr>
  <td class="w3-center">php-gtk-1.0.2</td>
  <td class="w3-center">4.4.1-dev</td>
  <td class="w3-center">GTK+ 1.2.x</td>
  <td class="w3-center"><a href="distributions/php-gtk-1.0.2-win32.zip" download><i class="material-icons">&#xE884;</i></a></td>
  <td class="w3-center">-</td>
  <td class="w3-center"><?php echo STABLE;?></td>
  <td class="w3-center">2005-07-15</td>
  
</tr>
<tr>
<td class="w3-center">php-gtk-1.0.2</td>
  <td class="w3-center">4.4.1-dev</td>
  <td class="w3-center">GTK+ 1.2.x</td>
  <td class="w3-center">-</td>
  <td class="w3-center"><a href="distributions/php-gtk-1.0.2.tar.gz" download><i class="material-icons">&#xE884;</i></a></td>
  <td class="w3-center"><?php echo STABLE;?></td>
  <td class="w3-center">2005-07-15</td>
  
</tr>
<tr>
  <td class="w3-center">php-gtk-1.0.1a</td>
  <td class="w3-center">4.3.9-dev</td>
  <td class="w3-center">GTK+ 1.2.x</td>
  <td class="w3-center"><a href="distributions/php-gtk-1.0.1a-win32.zip" download><i class="material-icons">&#xE884;</i></a></td>
  <td class="w3-center">-</td>
  <td class="w3-center"><?php echo STABLE;?></td>
  <td class="w3-center">2004-08-25</td>
  
</tr>
<tr>
<td class="w3-center">php-gtk-1.0.1</td>
  <td class="w3-center">4.3.9-dev</td>
  <td class="w3-center">GTK+ 1.2.x</td>
  <td class="w3-center">-</td>
  <td class="w3-center"><a href="distributions/php-gtk-1.0.1.tar.gz" download><i class="material-icons">&#xE884;</i></a></td>
  <td class="w3-center"><?php echo STABLE;?></td>
  <td class="w3-center">2004-08-25</td>
  
</tr>
<tr>
<td class="w3-center">php-gtk-1.0.0</td>
  <td class="w3-center">4.3.4RC3-dev</td>
  <td class="w3-center">GTK+ 1.2.x</td>
  <td class="w3-center"><a href="distributions/php-gtk-1.0.0-win32.zip" download><i class="material-icons">&#xE884;</i></a></td>
  <td class="w3-center">-</td>
  <td class="w3-center"><?php echo STABLE;?></td>
  <td class="w3-center">2003-10-23</td>
  
</tr>
</table>

<h1><?php echo TITLE3;?></h1>        
<p class="w3-justify"><?php echo TEXT3;?>


<p class="w3-justify"><?php echo TEXT4;?></p>
</article>
    <aside>
    <nav class="w3-col m2 w3-light-grey w3-animate-opacity">
<?php defaultmenuright();?>
    </nav>
    </aside>
    
  </div>
</div>
<footer class="w3-container w3-small w3-teal w3-animate-opacity">
  <p><?php echo FOOTER;?></p>
</footer>
<?php
defaultfooter();
?>