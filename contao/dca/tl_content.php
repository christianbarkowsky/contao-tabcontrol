<?php

declare(strict_types=1);

/**
 * Plenta Tab Control Bundle for Contao Open Source CMS
 *
 * @copyright     Copyright (c) 2012-2022, Plenta.io
 * @author        Plenta.io <https://plenta.io>
 * @license       http://opensource.org/licenses/lgpl-3.0.html
 * @link          https://github.com/plenta/
 */

use Contao\Input;
use Contao\Backend;
use Contao\Message;
use Contao\ContentModel;

$GLOBALS['TL_DCA']['tl_content']['config']['onload_callback'][] = ['tl_content_tabcontrol', 'showMootoolsHint'];

$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'tabType';
$GLOBALS['TL_DCA']['tl_content']['palettes']['tabcontrol'] = '{type_legend},type,tabType;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['tabType_tabcontroltab'] = ';{tab_legend},tabControlCookies,tab_tabs,tabBehaviour,tabClasses,tab_remember;{tabcontrol_autoplay_legend:hide},tab_autoplay_autoSlide,tab_autoplay_delay,tab_autoplay_fade;{template_legend:hide},tab_template;';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['tabType_tabcontrolstart'] = ';{tab_legend},tabClasses;{template_legend:hide},tab_template_start;';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['tabType_tabcontrolstop'] = ';{template_legend:hide},tab_template_stop;';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['tabType_tabcontrol_end'] = ';{template_legend:hide},tab_template_end;';

/*
 * Fields
 */
$GLOBALS['TL_DCA']['tl_content']['fields']['tabType'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['tabType'],
    'default' => 'tabcontroltab',
    'exclude' => true,
    'inputType' => 'radio',
    'options' => ['tabcontroltab', 'tabcontrolstart', 'tabcontrolstop', 'tabcontrol_end'],
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['tabControl'],
    'eval' => [
        'helpwizard' => true,
        'submitOnChange' => true,
        'tl_class' => 'clr',
    ],
    'sql' => "varchar(32) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['tabClasses'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['tabClasses'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => [
        'multiple' => true,
        'size' => 2,
        'rgxp' => 'alnum',
        'tl_class' => 'w50',
    ],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['tabBehaviour'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['tabBehaviour'],
    'exclude' => true,
    'search' => false,
    'inputType' => 'select',
    'options' => ['click', 'mouseover'],
    'default' => 'click',
    'reference' => &$GLOBALS['TL_LANG']['tl_content']['tabControl'],
    'eval' => [
        'helpwizard' => true,
        'tl_class' => 'w50',
    ],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['tab_autoplay_autoSlide'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['tabControl']['tab_autoplay_autoSlide'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50 m12'],
    'sql' => "char(1) NOT NULL default '0'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['tab_autoplay_fade'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['tabControl']['tab_autoplay_fade'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50'],
    'sql' => "char(1) NOT NULL default '0'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['tab_autoplay_delay'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['tabControl']['tab_autoplay_delay'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [
        'mandatory' => true,
        'nospace' => true,
        'rgxp' => 'digit',
        'tl_class' => 'w50',
    ],
    'sql' => "int(10) NOT NULL default '2500'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['tabControlCookies'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['tabControlCookies'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['maxlength' => 128],
    'save_callback' => [
        ['tl_content_tabcontrol', 'generateCookiesName'],
    ],
    'sql' => "varchar(128) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['tab_tabs'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['tab_tabs'],
    'exclude' => true,
    'inputType' => 'multiColumnWizard',
    'eval' => [
        'columnFields' => [
            'tab_tabs_name' => [
                'label' => &$GLOBALS['TL_LANG']['tl_content']['tab_tabs_name'],
                'inputType' => 'text',
                'eval' => ['mandatory' => true, 'style' => 'width:400px', 'allowHtml' => true],
            ],
            'tab_tabs_cookies_value' => [
                'label' => &$GLOBALS['TL_LANG']['tl_content']['tab_tabs_cookies_value'],
                'inputType' => 'text',
                'eval' => ['style' => 'width:75px'],
            ],
            'tab_tabs_default' => [
                'label' => &$GLOBALS['TL_LANG']['tl_content']['tab_tabs_default'],
                'exclude' => true,
                'inputType' => 'checkbox',
                'eval' => ['style' => 'width:40px'],
            ],
        ],
    ],
    'sql' => 'blob NULL',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['tab_template'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['tab_template'],
    'default' => 'ce_tabcontrol_tab',
    'exclude' => true,
    'inputType' => 'select',
    'options_callback' => ['tl_content_tabcontrol', 'getTabcontrolTemplates'],
    'eval' => ['tl_class' => 'w50'],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['tab_template_start'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['tab_template_start'],
    'default' => 'ce_tabcontrol_start',
    'exclude' => true,
    'inputType' => 'select',
    'options_callback' => ['tl_content_tabcontrol', 'getTabcontrolTemplates'],
    'eval' => ['tl_class' => 'w50'],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['tab_template_stop'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['tab_template_stop'],
    'default' => 'ce_tabcontrol_stop',
    'exclude' => true,
    'inputType' => 'select',
    'options_callback' => ['tl_content_tabcontrol', 'getTabcontrolTemplates'],
    'eval' => ['tl_class' => 'w50'],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['tab_template_end'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['tab_template_end'],
    'default' => 'ce_tabcontrol_end',
    'exclude' => true,
    'inputType' => 'select',
    'options_callback' => ['tl_content_tabcontrol', 'getTabcontrolTemplates'],
    'eval' => ['tl_class' => 'w50'],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['tab_remember'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['tab_remember'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'clr'],
    'sql' => "char(1) NOT NULL default ''",
];

/**
 * Class tl_content_tabcontrol.
 */
class tl_content_tabcontrol extends Backend
{
    /**
     * tl_content_tabcontrol constructor.
     */
    public function __construct()
    {
        parent::__construct();
        System::importStatic('BackendUser', 'User');
    }

    /**
     * Return all tabcontrol templates as array.
     *
     * @param DataContainer $dc
     *
     * @return array
     */
    public function getTabcontrolTemplates(DataContainer $dc)
    {
        // Only look for a theme in the article's module (see #4808)
        if ('article' == Input::get('do')) {
            $intPid = $dc->activeRecord->pid;

            if ('overrideAll' == Input::get('act')) {
                $intPid = Input::get('id');
            }

            // Get the page ID
            $objArticle = Database::getInstance()
                ->prepare('SELECT pid FROM tl_article WHERE id=?')
                ->limit(1)
                ->execute($intPid);

            // Inherit the page settings
            $objPage = PageModel::findWithDetails($objArticle->pid);

            // Get the theme ID
            $objLayout = LayoutModel::findByPk($objPage->layout);

            if (null === $objLayout) {
                return [];
            }
        }

        switch ($dc->activeRecord->tabType) {
            case 'tabcontrolstart':
                $templateSnip = 'start';
                break;

            case 'tabcontrolstop':
                $templateSnip = 'stop';
                break;

            case 'tabcontrol_end':
                $templateSnip = 'end';
                break;

            case 'tabcontroltab':
            default:
                $templateSnip = 'tab';
                break;
        }

        return $this->getTemplateGroup('ce_tabcontrol_'.$templateSnip, [$objLayout->pid]);
    }

    /**
     * Auto-generate the cookie name.
     *
     * @param $varValue
     * @param DataContainer $dc
     *
     * @throws Exception
     *
     * @return string
     */
    public function generateCookiesName($varValue, DataContainer $dc)
    {
        $autoAlias = false;

        // Generate alias if there is none
        if ('' == $varValue) {
            $autoAlias = true;
            $varValue = StringUtil::standardize(StringUtil::restoreBasicEntities('tabControllCookie-'.$dc->activeRecord->id));
        }

        $objAlias = Database::getInstance()
            ->prepare('SELECT id FROM tl_content WHERE tabControlCookies=?')
            ->execute($varValue);

        // Check whether the cookies name alias exists
        if ($objAlias->numRows > 1 && !$autoAlias) {
            throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
        }

        // Add ID to cookies name
        if ($objAlias->numRows && $autoAlias) {
            $varValue .= '-'.$dc->id;
        }

        return $varValue;
    }

    /**
     * @param object $dc
     * @return void
     */
    public function showMootoolsHint($dc)
    {
        if ($_POST || Input::get('act') != 'edit') {
            return;
        }

        $objCte = ContentModel::findByPk($dc->id);

        if ($objCte === null) {
            return;
        }

        if ('tabcontrol' === $objCte->type) {
            Message::addInfo($GLOBALS['TL_LANG']['tl_content']['tabControl_mootoolsHint']);
        }
    }
}
