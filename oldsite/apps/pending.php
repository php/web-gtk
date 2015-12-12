<?php

// 
// this page gets used by administrators to see what apps are pending approval.
// 

require_once("apps.inc");

$res = mysql_query("SELECT * FROM app WHERE status = 'P' ORDER BY date_added");

print("<h1>Pending Applications</h1>");


$num_rows = mysql_num_rows($res);
if( $res && $num_rows > 0 ) {
	print("<table border=0 cellpadding=2 cellspacing=0 width=100%>");
	while( $row = mysql_fetch_object($res) )  {
		displayApp($row, 0, 0, 0);
	}
	print("</table>");

}else {
	print("There are no pending applications at this time.");
}

?>
