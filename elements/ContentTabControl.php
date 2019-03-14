<?php

/**
 * TabControl
 *
 * @copyright  Christian Barkowsky 2012-2019, Jean-Bernard Valentaten 2009-2012
 * @package    tabControl
 * @author     Christian Barkowsky <http://www.christianbarkowsky.de>, Jean-Bernard Valentaten <troggy.brains@gmx.de>
 * @license    LGPL
 */

namespace Contao;

use Contao\Database;
use Contao\ContentElement;

/**
 * Class ContentTabControl
 * @package Contao
 */
class ContentTabControl extends ContentElement
{

    /**
     * Template
     */
    protected $strTemplate = 'ce_tabcontrol_tab';

    /**
     * Contains the default classes used in our tab-template
     */
    private static $defaultClasses = array('tabs', 'panes');

    /**
     * Generate content element
     */
    protected function compile()
    {
        static $panelIndex = 0;

        $classes = deserialize($this->tabClasses);
        $arrTabTabs = deserialize($this->tab_tabs);

        //default classes if neccessary
        if (\is_array($classes) && !\count($classes)) {
            $classes = self::$defaultClasses;
        } else {
            if (!strlen($classes[0]))
                $classes[0] = self::$defaultClasses[0];
            if (!strlen($classes[1]))
                $classes[1] = self::$defaultClasses[1];
        }

        switch ($this->tabType) {
            // Tabcontrol - start & tabs
            case 'tabcontroltab':
                if (TL_MODE == 'FE') {
                    if (!is_array($GLOBALS['TL_JAVASCRIPT'])) {
                        if (isset($GLOBALS['TL_HOOKS']['tabControlJS']) && is_array($GLOBALS['TL_HOOKS']['tabControlJS'])) {
                            foreach ($GLOBALS['TL_HOOKS']['tabControlJS'] as $callback) {
                                $objCallback = \Contao\System::importStatic($callback[0]);
                                $objCallback->{$callback[1]}();
                            }
                        } else {
                            $GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/tabcontrol/assets/js/moo_tabcontrol.js';
                        }
                    }
                    elseif (!in_array($this->strPlugin, $GLOBALS['TL_JAVASCRIPT'])) {
                        if (isset($GLOBALS['TL_HOOKS']['tabControlJS']) && is_array($GLOBALS['TL_HOOKS']['tabControlJS'])) {
                            foreach ($GLOBALS['TL_HOOKS']['tabControlJS'] as $callback) {
                                $objCallback = \Contao\System::importStatic($callback[0]);
                                $objCallback->{$callback[1]}();
                            }
                        } else {
                            $GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/tabcontrol/assets/js/moo_tabcontrol.js';
                        }
                    }

                    $this->Template = new FrontendTemplate($this->tab_template);
                } else
                {
                    $titleList = '';

                    if(!empty($arrTabTabs))
                    {
                        $counter = 1;
                        foreach($arrTabTabs as $index)
                        {
                            $titleList .= $counter++ . '. ' . $index['tab_tabs_name'] . '<br>';
                        }
                    }

                    $this->Template = new BackendTemplate('be_wildcard');
                    $this->Template->wildcard = '### TABCONTROL: TABGROUP START ###';
                    $this->Template->title = $titleList;
                }
                break;

            // Panel - start
            case 'tabcontrolstart':
                if (TL_MODE == 'FE')
                {
                    $this->Template = new FrontendTemplate($this->tab_template_start);
                    $this->Template->paneindex = ++$panelIndex;
                } else
                {
                    $this->Template = new BackendTemplate('be_wildcard');
                    $this->Template->wildcard = '### TABCONTROL: ' . (++$panelIndex) . '. SECTION START ###';
                }
                break;

            // Panel - stop
            case 'tabcontrolstop':
                if (TL_MODE == 'FE')
                {
                    $this->Template = new FrontendTemplate($this->tab_template_stop);
                } else
                {
                    $this->Template = new BackendTemplate('be_wildcard');
                    $this->Template->wildcard = '### TABCONTROL: ' . $panelIndex . '. SECTION END ###';
                }
                break;

            // Tabcontrol - end
            case 'tabcontrol_end':
            default:
                if (TL_MODE == 'FE')
                {
                    $this->Template = new FrontendTemplate($this->tab_template_end);
                } else {
                    $this->Template = new BackendTemplate('be_wildcard');
                    $this->Template->wildcard = '### TABCONTROL: TABGROUP END ###';
                    $panelIndex = 0;
                }
                break;
        }

        $this->Template->id = $this->id;

        $articleAlias = $this->getArticleAlias($this->pid);
        $this->Template->articleAlias = $articleAlias ? "#" . $articleAlias : ".mod_article";

        $this->Template->behaviour = $this->tabBehaviour;
        $this->Template->panes = $classes[1];
        $this->Template->panesSelector = '.' . str_replace(' ', '.', $classes[1]);
        $this->Template->tabs = $classes[0];
        $this->Template->tabsSelector = '.' . str_replace(' ', '.', $classes[0]);

        if (!empty($arrTabTabs)) {
            $defaultByCookie = '';
            $default = 0;

            foreach ($arrTabTabs as $index => $title)
            {
                $arrTabTitles[] = $title['tab_tabs_name'];

                if($title['tab_tabs_default'])
                {
                    $default = $index;
                }

                if($this->tabControlCookies)
                {
                    if($this->check($title, $this->tabControlCookies))
                    {
                        $defaultByCookie = $index;
                    }
                }
            }

            if ($defaultByCookie != '') {
                $this->Template->tab_tabs_default = $defaultByCookie;
            } else {
                $this->Template->tab_tabs_default = $default;
            }

            $this->Template->titles = $arrTabTitles;
        }

        $this->Template->tab_autoplay_autoSlide = $this->tab_autoplay_autoSlide;
        $this->Template->tab_autoplay_delay = $this->tab_autoplay_delay;
        $this->Template->tab_autoplay_fade = $this->tab_autoplay_fade;
        $this->Template->tab_remember = ($this->tab_remember) ? true : false;
        $this->Template->tabControlCookies = $this->tabControlCookies;
    }


    /**
     * Get article alias
     */
    protected function getArticleAlias($pid)
    {
        $objArticle = Database::getInstance()->prepare("SELECT id, alias FROM tl_article WHERE id=?")->limit(1)->execute($pid);

        if ($objArticle->numRows) {
            return $objArticle->alias;
        }

        return null;
    }


    /**
     * Set default tab by cookie
     */
    protected function check($title, $cookieName)
    {
        $cookieValue = Input::cookie($cookieName);

        if ($cookieValue) {
            if ($title['tab_tabs_cookies_value'] == $cookieValue) {
                return true;
            }
        }

        return false;
    }
}
