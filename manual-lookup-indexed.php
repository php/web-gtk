<?php
/*
*   Indexed manual search
*   @author Christian Weiske <cweiske@php.net>
*
*   This search will list a flat file list, only ordered a bit
*   try the "manual-lookup-indexed2.php" for a much better search
*/

require_once 'prepend.php';
require_once 'manual-lookup-indexed.inc';

$pattern  = isset( $_POST['pattern']) ? $_POST['pattern'] : null;
$function = isset( $_GET['function']) ? $_GET['function'] : null;

if( !$function && $pattern) {
    $function = $pattern;
}
$function = strtolower( $function);

/* it gets messy trying to pass $lang around - so get it from the referral dir */
if( isset( $_SERVER['HTTP_REFERER']) && strstr( dirname( $_SERVER['HTTP_REFERER']), 'manual/')) {
    $strLang = substr( dirname( $_SERVER['HTTP_REFERER']), -2);
} else {
    $strLang = 'en';
}
/* there's always one, eh? */
if( $strLang == 'BR') {
    $strLang = 'pt_BR';
}

if( $function == '') {
    commonHeader( 'no search string');
    echo '<br/>&nbsp;<h1>No search string given</h1><br/>';

    commonFooter();
    die();
}

//now do the search
$arFiles    = search( $function, $strLang);


if( count( $arFiles) == 0)
{
    //nothing found
    commonHeader( '404 Not Found');
    echo '<br/>&nbsp;<h1>Not Found</h1><br/>';
    echo '&nbsp;No class/signal/method containing <strong>"' . $function . '"</strong> could be found.';
    
    if( isset( $_SERVER['HTTP_REFERER'])) {
        echo '<br/><a href="' . $_SERVER['HTTP_REFERER'] . '">Try again</a><br/><br/><br/><br/><br/><br/><br/>';
    }
    
    commonFooter();    
}
else if( count( $arFiles) == 1) 
{
    //found only one - go directly to this file
    header( 'Location: ' . getManualLocation( $strLang, $arFiles[0]));
}
else
{
    //found multiple matches - display list
    commonHeader( 'multiple choice');
    
    echo '<br/><br/>&nbsp;<h1>Search results</h1><br/>';
    echo count( $arFiles) . ' files matched "' . htmlspecialchars( $function) . '". Pick the one you like best.<br/>';
    echo '<hr/>';
    
    //now show them
    foreach( $arFiles as $nId => $strFile)
    {
        echo '<p>';
        //@fixme: display page titles, probably from html pages. Where are they?
        echo '<a href="' . getManualLocation( $strLang, $strFile) . '">' . $strFile . '</a>';
        echo '</p>';
    }
    
    commonFooter();
}


?>