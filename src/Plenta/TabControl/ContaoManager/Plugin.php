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

namespace Plenta\TabControl\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Config\ConfigPluginInterface;
use Plenta\TabControl\PlentaTabControlBundle;
use Symfony\Component\Config\Loader\LoaderInterface;

/**
 * Class ContaoManagerPlugin.
 */
class Plugin implements BundlePluginInterface, ConfigPluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(PlentaTabControlBundle::class)
                ->setLoadAfter([
                    ContaoCoreBundle::class,
                ]),
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function registerContainerConfiguration(LoaderInterface $loader, array $managerConfig): void
    {
        $loader->load('@PlentaTabControlBundle/Resources/config/config.php');
    }
}
