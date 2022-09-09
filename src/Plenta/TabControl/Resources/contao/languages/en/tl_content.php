<?php

/**
 * TabControl
 *
 * @copyright  Christian Barkowsky 2011-2022, Jean-Bernard Valentaten 2009-2011
 * @package    tabControl
 * @author     Christian Barkowsky <http://christianbarkowsky.de>
 * @license    LGPL
 */

/**
 * Content elements
 */
$GLOBALS['TL_LANG']['CTE']['tabcontrol'] = array('TabControl', 'ceates a new TabCotrol element');

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_content']['tabBehaviour']	= array('Behaviour', 'Please select how the tabs shall behave.');
$GLOBALS['TL_LANG']['tl_content']['tabClasses']		= array('Classname','Leave the field empty to use the standard classnames, or specify you own tab and pane classes.');
$GLOBALS['TL_LANG']['tl_content']['tabTitles']		= array('Tab titles','Please specify the tab titles. HTML-tags are allowed.');
$GLOBALS['TL_LANG']['tl_content']['tabType']		= array('Operation mode','Please select the operation mode of the TabControl element.');
$GLOBALS['TL_LANG']['tl_content']['tab_remember'][0] = 'Remember active tab';
$GLOBALS['TL_LANG']['tl_content']['tab_remember'][1] = 'Active tab is stored as a cookie.';
$GLOBALS['TL_LANG']['tl_content']['tabControl_mootoolsHint'] = 'Please activate Mootools in the page layout.';

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_content']['tab_legend'] = 'TabControl settings';

/**
 * References
 */
$GLOBALS['TL_LANG']['tl_content']['tabControl'] = array();
$GLOBALS['TL_LANG']['tl_content']['tabControl']['click']			= array('Click', 'When a tab is clicked, the corresponding pane becomes visible.');
$GLOBALS['TL_LANG']['tl_content']['tabControl']['mouseover']		= array('Touch', 'When a tab is touched by the mouse pointer, the corresponding pane becomes visible.');
$GLOBALS['TL_LANG']['tl_content']['tabControl']['tabcontrolstart']	= array('Pane start', 'Marks the beginning of a new TabControl-pane that spans several content elements.');
$GLOBALS['TL_LANG']['tl_content']['tabControl']['tabcontrolstop']	= array('Pane end', 'Marks the end of a TabControl-pane that spans several content elements.');
$GLOBALS['TL_LANG']['tl_content']['tabControl']['tabcontroltab']	= array('Tabgroup', 'Creates a new group of tabs.');
