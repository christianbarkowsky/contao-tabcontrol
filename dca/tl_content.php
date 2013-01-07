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
 * @copyright  Christian Barkowsky, Mirco Rahn, Jean-Bernard Valentaten 2009-2011
 * @author     Christian Barkowsky <http://www.christianbarkowsky.de>, Mirco Rahn <http://www.complus-ag.net>, Jean-Bernard Valentaten <troggy.brains@gmx.de>
 * @package    TabControl
 * @license    GNU/LGPL
 * @filesource
 */

// Palettes
$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'tabType';
$GLOBALS['TL_DCA']['tl_content']['palettes']['tabcontrol'] = '{type_legend},type,tabType';
$GLOBALS['TL_DCA']['tl_content']['palettes']['tabcontroltab'] = '{type_legend},type,headline,tabType;{tab_legend},tabTitles,tabBehaviour,tabClasses;{tabcontrol_autoplay_legend:hide},tab_autoplay_autoSlide,tab_autoplay_delay,tab_autoplay_fade;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_content']['palettes']['tabcontrolstart'] = '{type_legend},type,tabType;{tab_legend},tabClasses;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_content']['palettes']['tabcontrolstop'] = '{type_legend},type,tabType;{protected_legend:hide},protected;{expert_legend:hide},guests';

// Fields
$GLOBALS['TL_DCA']['tl_content']['fields']['tabType'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['tabType'],
    'default' => 'tab',
    'exclude' => true,
    'inputType' => 'radio',
    'options' => array('tabcontroltab', 'tabcontrolstart', 'tabcontrolstop', 'tabcontrol_end'),
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['tabControl'],
    'eval' => array('helpwizard' => true, 'submitOnChange' => true)
);

$GLOBALS['TL_DCA']['tl_content']['fields']['tabTitles'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['tabTitles'],
    'exclude' => true,
    'inputType' => 'listWizard',
    'eval' => array('mandatory' => true, 'maxlength' => 255, 'allowHtml' => true)
);

$GLOBALS['TL_DCA']['tl_content']['fields']['tabClasses'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['tabClasses'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => array('multiple' => true, 'size' => 2, 'rgxp' => 'alnum', 'tl_class' => 'w50')
);

$GLOBALS['TL_DCA']['tl_content']['fields']['tabBehaviour'] = array
(
    'label' => $GLOBALS['TL_LANG']['tl_content']['tabBehaviour'],
    'exclude' => true,
    'search' => false,
    'inputType' => 'select',
    'options' => array('click', 'mouseover'),
    'default' => 'click',
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['tabControl'],
    'eval' => array('helpwizard' => true, 'tl_class' => 'w50')
);

$GLOBALS['TL_DCA']['tl_content']['fields']['tab_autoplay_autoSlide'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['tabControl']['tab_autoplay_autoSlide'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => array('tl_class' => 'w50 m12')
);

$GLOBALS['TL_DCA']['tl_content']['fields']['tab_autoplay_fade'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['tabControl']['tab_autoplay_fade'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => array('tl_class' => 'w50')
);

$GLOBALS['TL_DCA']['tl_content']['fields']['tab_autoplay_delay'] = array
(
	'label' => &$GLOBALS['TL_LANG']['tl_content']['tabControl']['tab_autoplay_delay'],
	'inputType' => 'text',
	'eval' => array('mandatory' => true, 'nospace' => true, 'rgxp' => 'digit', 'tl_class' => 'w50')
);

?>
