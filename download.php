<?php
require_once("includes/shared.inc");

common_header();

?>
<table width="80%" border="0" cellpadding="5" cellspacing="0" height="100%">
        <tr> 
          <td> 
            <div class="title">Download</div>
            <p class="mtext"> <b>Note:</b> PHP-GTK currently requires the latest 
              PHP version from CVS and will work with 4.0.5 when it comes out</p>
            <p class="mtext">PHP-GTK currently supports GTK+ v1.2.6 or greater, 
              but not GTK+ v2.0 (which is still under development and won't be 
              widely used for a while). You can obtain the latest stable release 
              of GTK+ v1.2.x from <a href="ftp://ftp.gtk.org/pub/gtk/v1.2/">ftp://ftp.gtk.org/pub/gtk/v1.2/</a>. 
            </p>
            <p class="mtext"><b>Latest stable release: </b></p>
            <p class="mtext"><a href="http://gtk.php.net/do_download.php?download_file=php-gtk-0.0.3.tar.gz">php-gtk-0.0.3 
              (Source)</a> (20-Mar-2001) <br>
              <a href="http://gtk.php.net/do_download.php?download_file=php-gtk-0.0.3-win32.zip">php-gtk-0.0.3 
              (Windows and php binary)</a> (20-Mar-2001) </p>
            <p class="mtext">Alternatively, you can get the latest and greatest 
              version of PHP-GTK directly from the PHP CVS server. </p>
<blockquote>
              <p class="mtext"><b>cvs -d :pserver:cvsread@cvs.php.net:/repository 
                login <br>
                (Logging in to cvsread@cvs.php.net) <br>
                CVS password: phpfi</b></p>
            </blockquote>
            <blockquote> 
              <p class="mtext"><br>
                <b>cvs -d :pserver:cvsread@cvs.php.net:/repository co php-gtk 
                <br>
                cd php-gtk <br>
                phpize <br>
                ./configure <br>
                make <br>
                make install</b></p>
              </blockquote>
          </td>
        </tr>
      </table>
      
<?php

common_footer();

?>