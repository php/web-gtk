<?php
/*
 * $Id$
 */

// Send the appropriate header
header('Content-type: application/rss+xml');

// Start output buffering in order to grab the data from the documentation
// CVS updates file (that is echoed when included) and save to a variable
// instead of echoing it right away.
ob_start();
echo '<?xml version=\'1.0\' standalone=\'yes\'?>' . "\n";
include_once 'http://gtk.php.net/manual/en/updates.php';
$xmlstr = ob_get_clean();
$xml = simplexml_load_string($xmlstr);


echo '<?xml version="1.0" encoding="UTF-8"?>';
?>

<rdf:RDF
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
    xmlns="http://purl.org/rss/1.0/"
    xmlns:dc="http://purl.org/dc/elements/1.1/">

<channel rdf:about="http://gtk.php.net/manual1">
    <title>PHP-GTK Manual</title>
    <link>http://gtk.php.net/manual1</link>
    <description>The PHP-GTK on-line manual</description>
    <items>
        <rdf:Seq>
<?php
foreach ($xml->a as $link) {
    echo '            <rdf:li rdf:resource="' . $link->attributes() . '" />';
    echo "\n";
}
?>
        </rdf:Seq>
    </items>
</channel>

<?php
foreach ($xml->a as $link) {
    foreach ($link->attributes() as $key => $value) {
        if ($key == 'date') {
            $date = date('Y-m-d', strtotime($value));
        } else {
            $url = $value;
        }
    }
?>
<item rdf:about="<?php echo $url; ?>">
    <title><?php echo $link; ?></title>
    <link><?php echo $url; ?></link>
    <description>Documentation update: <?php echo $link; ?></description>
    <dc:date><?php echo $date; ?></dc:date>
</item>

<?php
}
?>
</rdf:RDF>
