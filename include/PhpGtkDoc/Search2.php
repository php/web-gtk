<?php
/**
*   Class to search the phpgtk2 manual.
*
*   Use the static PhpGtkDoc_Search2::find() method
*   to search for a string, and use one of the
*   PhpGtkDoc_Search2_Result_* classes to display the result.
*
*   @author Christian Weiske <cweiske@php.net>
*/
class PhpGtkDoc_Search2
{
    /**
    *   Searches for the given string
    *   This function returns a nested array which allows the search results
    *       being displayed by sections like enums/methods/classes/...
    *
    *   @param  string  The string to search. It is automatically split into substrings by the space char
    *   @param  string  The index file to use
    *
    *   @return array   Nested array with results. Format:
    *                       array( 1 => subarray(), 2 => subarray(), 3 => subarray())
    *                       subarray( 'class' => array_of_files(), 'method' => array_of_files(), ...)
    */
    public static function find($strSearch, $strIndexFile)
    {
        if (!file_exists($strIndexFile)) {
            throw new Exception('Index file does not exist: ' . $strIndexFile);
        }
        //TODO: Split better, so that we can exclude something with minus and so
        $arSearchWords  = explode(' ', strtolower($strSearch));
        $arIndex        = unserialize(file_get_contents($strIndexFile));

        $arResults      = array();//all the found files for the indices
        $arWordsResults = array();//the found files which were found for each word

        foreach ($arSearchWords as $strWord) {
            $arWordsResults[$strWord]   = array();//needs to be done
            if (isset($arIndex[$strWord])) {
                $arFound    = $arIndex[$strWord];
                foreach ($arFound as $nIndex => $arFiles) {
                    foreach ($arFiles as $strFile) {
                        $arWordsResults[$strWord][]   = $strFile;
                        $arResults[$nIndex][$strFile] = 1;
                    }
                }
            }
        }

        //remove all the files which were not found for all the words
        //firstly, intersect all the single arrays of the words
        $arAllWords = array();
        $bFirst     = true;
        foreach ($arWordsResults as $strWord => $arWordResults) {
            if ($bFirst) {
                $arAllWords = $arWordResults;
                $bFirst     = false;
            } else {
                $arAllWords = array_intersect($arAllWords, $arWordResults);
            }
        }

        ksort($arResults);//that key 1 is first

        //remove the not-in-all found files from the $arResults array 
        foreach ($arResults as $nId => $arWords) {
            foreach ($arWords as $strWord => $nOne) {
                if (!in_array($strWord, $arAllWords)) {
                    //remove the one file from the found list
                    unset($arResults[$nId][$strWord]);
                } else {
                    //remove the file from the accept list to ensure every file is
                    //listed only once (try searching for "window gtk force")
                    unset($arAllWords[array_search($strWord, $arAllWords)]);
                }
            }
        }

        //now split the subarrays 2 and 3 into sections: enums, properties, signals...
        foreach ($arResults as $nId => $arFiles) {
            $arResults[$nId]    = self::splitIntoSections( $arFiles);
        }

        return self::reorderResult($arResults);
    }//public static function find($strSearch, $strIndexFile)



    /**
    *   Re-orders the result to give a better order.
    *   E.g. methods of the class which have the search string in it
    *   will be moved to level 3
    *
    *   @param array    $arResults  Result array
    *   @return array               Fixed result array
    */
    protected static function reorderResult($arResult)
    {
        //if a class is found, move the methods of this class to level 3,
        //as they all match. So non-same-class methods with the search
        //string should have higher priority
        if (isset($arResult[1]['class'])) {
            foreach ($arResult[1] as $strType => $arLevel) {
                if ($strType != 'class') {
                    $arResult[3][$strType] = $arLevel;
                    unset($arResult[1][$strType]);
                }
            }
        }

        return $arResult;
    }//protected static function reorderResult($arResult)



    /**
    *   splits an array with files as keys into sections
    *   like enums, properties, signals, ...
    *
    *   @param  array $arFiles  array with file names as keys and a number as value
    *   @return array           array with subarrays, files as values in the subarrays. The keys for the subarrays are the section names
    */
    protected static function splitIntoSections($arFiles)
    {
        $arSected   = array();

        $arRegexs['tutorials']  = '/^tutorials\\./';//has to be before class and method

        $arRegexs['class']      = '/^[a-zA-Z0-9]+\\.[a-zA-Z0-9]+\\.[a-zA-Z0-9]+$/';
        $arRegexs['constructor']= '/\\.constructor\\.([a-zA-Z0-9_]+\\.)?/';
        $arRegexs['enum']       = '/^[a-zA-Z0-9]+\\.enum\\./';
        $arRegexs['method']     = '/^[a-zA-Z0-9]+(\\.[a-zA-Z0-9]+)?\\.method\\./'; //the (..)? is for things like gdk::main()
        $arRegexs['property']   = '/^[a-zA-Z0-9]+\\.[a-zA-Z0-9]+\\.(prop|property)\\./';
        $arRegexs['field']      = '/^[a-zA-Z0-9]+\\.[a-zA-Z0-9]+\\.(field)\\./';
        $arRegexs['signal']     = '/^[a-zA-Z0-9]+\\.[a-zA-Z0-9]+\\.signal\\./';

        foreach ($arFiles as $strFile => $nOne) {
            $strBaseFile = basename($strFile);
            $bFound = false;
            foreach ($arRegexs as $strSection => $strRegex) {
                if( preg_match( $strRegex, $strBaseFile)) {
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
    }//protected static function splitIntoSections($arFiles)



    /**
    *   Returns the file title for the given file
    *   for efficient working, the category has to be given
    *
    *   The function tries to get the file title with some algorithms,
    *   NOT from the direct html files.
    *
    *   @param  string  $strFilename    The file name, e.g. gtk.gtkcolorselection.method.get_color.php
    *   @param  string  $strCategory    The category of the file, e.g. class/enum/constructor/...
    *
    *   @return string  The file title, can be used for link titles
    */
    public static function getFileTitle($strFilename, $strCategory)
    {
        $arParts    = explode('.', basename($strFilename));
        $nParts     = count($arParts);

        switch ($strCategory) {
            case 'class':
                if ($arParts[1] == 'functions') {
                    //function list gtk.functions.php
                    return self::niceClassName($arParts[0]) . ' functions';
                } else {
                    //normal class name gtk.gtkentry.php
                    return self::niceClassName($arParts[1]);
                }
            case 'constructor':
                if ($nParts == 5) {//static method constructor
                    return self::niceClassName($arParts[1]) . '::' . $arParts[3] . '()';
                } else {
                    return self::niceClassName($arParts[1]) . ' constructor';
                }
            case 'method':
                if ($nParts == 5) {//class with method
                    return self::niceClassName($arParts[1]) . '::' . $arParts[3] . '()';
                } else {//gtk/gdk method
                    return self::niceClassName($arParts[0]) . '::' . $arParts[2] . '()';
                }
            case 'property':
                if ($nParts == 5) {//class property
                    return self::niceClassName($arParts[1]) . '::' . $arParts[3];
                } else {//gtk/gdk property //does this exist?
                    return self::niceClassName($arParts[0]) . '::' . $arParts[2];
                }
            case 'field':
                if ($nParts == 5) {//class field
                    return self::niceClassName($arParts[1]) . '::' . $arParts[3];
                } else {//gtk/gdk field //does this exist?
                    return self::niceClassName($arParts[0]) . '::' . $arParts[2];
                }
            case 'signal':
                if ($nParts == 5) {//class signal
                    return self::niceClassName($arParts[1]) . ': ' . $arParts[3];
                } else {//gtk/gdk signal
                    return self::niceClassName($arParts[0]) . ': ' . $arParts[2];
                }
            case 'enum':
                return self::niceClassName($arParts[0]) . ucfirst($arParts[2]) . ' enum';
            case 'tutorials':
                if ($nParts == 2) {
                    return 'Tutorial list';
                } else if ($nParts == 3) {
                    return ucfirst($arParts[1])  . ' tutorial';
                } else {
                    return ucfirst( $arParts[1])  . ' tutorial: ' . $arParts[2];
                }
            default:
                return $strFilename;
        }
    }//public static function getFileTitle($strFilename, $strCategory)



    /**
    *   Makes a nice class name from a lowercase name
    *   given "gdkcolor" it returns "GdkColor"
    *
    *   @param  string  The lowercase class name
    *   @return string  The nice cased class name
    */
    protected static function niceClassName( $strLowercaseClass)
    {
        $strPrefix  = substr( $strLowercaseClass, 0, 3);
        if ($strPrefix == 'gdk' || $strPrefix == 'gtk' || $strPrefix == 'atk') {
            $strNice    = ucfirst($strPrefix) . ucfirst(substr($strLowercaseClass, 3));
        } else if ($strPrefix == 'pan') {
            $strNice    = ucfirst($strPrefix) . ucfirst(substr($strLowercaseClass, 5));
        } else {
            $strNice    = ucfirst($strLowercaseClass);
        }

        return $strNice;
    }//protected static function niceClassName( $strLowercaseClass)

}//class PhpGtkDoc_Search2
?>