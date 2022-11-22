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

namespace Plenta\TabControl\Controller\Contao\ContentElement;

use Contao\BackendTemplate;
use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\Database;
use Contao\FrontendTemplate;
use Contao\Input;
use Contao\StringUtil;
use Contao\System;
use Contao\Template;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Contao\CoreBundle\ServiceAnnotation\ContentElement;

/**
 * @ContentElement("tabcontrol", category="texts", template="ce_tabcontrol_tab")
 */
class TabControlController extends AbstractContentElementController
{
    /**
     * Contains the default classes used in our tab-template.
     */
    private static $defaultClasses = ['tabs', 'panes'];

    protected Packages $packages;

    public function __construct(Packages $packages)
    {
        $this->packages = $packages;
    }

    public function getResponse(Template $template, ContentModel $model, Request $request): ?Response
    {
        static $panelIndex = 0;

        $classes = StringUtil::deserialize($model->tabClasses);
        $arrTabTabs = StringUtil::deserialize($model->tab_tabs);

        //default classes if neccessary
        if (\is_array($classes) && !\count($classes)) {
            $classes = self::$defaultClasses;
        } else {
            if (!is_array($classes)) {
                $classes = [];
            }
            if (empty($classes[0])) {
                $classes[0] = self::$defaultClasses[0];
            }
            if (empty($classes[1])) {
                $classes[1] = self::$defaultClasses[1];
            }
        }

        switch ($model->tabType) {
            // Tabcontrol - start & tabs
            case 'tabcontroltab':
                if (TL_MODE == 'FE') {
                    if (!\is_array($GLOBALS['TL_JAVASCRIPT'])) {
                        if (isset($GLOBALS['TL_HOOKS']['tabControlJS']) && \is_array($GLOBALS['TL_HOOKS']['tabControlJS'])) {
                            foreach ($GLOBALS['TL_HOOKS']['tabControlJS'] as $callback) {
                                $objCallback = System::importStatic($callback[0]);
                                $objCallback->{$callback[1]}();
                            }
                        } else {
                            $GLOBALS['TL_JAVASCRIPT'][] = $this->packages->getVersion('bundles/plenta/tabControl/mooTabControl', 'plenta_tab_control');
                        }
                    } elseif (!\in_array($model->strPlugin, $GLOBALS['TL_JAVASCRIPT'], true)) {
                        if (isset($GLOBALS['TL_HOOKS']['tabControlJS']) && \is_array($GLOBALS['TL_HOOKS']['tabControlJS'])) {
                            foreach ($GLOBALS['TL_HOOKS']['tabControlJS'] as $callback) {
                                $objCallback = System::importStatic($callback[0]);
                                $objCallback->{$callback[1]}();
                            }
                        } else {
                            $GLOBALS['TL_JAVASCRIPT'][] = $this->packages->getVersion('plentatabcontrol/mooTabControl.js', 'plentatabcontrol');
                        }
                    }

                    $template = new FrontendTemplate($model->tab_template);
                } else {
                    $titleList = '';

                    if (!empty($arrTabTabs)) {
                        $counter = 1;

                        foreach ($arrTabTabs as $index) {
                            $titleList .= $counter++.'. '.$index['tab_tabs_name'].'<br>';
                        }
                    }

                    $template = new BackendTemplate('be_wildcard');
                    $template->wildcard = '### TABCONTROL: TABGROUP START ###';
                    $template->title = $titleList;
                }
                break;

            // Panel - start
            case 'tabcontrolstart':
                if (TL_MODE == 'FE') {
                    $template = new FrontendTemplate($model->tab_template_start);
                    $template->paneindex = ++$panelIndex;
                } else {
                    $template = new BackendTemplate('be_wildcard');
                    $template->wildcard = '### TABCONTROL: '.(++$panelIndex).'. SECTION START ###';
                }
                break;

            // Panel - stop
            case 'tabcontrolstop':
                if (TL_MODE == 'FE') {
                    $template = new FrontendTemplate($model->tab_template_stop);
                } else {
                    $template = new BackendTemplate('be_wildcard');
                    $template->wildcard = '### TABCONTROL: '.$panelIndex.'. SECTION END ###';
                }
                break;

            // Tabcontrol - end
            case 'tabcontrol_end':
            default:
                if (TL_MODE == 'FE') {
                    $template = new FrontendTemplate($model->tab_template_end);
                } else {
                    $template = new BackendTemplate('be_wildcard');
                    $template->wildcard = '### TABCONTROL: TABGROUP END ###';
                    $panelIndex = 0;
                }
                break;
        }

        $articleAlias = $this->getArticleAlias($model->pid);
        $modelCssId = StringUtil::deserialize($model->cssID);

        $template->id = $model->id;
        $template->class = trim('ce_'.$model->type. ' '.($modelCssId[1] ?? ''));
        $template->articleAlias = $articleAlias ? '#'.$articleAlias : '.mod_article';
        $template->behaviour = $model->tabBehaviour;
        $template->panes = $classes[1];
        $template->panesSelector = '.'.str_replace(' ', '.', $classes[1]);
        $template->tabs = $classes[0];
        $template->tabsSelector = '.'.str_replace(' ', '.', $classes[0]);

        if (!empty($arrTabTabs)) {
            $defaultByCookie = '';
            $default = 0;

            foreach ($arrTabTabs as $index => $title) {
                $arrTabTitles[] = $title['tab_tabs_name'];

                if ($title['tab_tabs_default']) {
                    $default = $index;
                }

                if ($model->tabControlCookies) {
                    if ($this->check($title, $model->tabControlCookies)) {
                        $defaultByCookie = $index;
                    }
                }
            }

            if ('' != $defaultByCookie) {
                $template->tab_tabs_default = $defaultByCookie;
            } else {
                $template->tab_tabs_default = $default;
            }

            $template->titles = $arrTabTitles;
        }

        $template->tab_remember = (bool) $model->tab_remember;
        return $template->getResponse();
    }

    /**
     * Get article alias.
     *
     * @param mixed $pid
     */
    protected function getArticleAlias($pid)
    {
        $objArticle = Database::getInstance()
            ->prepare('SELECT id, alias FROM tl_article WHERE id=?')
            ->limit(1)
            ->execute($pid);

        if ($objArticle->numRows) {
            return $objArticle->alias;
        }

        return null;
    }

    /**
     * Set default tab by cookie.
     *
     * @param mixed $title
     * @param mixed $cookieName
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
