<?php
session_start(); 
error_reporting(E_ALL);
ini_set("display_errors", 1);
require_once("includes/setdefaultpage.php");
userlanguage();
require("language/".$_SESSION['language']."/documentation.php");
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
<table class="w3-table w3-bordered w3-striped w3-border w3-hoverable w3-striped w3-center">
<thead class="w3-light-blue w3-center">
  <tr >
  <th class="w3-center"><?php echo TH1;?></th>
  <th class="w3-center"><?php echo TH2;?></th>
</tr>
</thead>   
<tr>
  <td class="w3-center"><?php echo TD1;?></td>
  <td class="w3-center"><a href="manual/en/bigmanualhtml.zip" download><i class="material-icons">&#xE884;</i> English</a></td>
</tr>
<tr>
  <td class="w3-center"><?php echo TD2;?></td>
  <td class="w3-center"><a href="manual/en/manualhtml.zip" download><i class="material-icons">&#xE884;</i> English</a></td>
</tr>
<tr>
  <td class="w3-center"><?php echo TD3;?></td>
  <td class="w3-center"><a href="manual/en/manual.txt" download><i class="material-icons">&#xE884;</i> English</a></td>
</tr>
<tr>
  <td class="w3-center"><?php echo TD4;?></td>
  <td class="w3-center"><a href="manual/en/manual.pdf" download><i class="material-icons">&#xE884;</i> English</a></td>
</tr>
</table>
<br/>
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