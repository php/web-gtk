<?php if (!defined('PmWiki')) exit();
/*  Copyright 2002-2004 Patrick R. Michaud (pmichaud@pobox.com)
    This file is part of PmWiki; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.  See pmwiki.php for full details.

    This file shows examples of predefining WikiStyles for use in PmWiki pages.
    It is automatically included via the stdconfig.php script unless 
    disabled by
        $EnableStdWikiStyles = 0;
    To explicitly enable the markups defined below, insert the line
	include_once('scripts/wikistyles.php');
    in the config.php file.
*/

# the %newwin% pattern causes links to open in a new window
$WikiStyle['newwin']['target'] = '_blank';		

$WikiStyleTags['display'] = array('style' => 'display:$value; ');
$WikiStyle['comment']['display'] = 'none';

# define colored text styles as %black%, %white%, %red%, from CSS color names
foreach (array('black','white','red','yellow','blue','gray',
  'silver', 'maroon', 'green', 'navy', 'purple') as $c) 
    $WikiStyle[$c]['color'] = $c;

# define %darkgreen% from a CSS #RRGGBB color specification
$WikiStyle['darkgreen']['color'] = '#006400';

# example defining %highlight% with multiple attributes
# $WikiStyle['highlight']['color'] = 'black';
# $WikiStyle['highlight']['bgcolor'] = 'yellow';

# To restrict wiki page authors to the styles you define, execute the
# following statement in local.php:
#	$WikiStylePattern = '%[-\\w]*%'
# To turn off WikiStyles completely, execute:
#	unset($WikiStylePattern);
?>
