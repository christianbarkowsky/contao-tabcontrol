<?php

declare(strict_types=1);

/**
 * Plenta Tab Control Bundle for Contao Open Source CMS
 *
 * @copyright     Copyright (c) 2012-2024, Plenta.io
 * @author        Plenta.io <https://plenta.io>
 * @license       http://opensource.org/licenses/lgpl-3.0.html
 * @link          https://github.com/plenta/
 */

namespace Plenta\TabControl\Controller\Contao\ContentElement;

use Contao\BackendTemplate;
use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\Fragment\Reference\ContentElementReference;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\Database;
use Contao\FrontendTemplate;
use Contao\Input;
use Contao\StringUtil;
use Contao\System;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Symfony\Component\HttpFoundation\RequestStack;

#[AsContentElement('tabcontrol', category:'miscellaneous', nestedFragments: true)]
class TabControlController extends AbstractContentElementController
{
    public function __construct(
        private readonly ContaoFramework $framework,
        protected Packages $packages,
        protected RequestStack $requestStack,
        protected ScopeMatcher $scopeMatcher
    ) {
    }

    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        $elements = [];

        foreach ($template->get('nested_fragments') as $i => $reference) {
            $nestedModel = $reference->getContentModel();

            if (!$nestedModel instanceof ContentModel) {
                $nestedModel = $this->framework->getAdapter(ContentModel::class)->findById($nestedModel);
            }

            $header = StringUtil::deserialize($nestedModel->sectionHeadline, true);

            $elements[] = [
                'header' => $header['value'] ?? '',
                'header_tag' => $header['unit'] ?? 'h2',
                'reference' => $reference,
                'is_open' => !$model->closeSections && 0 === $i,
            ];
        }

        $template->set('elements', $elements);

        return $template->getResponse();
    }
}
