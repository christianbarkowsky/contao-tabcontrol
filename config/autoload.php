<?php

/**
 * TabControl
 * 
 * @copyright  Christian Barkowsky 2012-2013, Jean-Bernard Valentaten 2009-2012
 * @package    tabControl
 * @author     Christian Barkowsky <http://www.christianbarkowsky.de>, Jean-Bernard Valentaten <troggy.brains@gmx.de>
 * @license    LGPL
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Elements
	'Contao\ContentTabControl'          => 'system/modules/tabcontrol/elements/ContentTabControl.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'ce_tabcontrol_start' => 'system/modules/tabcontrol/templates',
	'ce_tabcontrol_stop' => 'system/modules/tabcontrol/templates',
	'ce_tabcontrol_tab' => 'system/modules/tabcontrol/templates',
	'ce_tabcontrol_end' => 'system/modules/tabcontrol/templates',
));

?>