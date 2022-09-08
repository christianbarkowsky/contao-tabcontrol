<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');
/**
 * TYPOlight webCMS
 * Copyright (C) 2005 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright  Jean-Bernard Valentaten 2009 
 * @author     Jean-Bernard Valentaten <troggy.brains@gmx.de> 
 * @package    TabControl
 * @license    GNU/LGPL 
 * @filesource
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
?>