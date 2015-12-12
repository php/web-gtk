<?php
/**
*   Class with all functionality needed to create the index for the
*   php-gtk2-doc search class.
*
*
*   Index explanation:
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
*   @author Christian Weiske <cweiske@php.net>
*/
class PhpGtkDoc_Search2_Index
{
    protected static $arReserved = array(
        'atk', 'gtk', 'gdk', 'scn', 'pango', 'method',
        'property', 'prop', 'field', 'enum', 'signal', 'constructor'
    );
    protected static $arReservedMethods = array(
        'get', 'set'
    );



    /**
    *   Creates the search index.
    *   Required parameters are the documentation directory
    *   and the index file, as which the index shall be stored.
    */
    public static function createIndex($strDocumentationDirectory, $strIndexFile)
    {
        if (!file_exists($strDocumentationDirectory) || !is_dir($strDocumentationDirectory)) {
            throw new Exception('Documentation directory does not exist: ' . $strDocumentationDirectory);
        }
        if ((file_exists($strIndexFile) && !is_writable($strIndexFile))
             || (!file_exists($strIndexFile) && !is_writable(dirname($strIndexFile)))) {
            throw new Exception('Index file is not writable: ' . $strIndexFile);
        }

        file_put_contents($strIndexFile,
            serialize(
                self::buildIndexFromFiles(
                    self::getFiles($strDocumentationDirectory),
                    $strDocumentationDirectory
                )
            )
        );
    }//public static function createIndex($strDocumentationDirectory, $strIndexFile)



    /**
    *   Creates an index array from the given files.
    *   The filenames are meant to be relative to the doc directory,
    *   so that e.g. "gdk/gdk.functions.html" or
    *   "gdk/gdk.gdkcolormap.method.get_screen.html" are in it.
    *
    *   The index array has the following structure:
    *   [keyword]
    *       - [1] priority level
    *           - [doc file 1]
    *           - [doc file 2]
    *       - [2] priority level
    *           - [doc file 1]
    *           - [doc file 2]
    *       - [3] priority level
    *           - [doc file 1]
    *           - [doc file 2]
    *
    *   Priorities:
    *   1   class names, tutorial names, ...
    *   2   methods, signals, enums
    *   3   methods which have the keyword in the class name
    *
    *   @param array    $arFiles    Array with all the files
    *   @param string   $strDocumentationDirectory  The directory which the file names are relative to
    *
    *   @return array   The index array, can be used with PhpGtkDoc_Search2
    */
    protected static function buildIndexFromFiles($arFiles, $strDocumentationDirectory)
    {
        $arIndex = array();

        $arCamelCaseWords = self::getCamelCaseWords(
            self::getTitles(
                self::getTitleFiles(
                    $arFiles
                ),
                $strDocumentationDirectory
            )
        );

        foreach ($arFiles as $strFile) {
            $strBaseFile = basename($strFile);
            $strBaseFile = substr($strBaseFile, 0, strrpos($strBaseFile, '.'));
            $arPieces    = explode('.', $strBaseFile);
            //remove reserved words so that they are not indexed
            //$arPieces   = array_diff($arPieces, self::$arReserved);
            //when uncommenting the last line, change all "$nCountWords > 2" to "$nCountWords > 1"

            $arNewPieces    = array();
            $nCountWords    = count($arPieces);
            $nWordPos       = -1;
            foreach ($arPieces as $strWord) {
                $nWordPos++;//the indices do not have constant values (array_diff)
                if ($nWordPos == $nCountWords - 1 && $nCountWords > 2) {
                    //last word in the filename
                    $nPriority = 2;
                } else {
                    //not the last word in the filename
                    $nPriority = 1;
                }
                $arNewPieces[$nPriority][] = $strWord;//the word itself
                if (isset($arCamelCaseWords[$strWord])) {
                    $arNewPieces[$nPriority] = array_merge($arNewPieces[$nPriority], $arCamelCaseWords[$strWord]);
                }
/*
                $strPrefix      = substr($strWord, 0, 3);
                if ($strPrefix == 'gtk' || $strPrefix == 'gdk' || $strPrefix == 'atk' || $strPrefix == 'pan') {
                    //pango is 5 chars, all others are 3
                    $nCutPos = $strPrefix == 'pan' ? 5 : 3;

                    //classes have gtk or gdk at the beginning, e.g. gtkfixed or gtkoptionmenu
                    $arNewPieces[$nPriority][] = substr($strWord, $nCutPos);
                    if (isset($arCamelCaseWords[$strWord])) {
                        $arNewPieces[$nPriority] = array_merge($arNewPieces[$nPriority], $arCamelCaseWords[$strWord]);
                    }
                }
*/
                $arMethodPieces = explode( '_', $strWord);
                if (count($arMethodPieces) > 1) {
                    //if you want to remove "get" and "set" from the index, uncomment the following line
                    //$arMethodPieces = array_diff( $arMethodPieces, self::$arReservedMethods);
                    $arNewPieces[2] = array_merge($arNewPieces[2], $arMethodPieces);
                    if (count( $arMethodPieces) > 2) {
                        //that we have some partly connections like do_this from do_this_thing
                        foreach ($arMethodPieces as $nId => $strPiece) {
                            if ($nId < count($arMethodPieces) - 1) {
                                $arNewPieces[2][]   = $strPiece . '_' . $arMethodPieces[$nId + 1];
                            }
                        }
                    }
                }
            }//foreach piece

            //append the search words to the index array
            foreach ($arNewPieces as $nPriority => $arPriorityPieces) {
                foreach ($arPriorityPieces as $strPiece) {
                    $arIndex[$strPiece][$nPriority][]   = $strFile;
                }
            }
        }

        //sort the index | should speed up searching and is nice for debugging
        ksort($arIndex);

        return $arIndex;
    }//protected static function buildIndexFromFiles($arFiles)



    /**
    *   Returns an array of file names from the documentation directory.
    *   The file names are relative to the doc directory
    *
    *   @param string $strDocumentationDirectory    The directory of the compiled manual
    *   @return array   All the files in there
    */
    protected static function getFiles($strDocumentationDirectory)
    {
        $strDir = getcwd();
        chdir($strDocumentationDirectory);
        //php-gtk-web specific
        #$arFiles = glob('*/*.{html,php}', GLOB_BRACE);
        $arFiles = glob('*.php');
        chdir($strDir);

        if (count($arFiles) == 0) {
            throw new Exception('No files found in ' . $strDocumentationDirectory);
        }

        return $arFiles;
    }//protected static function getFiles($strDocumentationDirectory)



    /**
    *   Returns an array of filenames that should contain title tags
    *   needed for the camelCase title splitter
    *
    *   @param  array   $arFiles    Array with files that (@see getFiles())
    *   @return array   Array with files that should have needed titles
    */
    protected static function getTitleFiles($arFiles)
    {
        $nFiles = count($arFiles);
        for ($nA = 0; $nA < $nFiles; $nA++) {
            //class files (gtk.gtktreeview.html) or enums (gtk.enum.selectionmode.html)
            if (!preg_match('/^[a-z0-9]+\\.(enum\\.)?[a-z0-9]+\\.[a-z]+$/', basename($arFiles[$nA]))) {
                unset($arFiles[$nA]);
            }
        }
        return $arFiles;
    }//protected static function getTitleFiles($arFiles)



    /**
    *   Returns an array with the contents of the html title tags
    *   in the given files
    *
    *   @param array $arFiles   The files to check
    *   @param string $strDocumentationDirectory    The directory the file names are relative to
    *
    *   @return array   Array of titles.
    */
    protected static function getTitles($arFiles, $strDocumentationDirectory)
    {
        $arTitles = array();
        foreach ($arFiles as $strFile) {
            if (substr($strFile, -4) === '.php') {
                //.php files (make phpweb) don't have a title header
                if (preg_match('/manualHeader\\(\"(.+)\"\\,/', file_get_contents($strDocumentationDirectory . '/' . $strFile), $arMatches)) {
                    $arTitles[] = $arMatches[1];
                }
            } else {
                if (preg_match('/<title>(.+)<\\/title>/', file_get_contents($strDocumentationDirectory . '/' . $strFile), $arMatches)) {
                    $arTitles[] = $arMatches[1];
                }
            }
        }
        return $arTitles;
    }//protected static function getTitles($arFiles, $strDocumentationDirectory)



    /**
    *   Splits all the titles from camelCase into several
    *   words (camel and case).
    *
    *   @param array    $arTitles   The titles from the files
    *   @return array   Array with strtolower(word) => split words array
    */
    protected static function getCamelCaseWords($arTitles)
    {
        $arSplit = array();

        foreach ($arTitles as $strTitle) {
            if (strpos($strTitle, ' ') !== false) {
                //will be tutorial title or "Gtk functions"
                //we don't want this now.
                continue;
            }
            $arSplit[strtolower($strTitle)] = self::varyWords(self::splitCamelCaseWord($strTitle));
        }

        return $arSplit;
    }//protected static function getCamelCaseWords($arTitles)



    /**
    *   Splits a camelCaseWord into words (camel, case, word)
    *
    *   @param string   $strWord    The word to split
    *   @return array   Array with lowercase words
    */
    protected static function splitCamelCaseWord($strWord)
    {
        $strWords = preg_replace('/([A-Z])/', ' \\1', $strWord);
        return explode(' ', strtolower($strWords));
    }//protected static function splitCamelCaseWord($strWord)



    /**
    *   Makes variations of an array of words.
    *   E.g. array(Gtk, Tree, View, Column) will get the variations
    *   gtktree, gtktreeview, treeview, treeviewcolumn, viewcolumn
    *   added to the word list
    *
    *   @param string   $arWords    Array with words
    *   @return array   Array with words and their variations
    */
    protected static function varyWords($arWords)
    {
        $arVariations = $arWords;
        for ($nA = 0; $nA < count($arWords); $nA++) {
            $strVariation = '';
            for ($nB = $nA; $nB < count($arWords); $nB++) {
                $strVariation .= $arWords[$nB];
                $arVariations[] = $strVariation;
            }
        }

        return array_unique($arVariations);
    }//protected static function varyWords($arWords)

}//class PhpGtkDoc_Search2_Index
?>