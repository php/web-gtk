<?php
/**
*   PHP-Gtk manual search function
*   @author Christian Weiske <cweiske@php.net>
*
*   start this script with "-h" to get the help screen
*   you have to give a parameter from the commandline to ensure 
*       it can be included without problems
*
*   How the index works:
*   - Only full words are found. If you search by "wind", "window" will *not* be found.
*   - up to 2 with "_" connected full words are found, e.g. when searching for "this_is", 
*       the file "this_is_a_long_name" will be found, but searching for "this_is_a" will not
*       bring the former result, as only 2 directly connected words are indexed.
*       Note that full method names are indexed, too: "this_is_a_long_name" will be found
*       by searching for "this_is_a_long_name"
*   - The index is prioritized. This means that results are sorted by priority:
*       (Example search: "window")
*       - class names will be first
*           found: gtk.gtkwindow.php, gdk.gdkwindow.php
*       - methods which contain the search word in method name are second
*           found: gdk.gdkdragcontext.property.dest_window.php
*       - methods with the search word not in the direct method name are third
*           found: gdk.gdkwindow.method.lower.php
*
*   @todo:
*   - replace search terms: "tutorial" by "tutorials" as the term "tutorial" is not indexed
*/

/**
*   Manual file conventions
*
*   - sections have own names, subsections are divided with dots -> gtk.gtkselectiondata.method.set.php
*   - method names can have underscores which should be exploded to have own words
*   - class files have 2 words: section and classname (gtk.gtkwindow.php)
*   - method/signal files have more than 2 words (gtk.gtkwindow.constructor.php, gtk.gtkwindow.method.set:default.php)
*
*/

//these two are overridden later when using the -a parameter
$GLOBALS['php-gtk-doc.phpweb.dir']  = '/data/cvs/php-gtk/php-gtk-doc/build/en/php/';
$GLOBALS['index.file']              = '/data/cvs/php-gtk/scripts/searchindex.dat';

//the base directory where the manuals are. Below "/manual/" the language directories are situated
//we can't use DOCUMENT_ROOT as it does not work with apache2 virtual mass hosting
$GLOBALS['base.dir']                = dirname( __FILE__) . '/../manual/';


$GLOBALS['sections']                = array( 'gtk', 'gdk', 'extra', 'scn');
//the following 2 arrays are currently not used, but keep them here
$GLOBALS['reserved']                = array( 'gtk', 'gdk', 'scn', 'method', 'property', 'prop', 'enum', 'signal', 'constructor');
$GLOBALS['reserved_method']         = array( 'get', 'set');


/**
*   creates a search index for each language
*   this function should be called once after the manuals have been built
*/
function buildLanguageIndices()
{
    //loop through the manual dir to get all language names and directories
    $hdlDir     = dir( $GLOBALS['base.dir']);
    while( false !== ( $strFile = $hdlDir->read())) 
    {
        $strFullPath    = $GLOBALS['base.dir'] . $strFile;
        if( $strFile[0] == '.' || !is_dir( $strFullPath) || $strFile == 'CVS') {
            continue;
        }
        
        $strFullPath    .= '/';//append the trailing slash as we know it's a directory
        
        $strLang        = $strFile;
        
        //create the index
        echo $strLang . '.. ';
        buildLanguageIndex( $strLang);
        
    }//while all files in the manual dir

}//function buildLanguageIndices()



/**
*   sets all the necessary things for the specific language
*   creates the language index then
*/
function buildLanguageIndex( $strLang)
{
    //change the global manual directory and search index file locations
    $GLOBALS['php-gtk-doc.phpweb.dir']  = $GLOBALS['base.dir'] . $strLang . '/';
    $GLOBALS['index.file']              = getIndexFile( $strLang);
    
    buildIndex();
}//function buildLanguageIndex( $strLang)


/**
*   returns the location for the search index file
*
*   @param  String  The language, e.g. en, cs, pt_BR
*/
function getIndexFile( $strLang)
{
    return $GLOBALS['base.dir'] . 'searchindex.' . $strLang . '.dat';
}//function getIndexFile( $strLang)



/**
*   returns the direct position of the file for the browser
*/
function getManualLocation( $strLang, $strFile)
{
    return 'http://' . $_SERVER['HTTP_HOST'] . '/manual/' . $strLang . '/' . $strFile;
}//function getManualLocation( $strLang, $strFile)



/**
*   builds the search index
*
*   this function is called from buildLanguageIndex
*
*   the index is a serialized array with the search data
*   array
*   [keyword]
*       - [1] priority level 
*           - [file 1]
*           - [file 2]
*       - [2] priority level
*           - [file 1]
*           - [file 2]
*       - [3] priority level
*           - [file 1]
*           - [file 2]
*
*   Priorities:
*   1   class names, tutorial names, ...
*   2   methods, signals, enums
*   3   methods which have the keyword in the class name
*/
function buildIndex()
{
    $hdlDir         = dir( $GLOBALS['php-gtk-doc.phpweb.dir']);
    
    $strClassRegex  = '/^(' . implode( '|', $GLOBALS['sections'] ) . ')\\.[a-z]+$/';
    
    $arIndex        = array();
    
    while( false !== ( $strFile = $hdlDir->read()))
    {
        $strName    = substr( $strFile, 0, -4);
        if( $strName == '') { continue; }// . and ..
        
        if( preg_match( $strClassRegex, $strName)) {
            $nClassPriority = 1;
        } else {
            $nClassPriority = 3;
        }
        
        $arPieces   = explode( '.', $strName);
        //remove reserved words so that they are not indexed
        //$arPieces   = array_diff( $arPieces, $GLOBALS['reserved']);
        //when uncommenting the last line, change all "$nCountWords > 2" to "$nCountWords > 1"
        
        $arNewPieces    = array();
        $nCountWords    = count( $arPieces);
        $nWordPos       = -1;
        foreach( $arPieces as $strWord) 
        {
            $nWordPos++;//the indices do not have constant values (array_diff)
            if( $nWordPos == $nCountWords - 1 && $nCountWords > 2) {
                //last word in the filename
                $arNewPieces[2][]               = $strWord;//the word itself
            } else {
                //not the last word in the filename
                $arNewPieces[$nClassPriority][] = $strWord;//the word itself
            }
            
            $strPrefix      = substr( $strWord, 0, 3);
            if( $strPrefix == 'gtk' || $strPrefix == 'gdk') {
                //classes have gtk or gdk at the beginning, e.g. gtkfixed or gtkoptionmenu
                if( $nWordPos == $nCountWords - 1 && $nCountWords > 2) {
                    $arNewPieces[2][]   = substr( $strWord, 3);
                } else {
                    $arNewPieces[$nClassPriority][] = substr( $strWord, 3);
                }
            }
            
            $arMethodPieces = explode( '_', $strWord);
            if( count( $arMethodPieces) > 1) 
            {
                //if you want to remove "get" and "set" from the index, uncomment the following line
                //$arMethodPieces = array_diff( $arMethodPieces, $GLOBALS['reserved_method']);
                $arNewPieces[2] = array_merge( $arNewPieces[2], $arMethodPieces);
                if( count( $arMethodPieces) > 2) 
                {
                    //that we have some partly connections like do_this from do_this_thing
                    foreach( $arMethodPieces as $nId => $strPiece) {
                        if( $nId < count( $arMethodPieces) - 1) {
                            $arNewPieces[2][]   = $strPiece . '_' . $arMethodPieces[$nId + 1];
                        }
                    }
                }
            }
            
        }
        
        //append the search words to the index array
        foreach( $arNewPieces as $nPriority => $arPriorityPieces) {
            foreach( $arPriorityPieces as $strPiece) {
                $arIndex[$strPiece][$nPriority][]   = $strFile;
            }
        }
        
        //development
        //if( $nCounter++ >= 10) break;
    }
    
    //sort the index | should speed up searching and is nice for debugging
    ksort( $arIndex);
    
    
    //save the serialized array
    $hdlFile    = fopen( $GLOBALS['index.file'], 'w');
    fwrite( $hdlFile, serialize( $arIndex));
    fclose( $hdlFile);

    echo 'Search array contains ' . count( $arIndex) . ' keywords' . "\r\n";
}//function buildIndex()



/**
*   Searches for the given string
*   The string is automatically split into substrings by the space char
*
*   @param  string  The string to search. It is automatically split into substrings by the space char
*   @param  string  The language index to be searched trough
*
*   @return array   Flat array with all the files in a somehow ordered position
*/
function search( $strSearch, $strLang) 
{
    $GLOBALS['index.file']              = getIndexFile( $strLang);
    
    $arSearchWords  = explode( ' ', $strSearch);
    $arIndex        = unserialize( file_get_contents( $GLOBALS['index.file']));
    
    $arResults      = array();//all the found files for the indizes
    $arWordsResults = array();//the found files which were found for each word
    foreach( $arSearchWords as $strWord) 
    {
        $arWordsResults[$strWord]   = array();//needs to be done
        if( isset( $arIndex[ $strWord])) 
        {
            $arFound    = $arIndex[ $strWord];
            foreach( $arFound as $nIndex => $arFiles) 
            {
                foreach( $arFiles as $strFile) 
                {
                    $arWordsResults[$strWord][]  = $strFile;
                    if( isset( $arResults[$nIndex][$strFile])) {
                        $arResults[$nIndex][$strFile]++;
                    } else {
                        $arResults[$nIndex][$strFile] = 1;
                    }
                }
            }
        }
    }
    
    //now finish the results into one array
    ksort( $arResults);//that key 1 is first
    //@fixme: search files by countfound, but only in the priority class

    $arResultFiles      = array();
    foreach( $arResults as $arWords) {
        foreach( $arWords as $strFile => $nCountFound) {
            $arResultFiles[]    = $strFile;
        }
    }
    
    //remove all the files which were not found for all the words
    //firstly, intersect all the single arrays of the words
    $arAllWords = array();
    $bFirst     = true;
    foreach( $arWordsResults as $strWord => $arWordResults) {
        if( $bFirst) {
            $arAllWords = $arWordResults;
            $bFirst     = false;
        } else {
            $arAllWords = array_intersect( $arAllWords, $arWordResults);
        }
    }
    //now, remove all the files from the $arResultFiles array which are not in the $arAllWords
    //this has to be done to preserve the sorting by classes/methods/...
    $arResultFiles  = array_unique( array_intersect( $arResultFiles, $arAllWords));
    
    $arResultFiles = array_values( $arResultFiles);//that the index begins with 0
    
    return $arResultFiles;
}//function search( $strSearch, $strLanguage) 



/**
*   Searches for the given string
*   This function returns a nested array which allows the search results
*       being displayed by sections like enums/methods/classes/...
*
*   @param  string  The string to search. It is automatically split into substrings by the space char
*   @param  string  The language index to be searched trough
*
*   @return array   Nested array with results. Format:
*                       array( 1 => subarray(), 2 => subarray(), 3 => subarray())
*                       subarray( 'class' => array_of_files(), 'method' => array_of_files(), ...)
*/
function search2( $strSearch, $strLang) 
{
    $GLOBALS['index.file']              = getIndexFile( $strLang);
    
    $arSearchWords  = explode( ' ', $strSearch);
    $arIndex        = unserialize( file_get_contents( $GLOBALS['index.file']));
    
    $arResults      = array();//all the found files for the indizes
    $arWordsResults = array();//the found files which were found for each word
    foreach( $arSearchWords as $strWord) 
    {
        $arWordsResults[$strWord]   = array();//needs to be done
        if( isset( $arIndex[ $strWord])) 
        {
            $arFound    = $arIndex[ $strWord];
            foreach( $arFound as $nIndex => $arFiles) 
            {
                foreach( $arFiles as $strFile) 
                {
                    $arWordsResults[$strWord][]  = $strFile;
                    $arResults[$nIndex][$strFile] = 1;
                }
            }
        }
    }
    
    //remove all the files which were not found for all the words
    //firstly, intersect all the single arrays of the words
    $arAllWords = array();
    $bFirst     = true;
    foreach( $arWordsResults as $strWord => $arWordResults) {
        if( $bFirst) {
            $arAllWords = $arWordResults;
            $bFirst     = false;
        } else {
            $arAllWords = array_intersect( $arAllWords, $arWordResults);
        }
    }
    
    ksort( $arResults);//that key 1 is first
    
    //remove the not-in-all found files from the $arResults array 
    foreach( $arResults as $nId => $arWords)
    {
        foreach( $arWords as $strWord => $nOne)
        {
            if( !in_array( $strWord, $arAllWords)) {
                //remove the one file from the found list
                unset( $arResults[$nId][$strWord]);
            } else {
                //remove the file from the accept list to ensure every file is
                //listed only once (try searching for "window gtk force")
                unset( $arAllWords[ array_search( $strWord, $arAllWords)]);
            }
        }
    }
    
    //now split the subarrays 2 and 3 into sections: enums, properties, signals...
    foreach( $arResults as $nId => $arFiles)
    {
        $arResults[$nId]    = splitIntoSections( $arFiles);
    }
    
    return $arResults;
}//function search2( $strSearch, $strLang)



/**
*   splits an array with files as keys into sections
*   like enums, properties, signals, ...
*
*   @param  array   Array with file names as keys and a number as value
*   @return array   Array with subarrays, files as values in the subarrays. The keys for the subarrays are the section names
*/
function splitIntoSections( $arFiles)
{
    $arSected   = array();
    
    $arRegexs['class']      = '/^[a-zA-Z0-9]+\\.[a-zA-Z0-9]+\\.[a-zA-Z0-9]+$/';
    $arRegexs['constructor']= '/\\.constructor\\.[a-zA-Z0-9]+$/';
    $arRegexs['enum']       = '/^[a-zA-Z0-9]+\\.[a-zA-Z0-9]+\\.enum\\./';
    $arRegexs['method']     = '/^[a-zA-Z0-9]+(\\.[a-zA-Z0-9]+)?\\.method\\./'; //the (..)? is for things like gdk::main()
    $arRegexs['property']   = '/^[a-zA-Z0-9]+\\.[a-zA-Z0-9]+\\.(prop|property)\\./';
    $arRegexs['signal']     = '/^[a-zA-Z0-9]+\\.[a-zA-Z0-9]+\\.signal\\./';
    
    foreach( $arFiles as $strFile => $nOne)
    {
        $bFound = false;
        foreach( $arRegexs as $strSection => $strRegex) 
        {
            if( preg_match( $strRegex, $strFile)) {
                $arSected[$strSection][]    = $strFile;
                $bFound                     = true;
                break;
            }
        }
        if( !$bFound) {
            $arSected['unknown'][]          = $strFile;
        }
    }
    
    //sort the sections internally by filename
    foreach( $arSected as $strSection => $arFiles) {
        sort( $arSected[$strSection]);
    }

    return $arSected;
}//function splitIntoSections( $arFiles)



/**
*	returns the file title for the given file
*	for efficient working, the category has to be given
*
*	The function tries to get the file title with some algorithms,
*	NOT from the direct html files.
*	
*	@param	string	The file name, e.g. gtk.gtkcolorselection.method.get_color.php
*	@param	string	The category of the file, e.g. class/enum/constructor/...
*
*	@return	string	The file title, can be used for link titles
*/
function getFileTitle( $strFilename, $strCategory)
{
	$arParts	= explode( '.', $strFilename);
    
    switch( $strCategory)
    {
    	case 'class':
        	return niceClassName( $arParts[1]);
        case 'constructor':
        	return niceClassName( $arParts[1]) . ' constructor';
        case 'method':
        	if( count( $arParts) == 5) {//class with method
        		return niceClassName( $arParts[1]) . '::' . $arParts[3] . '()';
            } else {//gtk/gdk method
        		return niceClassName( $arParts[0]) . '::' . $arParts[2] . '()';
            }
        case 'property':
        	if( count( $arParts) == 5) {//class property
        		return niceClassName( $arParts[1]) . '::' . $arParts[3];
            } else {//gtk/gdk property
        		return niceClassName( $arParts[0]) . '::' . $arParts[2];
            }
        case 'signal':
        	if( count( $arParts) == 5) {//class signal
        		return niceClassName( $arParts[1]) . ': ' . $arParts[3];
            } else {//gtk/gdk signal
        		return niceClassName( $arParts[0]) . ': ' . $arParts[2];
            }
    	default:
        	return $strFilename;
    }
}//function getFileTitle( $strFilename, $strCategory)



/**
*	makes a nice class name from a lowercase name
*	given "gdkcolor" it returns "GdkColor"
*
*	@param	string	The lowercase class name
*	@return	string	The nice cased class name
*/
function niceClassName( $strLowercaseClass)
{
	$strPrefix	= substr( $strLowercaseClass, 0, 3);
    if( $strPrefix == 'gdk' || $strPrefix == 'gtk')
    {
    	$strNice	= ucfirst( $strPrefix) . ucfirst( substr( $strLowercaseClass, 3));
    } else {
    	$strNice	= ucfirst( $strLowercaseClass);
    }

    return $strNice;
}//function niceClassName( $strLowercaseClass)



/**
*   Looks up a given word in the index
*   useful for debugging
*/
function lookup( $strWord, $nNumber = 'all', $strLang = 'en')
{
    $GLOBALS['index.file']              = getIndexFile( $strLang);
    
    $arIndex        = unserialize( file_get_contents( $GLOBALS['index.file']));
    
    if( !isset( $arIndex[$strWord])) {
        echo 'Word "' . $strWord . '" does not exist in index.' . "\r\n";
    } else {
        echo 'Word "' . $strWord . '", section ' . $nNumber . ':' . "\r\n";
        if( $nNumber == 'all') {
            var_dump( $arIndex[$strWord]);
        } else {
            if( !isset( $arIndex[$strWord][$nNumber])) {
                echo 'Section ' . $nNumber . ' of word "' . $strWord . '" does not exist in index.' . "\r\n";
            } else {
                var_dump( $arIndex[$strWord][$nNumber]);
            }
        }
    }
}//function lookup( $strWord, $nNumber = 'all') 





//start something?
if( isset( $GLOBALS['argc']) && $GLOBALS['argc'] > 1) 
{ 
    if( $GLOBALS['argv'][1] == '-i' || $GLOBALS['argv'][1] == '--index') 
    {
        if( !isset( $GLOBALS['argv'][2])) {
            echo 'no language specified, using default "en"' . "\r\n";
            $strLang    = 'en';
        } else {
            $strLang    = $GLOBALS['argv'][2];
        }
        buildLanguageIndex( $strLang);
    } 
    else if( $GLOBALS['argv'][1] == '-h' || $GLOBALS['argv'][1] == '--help') 
    {
        echo 'php-gtk manual search' . "\r\n";
        echo 'parameters:' . "\r\n";
        echo ' -a --allindices              create index file for every language' . "\r\n";
        echo ' -h --help                    display this help' . "\r\n";
        echo ' -i --index language          create index file for language' . "\r\n";
        echo ' -l --lookup                  lookup a word in the index' . "\r\n";
        echo ' -s --search string language  search for the string' . "\r\n";
    } 
    else if( $GLOBALS['argv'][1] == '-a' || $GLOBALS['argv'][1] == '--allindices') {
        buildLanguageIndices();
    } 
    else if( $GLOBALS['argv'][1] == '-l' || $GLOBALS['argv'][1] == '--lookup') 
    {
        if( !isset( $GLOBALS['argv'][2])) {
            echo 'no word specified' . "\r\n";
        } else {
            $nNumber    = isset( $GLOBALS['argv'][3]) ? $GLOBALS['argv'][3] : 'all';
            lookup( $GLOBALS['argv'][2], $nNumber);
        }
    } 
    else if( $GLOBALS['argv'][1] == '-s' || $GLOBALS['argv'][1] == '--search'
          || $GLOBALS['argv'][1] == '-2' || $GLOBALS['argv'][1] == '--search2') 
    {
        if( !isset( $GLOBALS['argv'][2])) {
            echo 'no search string specified' . "\r\n";
        } else 
        {
            if( !isset( $GLOBALS['argv'][3])) {
                echo 'no language specified, using default "en"' . "\r\n";
                $strLang    = 'en';
            } else {
                $strLang    = $GLOBALS['argv'][3];
            }
            
            if( $GLOBALS['argv'][1] == '-2' || $GLOBALS['argv'][1] == '--search2') 
            {
                //results are still grouped
                $arFiles    = search2( $GLOBALS['argv'][2], $strLang);
                var_dump( $arFiles);
            } else {
                //normal search function, flat result
                $arFiles    = search( $GLOBALS['argv'][2], $strLang);
                echo 'Found ' . count( $arFiles) . ' files matching "' . $GLOBALS['argv'][2] . '"' . "\r\n";
                foreach( $arFiles as $nId => $strFile) {
                    echo $nId . ' ' . $strFile . "\r\n";
                }
            }
            
        }
    }
}//start something

?>