<?php
//we are in php-gtk-web/ and need php-gtk-web/include/ as include path
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__) . '/include/');

$strResult = null;
$strError  = null;
$strSearch = null;
$strSelectedType = '';

if (isset($_REQUEST['q']) && $_REQUEST['q'] != '') {
    require_once 'PhpGtkDoc/Search2.php';
    require_once 'PhpGtkDoc/Search2/Result/Html.php';

    $strIndexFile = dirname(__FILE__) . '/include/PhpGtkDoc/index.search';
    $strDocumentationDir = 'manual/en/';

    if (isset($_REQUEST['type']) && isset($arTypes[$_REQUEST['type']])) {
        $strSelectedType = $_REQUEST['type'];
    }

    $strSearch = preg_replace('/[^a-zA-Z0-9_ ]/', '', $_REQUEST['q']);
    try {
        $arResults = PhpGtkDoc_Search2::find($strSearch, $strIndexFile);
        $strResult = PhpGtkDoc_Search2_Result_Html::format($arResults, $strDocumentationDir, $strSelectedType);

        if ($strResult == '') {
            $strResult = '<p>Your search for "' . $strSearch . '" didn\'t return any results.</p>';
        }
    } catch (Exception $e) {
        $strError = $e->getMessage();
    }
}

commonHeader('Search results');
if ($strError !== null) {
    echo '<h2>Error</h2>';
    echo $strError;
}
if ($strResult !== null) {
    echo '<h2>PHP-GTK 2 manual search results for "' . $strSearch . '"</h2>';
    echo $strResult;
}
commonFooter();
?>
