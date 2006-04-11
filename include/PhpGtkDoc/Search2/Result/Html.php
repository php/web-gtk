<?php
require_once 'PhpGtkDoc/Search2.php';

/**
*   PHP-Gtk2-Doc result formatter for HTML
*
*   @author Christian Weiske <cweiske@php.net>
*/
class PhpGtkDoc_Search2_Result_Html
{
    /**
    *   The result types are replaced with
    *   this titles in the output
    *
    *   @var array
    */
    protected static $arTypeTitles = array(
        'class'         => 'Classes',
        'method'        => 'Methods',
        'property'      => 'Properties',
        'field'         => 'Fields',
        'signal'        => 'Signals',
        'enum'          => 'Enums',
        'constructor'   => 'Constructors',
        'tutorial'      => 'Tutorials',
        'unknown'       => 'Unknown type'
    );

    /**
    *   The levels have this titles
    *
    *   @var array
    */
    protected static $arLevelTitles = array(
        1 => 'Very relevant',
        2 => 'Relevant',
        3 => 'Not so relevant'
    );



    /**
    *   Formats the result as html and returns it.
    *
    *   @param array    $arResult   The result you get from PhpGtkDoc_Search2::find()
    *   @param string   $strPrefix  The prefix to put before the file names
    *   @param string   $strFilter  The type filter (pass e.g. "method" to find methods only)
    *
    *   @return string      Nicely formatted ascii output
    */
    public static function format($arResult, $strPrefix = '', $strFilter = '')
    {
        $strOutput = '';

        foreach ($arResult as $nLevel => $arLevel) {
            $strLevelOutput = '';
            foreach ($arLevel as $strType => $arFiles) {
                if ($strFilter != '' && $strType != $strFilter) { continue; }
                $strLevelOutput .= '<h4>' . self::$arTypeTitles[$strType] . "</h4>\r\n";
                $strLevelOutput .= '<ul>';
                foreach ($arFiles as $strFile) {
                    $strLevelOutput .= '<li><a href="'
                        . htmlspecialchars($strPrefix . $strFile)
                        . '">'
                        . htmlspecialchars(PhpGtkDoc_Search2::getFileTitle($strFile, $strType))
                        . "</a></li>\r\n";
                }
                $strLevelOutput .= '</ul>';
            }
            if ($strLevelOutput != '') {
                $strOutput .= '<h3>' . self::$arLevelTitles[$nLevel] . "</h3>\r\n" . $strLevelOutput;
            }
        }

        return $strOutput;
    }//public static function format($arResult, $strPrefix = '', $strFilter = '')

}//class PhpGtkDoc_Search2_Result_Html
?>