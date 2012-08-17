<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Christian Barkowsky, Mirco Rahn, Jean-Bernard Valentaten 2009-2012
 * @author     Christian Barkowsky <http://www.christianbarkowsky.de>, Jean-Bernard Valentaten <troggy.brains@gmx.de>
 * @package    TabControl
 * @license    GNU/LGPL
 * @filesource
 */


/**
 * Class ContentTabControl
 *
 * @copyright  Christian Barkowsky, Jean-Bernard Valentaten 2009-2012
 * @author     Christian Barkowsky <http://www.christianbarkowsky.de>, Jean-Bernard Valentaten <troggy.brains@gmx.de>
 * @package    Controller
 */
class ContentTabControl extends ContentElement
{
    /**
     * Contains the default classes used in our tab-template
     */
    private static $defaultClasses = array('tabs', 'panes');


    /**
     * Contains the path to the js-plugin needed for Tabcontrols to work
     */
    private $strPlugin = 'plugins/tabcontrol/tabcontrol.js';


    /**
     * The template
     */
    protected $strTemplate = 'ce_tabcontrol_tab';


    /**
     * Generate content element
     */
    protected function compile()
    {
        //init vars
        $classes = deserialize($this->tabClasses); //come all ye classes ;)
        $titles = deserialize($this->tabTitles); //will only be filled when in tab-mode
        static $panelIndex = 0; //static index counter

        //default classes if neccessary
        if (!count($classes))
        {
            $classes = self::$defaultClasses;
        } else
        {
            if (!strlen($classes[0]))
                $classes[0] = self::$defaultClasses[0];
            if (!strlen($classes[1]))
                $classes[1] = self::$defaultClasses[1];
        }

        //take some measures depending on the selected tab type
        switch ($this->tabType)
        {
            case 'tabcontrolstart':
                //start a new panel
                if (TL_MODE == 'FE')
                {
                    $this->strTemplate = 'ce_tabcontrol_start';
                    $this->Template = new FrontendTemplate($this->strTemplate);
                } else
                {
                    $this->strTemplate = 'be_wildcard';
                    $this->Template = new BackendTemplate($this->strTemplate);
                    $this->Template->wildcard = '### TabControl: ' . (++$panelIndex) . '. Pane START ###';
                }
                break;

            case 'tabcontrolstop':
                //stop the current panel
                if (TL_MODE == 'FE')
                {
                    $this->strTemplate = 'ce_tabcontrol_stop';
                    $this->Template = new FrontendTemplate($this->strTemplate);
                } else
                {
                    $this->strTemplate = 'be_wildcard';
                    $this->Template = new BackendTemplate($this->strTemplate);
                    $this->Template->wildcard = '### TabControl: ' . $panelIndex . '. Pane END ###';
                }
                break;

            case 'tabcontroltab':
            default:
                //display some tabs and check whether we need to append our plugin
				if (TL_MODE == 'FE')
				{
					//make sure our plugin will be loaded
					if (!is_array($GLOBALS['TL_JAVASCRIPT']))
					{
						// Hook
						if (isset($GLOBALS['TL_HOOKS']['tabControlJS']) && is_array($GLOBALS['TL_HOOKS']['tabControlJS']))
						{
							foreach ($GLOBALS['TL_HOOKS']['tabControlJS'] as $callback)
							{
								$this->import($callback[0]);
								$this->$callback[0]->$callback[1]();
							}
						}
						else
						{
							$GLOBALS['TL_JAVASCRIPT'] = array($this->strPlugin);
						}
					}
					elseif (!in_array($this->strPlugin, $GLOBALS['TL_JAVASCRIPT']))
					{
						// Hook
						if (isset($GLOBALS['TL_HOOKS']['tabControlJS']) && is_array($GLOBALS['TL_HOOKS']['tabControlJS']))
						{
							foreach ($GLOBALS['TL_HOOKS']['tabControlJS'] as $callback)
							{
								$this->import($callback[0]);
								$this->$callback[0]->$callback[1]();
							}
						}
						else
						{
							$GLOBALS['TL_JAVASCRIPT'][] = $this->strPlugin;
						}
					}

					//finally, we set template
					$this->Template = new FrontendTemplate($this->strTemplate);
                } else
                {
                    $titleList = '';

                    foreach ($titles as $index => $title)
                    {
                        $titleList .=++$index . '. ' . $title . '<br/>';
                    }

                    $this->strTemplate = 'be_wildcard';
                    $this->Template = new BackendTemplate($this->strTemplate);
                    $this->Template->wildcard = '### TabControl: Tabs ###';
                    $this->Template->title = $titleList;
                }
        }

        $articleAlias = $this->getArticleAlias($this->pid);

        //and pass it all to the template
        $this->Template->behaviour = $this->tabBehaviour;
        $this->Template->panes = $classes[1];
        $this->Template->panesSelector = '.' . str_replace(' ', '.', $classes[1]);
        $this->Template->tabs = $classes[0];
        $this->Template->tabsSelector = '.' . str_replace(' ', '.', $classes[0]);
        $this->Template->titles = $titles;
        $this->Template->id = $this->id;
        $this->Template->articleAlias = $articleAlias ? "#" . $articleAlias : ".mod_article";
        $this->Template->tab_autoplay_autoSlide = $this->tab_autoplay_autoSlide;
        $this->Template->tab_autoplay_delay = $this->tab_autoplay_delay;
    }


	/**
	 * Get article alias
	 */
    protected function getArticleAlias($pid)
    {
        $objArticle = $this->Database->prepare("SELECT id, alias FROM tl_article WHERE id=?")->limit(1)->execute($pid);

        if ($objArticle->numRows)
        {
            return $objArticle->alias;
        }

        return null;
    }
}

?>
