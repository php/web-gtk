<?php
/*
*   Indexed manual search, second version
*   @author Christian Weiske <cweiske@php.net>
*
*   Lists the search results prioritized,
*       split by classes/signals/enums/methods...
*       and ordered alphabetically
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
    echo '<h1>No search string given</h1><br/>';

    commonFooter();
    die();
}

//now do the search
$arFiles    = search2( $function, $strLang);


$nCount     = 0;
foreach( $arFiles as $arSections) {
    foreach( $arSections as $arSectionFiles) {
        $nCount += count( $arSectionFiles);
        $strThisOneFile = reset( $arSectionFiles);
    }
}


if( $nCount == 0)
{
    //nothing found
    commonHeader( '404 Not Found');
    echo '<h1>Not Found</h1><br/>';
    echo 'No class/signal/method containing <strong>"' . $function . '"</strong> could be found.';
    
    if( isset( $_SERVER['HTTP_REFERER'])) {
        echo '<br/><a href="' . $_SERVER['HTTP_REFERER'] . '">Try again</a><br/><br/><br/><br/><br/><br/><br/>';
    }
    
    commonFooter();    
}
else if( $nCount == 1) 
{
    //found only one - go directly to this file
    header( 'Location: ' . getManualLocation( $strLang, $strThisOneFile));
}
else
{
    //found multiple matches - display list
    commonHeader( 'Search results');
        
    echo '<h1>Search results</h1>';
    echo $nCount . ' files matched "' . htmlspecialchars( $function) . '". Pick the one you like best.<br/>';
    
    //reorder the array to change the display order
    $arSectionNames = array(
        'class'         => 'Classes', 
        'constructor'   => 'Constructors', 
        'method'        => 'Methods', 
        'property'      => 'Properties', 
        'signal'        => 'Signals', 
        'enum'          => 'Enumerators',
        'unknown'       => 'Other files'
    );
    $arIdNames      = array( 1 => 'classes', 2 => 'direct functions', 3 => 'in the class name');
    
    foreach( $arFiles as $nId => $arSections)
    {
        if( count( $arSections) == 0) { continue; }
        
        echo '<hr/>';
        echo '<h2>' . $arIdNames[$nId] . '</h2>';
        foreach( $arSectionNames as $strSection => $strSectionName) 
        {
            if( isset( $arSections[$strSection]) && count( $arSections[$strSection]) > 0)
            {
                echo '<h3>' . $strSectionName . ' ' . count( $arSections[$strSection]) . 'x</h3>';
                echo '<ul>';
                foreach( $arSections[$strSection] as $strFile) {
                    echo '<li><a href="' . getManualLocation( $strLang, $strFile) . '">' . getFileTitle( $strFile, $strSection) . '</a></li>';
                }
                echo '</ul>';
            }
        }//foreach subsection
    }//foreach id 
    
    
    commonFooter();
}


?>